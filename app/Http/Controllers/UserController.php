<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('transactions')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $users,
        ], 200);
    }

    public function show($id)
    {
        $user = User::with(['transactions.book'])->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ], 200);
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,customer',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        if (auth()->id() === (int)$id && $request->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat mengubah role akun admin Anda sendiri.',
            ], 400);
        }

        $user->update([
            'role' => $request->role,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Role berhasil diperbarui',
            'data' => $user,
        ], 200);
    }
}
