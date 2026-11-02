<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    // [ADMIN] Read All Transaksi
    public function index()
    {
        $transactions = Transaction::with(['customer', 'book.author', 'book.genre'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    // [CUSTOMER] Create Transaksi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $transaction = Transaction::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'customer_id' => $request->user()->id,
            'book_id' => $validated['book_id'],
            'total_amount' => $validated['total_amount'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction created successfully',
            'data' => $transaction->load(['customer', 'book'])
        ], 201);
    }

    // [CUSTOMER] Show Detail Transaksi
    public function show(Request $request, $id)
    {
        $transaction = Transaction::with(['customer', 'book'])->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction->customer_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction
        ], 200);
    }

    // [CUSTOMER] Update Transaksi
    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction->customer_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        $validated = $request->validate([
            'book_id' => 'sometimes|exists:books,id',
            'total_amount' => 'sometimes|numeric|min:0',
        ]);

        $transaction->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction updated successfully',
            'data' => $transaction->fresh(['customer', 'book'])
        ], 200);
    }

    // [ADMIN] Destroy Transaksi
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction deleted successfully'
        ], 200);
    }
}