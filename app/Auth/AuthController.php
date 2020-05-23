<?php

namespace App\Auth;

use App\Auth\Mail\ResetPassword;
use App\Auth\Mail\VerifyEmail;
use App\Auth\Requests\LoginRequest;
use App\Auth\Requests\RegisterRequest;
use App\Auth\Requests\ResetPasswordRequest;
use App\Auth\Requests\SendResetPasswordRequest;
use App\Auth\Requests\ValidateVerifyRequest;
use App\Users\User;
use Auth;
use Base\Http\Controller;
use JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * User login attempt, generates JWT token
     *
     * @param  LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        if ( ! $token = JWTAuth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password']
        ])) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * User logout, invalidates JWT token
     *
     * @return Response
     */
    public function logout()
    {
        // dd(auth()->user());
        auth()->invalidate();

        return response()->json([
            'status' => 'OK',
            'message' => 'Logged out'
        ], 201);
    }

    /**
     * Publically registers a user.
     * Workflow is:
     * Store as new user with just email
     * Send verify email
     * Verify validates user account and captures new password and name
     * User can then login with password
     *
     * @param  RegisterRequest $request
     * @return Response
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
     * @return Response
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
     * @return Response
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
     * @return Response
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
     * Returns the current user logged in or not status
     *
     * @return Response
     */
    public function status()
    {
        $user = auth()->user();

        return $user ? response()->json($user) : response()->json([
            'id' => null
        ]);
    }
}
