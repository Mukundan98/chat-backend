<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

use App\Models\Message;  // Make sure to import your Message model

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        try {
            // Get the message content from the request
            $messageContent = $request->input('message');

            // Check if the message content is not empty
            if (empty($messageContent)) {
                return response()->json(['status' => 'error', 'message' => 'Message content is empty'], 400);
            }

            // Assuming you have a Message model, create a new message record
            $newMessage = Chat::create([
                'user_id' => 1,
                'message' => $messageContent,
                // Add any additional fields or modifications here
            ]);

            // You can also perform any additional actions or validations here

            return response()->json(['status' => 'success', 'message' => $newMessage], 201);
        } catch (\Exception $e) {
            // Log the error

            // Return an error response with a 500 status code
            return response()->json(['status' => 'error', 'message' => 'Failed to store message'], 500);
        }
    }

    public function getMessages()
    {
        try {
            // Retrieve messages from the database, ordered by creation time
            $messages = Chat::orderBy('created_at', 'asc')->get('message');

            // Return a success response with the retrieved messages
            return response()->json(['status' => 'success', 'messages' => $messages]);
        } catch (\Exception $e) {
            // Log the error

            // Return an error response with a 500 status code
            return response()->json(['status' => 'error', 'message' => 'Failed to retrieve messages'], 500);
        }
    }
}
