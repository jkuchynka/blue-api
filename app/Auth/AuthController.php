<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Spatie\UrlSigner\MD5UrlSigner;
use JWTAuth;
use Auth;
use App\Users\User;
use App\Mail\Auth\Verify;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        if ( ! $token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        try {
            auth()->invalidate();
            return response()->json([
                'success' => true,
                'message' => 'Logged out'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error logging out',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Publically registers a user.
     * Workflow is:
     * Store as new user with just email
     * Send verify email
     * Verify validates user account and captures new password and name
     * User can then login with password
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users'
        ]);
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt(Str::random(10))
        ]);
        // $user->save();
        Mail::to([
            ['email' => $user->email]
        ])->send(new Verify($user));
        return response()->json($user);
    }

    /**
     * Send reset password link to user's email
     */
    public function requestReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email', $request->email)->firstOrFail();
        $verify = new Verify($user);
        $verify->setType('reset');
        Mail::to([
            ['email' => $user->email]
        ])->send($verify);
        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Reset user's password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'url' => 'required'
        ]);
        $valid = $this->validateUrl($request->url);
        $user = $this->getUserFromSignedUrl($request->url);
        if ($valid && $user) {
            $user->password = bcrypt($request->password);
            $user->markEmailAsVerified();
            return response()->json([
                'message' => 'User email verified and password set.'
            ]);
        }
        return response()->json([
            'message' => 'Invalid URL'
        ], 422);
    }

    /**
     * Validates a verify signed url, used for validating
     * new users and reset passwords
     */
    public function validVerify(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);
        $valid = $this->validateUrl($request->url);
        $user = $this->getUserFromSignedUrl($request->url);
        if ($valid && $user) {
            return response()->json([
                'message' => 'URL is valid.'
            ]);
        }
        return response()->json([
            'message' => 'Invalid URL'
        ], 422);
    }

    /**
     * Verifies email and sets user's password.
     * Can only set password if email hasn't been verified yet.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'url' => 'required'
        ]);
        $valid = $this->validateUrl($request->url);
        $user = $this->getUserFromSignedUrl($request->url);
        if ($valid && $user) {
            $user->password = bcrypt($request->password);
            $user->markEmailAsVerified();
            return response()->json([
                'message' => 'User email verified and password set.'
            ]);
        }
        return response()->json([
            'message' => 'Invalid URL'
        ], 422);
    }

    protected function getUserFromSignedUrl($url)
    {
        $parts = explode('/', explode('?', $url)[0]);
        $userId = array_pop($parts);
        $user = User::find($userId);
        return $user;
    }

    protected function validateUrl($url)
    {
        $signer = new MD5UrlSigner(Config::get('app.url_sign_secret'));
        return $signer->validate($url);
    }
}
