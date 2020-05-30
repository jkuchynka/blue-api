<?php

namespace App\Auth;

use App\Auth\Mail\ResetPassword;
use App\Auth\Mail\VerifyEmail;
use App\Auth\Requests\LoginRequest;
use App\Auth\Requests\RegisterRequest;
use App\Auth\Requests\ResetPasswordRequest;
use App\Auth\Requests\SendResetPasswordRequest;
use App\Auth\Requests\ValidateVerifyRequest;
use App\Users\Http\Resources\UserResource;
use App\Users\Models\User;
use Auth;
use Base\Http\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Json;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * User login attempt, generates JWT token
     *
     * @param  LoginRequest $request
     * @return JsonResponse|UserResource
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (! $token = JWTAuth::attempt([
            'email' => $data['email'],
            'password' => $data['password']
        ])) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        return $this->userResource($user, $token);
    }

    /**
     * Build a user resource
     *
     * @param Authenticatable $user
     * @param string|null $token
     * @return UserResource
     */
    protected function userResource(Authenticatable $user, $token)
    {
        $permissions = $user->allPermissions()->map(function ($permission) {
            return $permission->name;
        });
        $roles = $user->roles->map(function ($role) {
            return $role->name;
        });
        $meta = [
            'permissions' => $permissions,
            'roles' => $roles
        ];
        if ($token) {
            $meta['token'] = $token;
        }
        return (new UserResource($user))
            ->additional([
                'meta' => $meta
            ]);
    }

    /**
     * User logout, invalidates JWT token
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'OK',
            'message' => 'Logged out'
        ], 201);
    }

    /**
     * Publicly registers a user.
     * Workflow is:
     * Store as new user with just email
     * Send verify email
     * Verify validates user account and captures new password and name
     * User can then login with password
     *
     * @param  RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make(Str::random(10))
        ]);

        Mail::to([
            ['email' => $user->email]
        ])->send(new VerifyEmail($user));

        return response()->json([
            'status' => 'OK',
            'message' => 'User registered'
        ], 201);
    }

    /**
     * Send reset password email to user
     *
     * @param  SendResetPasswordRequest $request
     * @return JsonResponse
     */
    public function sendResetPassword(SendResetPasswordRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->firstOrFail();

        Mail::to([
            ['email' => $user->email]
        ])->send(new ResetPassword($user));

        return response()->json([
            'status' => 'OK',
            'message' => 'Reset password sent'
        ], 201);
    }

    /**
     * Reset user's password.
     * This can be used by either the register email verification,
     * or the reset password email.
     *
     * @param  ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $user = $data['user'];

        $user->password = Hash::make($data['password']);

        $emailVerified = false;
        if (! $user->email_verified_at) {
            $user->markEmailAsVerified();
            $emailVerified = true;
        }

        $user->save();

        return response()->json([
            'status' => 'OK',
            'message' => $emailVerified ? 'User email verified and password set.' : 'User password set.'
        ], 201);
    }

    /**
     * Validates a verify signed url
     *
     * @param  ValidateVerifyRequest $request
     * @return JsonResponse
     */
    public function validateVerify(ValidateVerifyRequest $request)
    {
        $validated = $request->validated();

        return response()->json([
            'status' => 'OK',
            'message' => 'URL is valid'
        ], 201);
    }

    /**
     * Refresh JWT token
     *
     * @return UserResource
     */
    public function refresh()
    {
        $token = auth()->refresh();
        return $this->userResource(auth()->user(), $token);
    }

    /**
     * Returns the current user logged in or not status
     *
     * @return UserResource|JsonResponse
     */
    public function status()
    {
        $user = auth()->user();

        return $user ? $this->userResource($user, null) : response()->json([
            'data' => [
                'id' => null
            ],
            'meta' => []
        ]);
    }
}
