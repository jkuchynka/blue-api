<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Exceptions\JWTException;
use Spatie\UrlSigner\MD5UrlSigner;
use JWTAuth;
use Auth;
use App\User;

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
     * Validates a verify signed url, and that
     * the user hasn't validated yet.
     */
    public function validVerify(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);
        $signer = new MD5UrlSigner(Config::get('app.url_sign_secret'));
        $valid = $signer->validate($request->url);
        $user = $this->getUserFromSignedUrl($request->url);
        if ($valid && $user && ! $user->email_verified_at) {
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
        $user = $this->getUserFromSignedUrl($request->url);
        if ( ! $user->email_verified_at) {
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

    protected function getUserFromSignedUrl ($url)
    {
        $parts = explode('/', explode('?', $url)[0]);
        $userId = array_pop($parts);
        $user = User::find($userId);
        return $user;
    }
}
