<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $message = Message::create([
            'user_id' => $request->user()?->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan Anda berhasil dikirim ke admin!',
            'data' => $message,
        ], 201);
    }

    public function index()
    {
        $messages = Message::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $messages,
        ], 200);
    }

    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pesan tidak ditemukan',
            ], 404);
        }

        $message->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan berhasil dihapus',
        ], 200);
    }
}
