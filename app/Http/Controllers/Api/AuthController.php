<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginNotification;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($credentials)) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.'
            ], 401);

        }

        $user = Auth::user();

        // Send notification for Android login
        Mail::to('ultrasonicspeed01@gmail.com')->send(
            new LoginNotification($user->email, 'Phone')
        );

        return response()->json([
            'success' => true,
            'message' => 'Login Successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
}