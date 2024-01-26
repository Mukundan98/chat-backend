<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function registerUser(Request $request)
    {
        try {
            $request->validate([
                'user_name' => 'required',
            ]);

            // Enable query log
            DB::enableQueryLog();

            $user = User::where('user_name', $request->input('user_name'))->first();

            if ($user) {
                // User already exists, update timestamps
                if ($user->id !== auth()->id()) {
                    // Log queries before returning a success response
                    info(DB::getQueryLog());
                    return response()->json(['success' => 'User name Updated.'], 200);
                }

                $user->touch();

                // Log queries before returning user data
                info(DB::getQueryLog());

                return response()->json(['user' => $user], 200);
            } else {
                // User doesn't exist, create a new user
                $user = User::create([
                    'user_name' => $request->input('user_name'),
                ]);

                // Log queries before returning user data
                info(DB::getQueryLog());

                return response()->json(['user' => $user], 201);
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Exception during user registration: ' . $e->getMessage());

            // Return a generic error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    // public function updateUser(Request $request, $userId)
    // {
    //     $user = User::find($userId);

    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     $user->update([
    //         'last_seen_at' => now(), // Update last_seen_at with the current timestamp
    //     ]);

    //     return response()->json(['user' => $user], 200);
    // }
}
