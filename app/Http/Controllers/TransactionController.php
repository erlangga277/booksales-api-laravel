<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    public function index(): JsonResponse
    {
        $transactions = Transaction::with(['customer', 'items.book', 'book.author', 'book.genre'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $transactions,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required_without:book_id|array|min:1',
            'items.*.book_id' => 'required_with:items|exists:books,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'book_id' => 'required_without:items|exists:books,id',
            'quantity' => 'nullable|integer|min:1',
            'total_amount' => 'nullable|numeric|min:0',
            'whatsapp_target' => 'nullable|string',
        ]);

        $order = DB::transaction(function () use ($request) {
            $orderNumber = 'BOOK-' . strtoupper(uniqid());
            $calculatedTotal = 0;
            $itemsData = [];

            if ($request->filled('items')) {
                $rawItems = $request->input('items');
            } else {
                $rawItems = [
                    [
                        'book_id' => $request->input('book_id'),
                        'quantity' => $request->input('quantity', 1),
                    ]
                ];
            }

            foreach ($rawItems as $item) {
                $book = Book::lockForUpdate()->findOrFail($item['book_id']);
                $qty = (int) ($item['quantity'] ?? 1);

                if ($book->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok untuk buku '{$book->title}' tidak mencukupi (tersisa {$book->stock}).",
                    ]);
                }

                $subtotal = $book->price * $qty;
                $calculatedTotal += $subtotal;

                $itemsData[] = [
                    'book' => $book,
                    'quantity' => $qty,
                    'price' => $book->price,
                    'subtotal' => $subtotal,
                ];
            }

            $userId = $request->user()->id;

            $transaction = Transaction::create([
                'order_number' => $orderNumber,
                'user_id' => $userId,
                'customer_id' => $userId,
                'total_amount' => $request->filled('total_amount') ? $request->input('total_amount') : $calculatedTotal,
                'payment_method' => 'midtrans',
                'status' => 'pending',
                'book_id' => $itemsData[0]['book']['id'] ?? null,
            ]);

            foreach ($itemsData as $data) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'book_id' => $data['book']->id,
                    'quantity' => $data['quantity'],
                    'price' => $data['price'],
                    'subtotal' => $data['subtotal'],
                ]);
            }

            return [$transaction, $itemsData];
        });

        [$transaction, $itemsData] = $order;

        $midtransItems = array_map(function ($item) {
            return [
                'id' => (string) $item['book']->id,
                'price' => (int) $item['price'],
                'quantity' => (int) $item['quantity'],
                'name' => mb_substr($item['book']->title, 0, 50),
            ];
        }, $itemsData);

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_number,
                'gross_amount' => (int) $transaction->total_amount,
            ],
            'item_details' => $midtransItems,
            'customer_details' => [
                'first_name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
        ];

        $snapToken = $this->midtransService->createSnapToken($params);
        $transaction->update(['snap_token' => $snapToken]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibuat.',
            'data' => [
                'order' => $transaction->load(['items.book', 'customer']),
                'snap_token' => $snapToken,
            ],
        ], 201);
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        $serverKey = config('services.midtrans.server_key');
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        $computedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if ($computedSignature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');
        $paymentType = $request->input('payment_type');

        $transaction = Transaction::with('items')->where('order_number', $orderId)->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        DB::transaction(function () use ($transaction, $transactionStatus, $fraudStatus, $paymentType) {
            $isPaid = false;

            if ($transactionStatus === 'capture') {
                $isPaid = ($fraudStatus === 'accept');
            } elseif ($transactionStatus === 'settlement') {
                $isPaid = true;
            }

            if ($isPaid) {
                if ($transaction->status !== 'paid') {
                    foreach ($transaction->items as $item) {
                        $book = Book::lockForUpdate()->findOrFail($item->book_id);
                        $book->decrement('stock', $item->quantity);
                    }
                    $transaction->update([
                        'status' => 'paid',
                        'payment_method' => $paymentType ?: 'midtrans',
                    ]);
                }
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $transaction->update(['status' => 'failed']);
            } elseif ($transactionStatus === 'pending') {
                $transaction->update(['status' => 'pending']);
            }
        });

        return response()->json(['status' => 'success']);
    }

    public function simulatePaid(int|string $id): JsonResponse
    {
        $transaction = DB::transaction(function () use ($id) {
            $trx = Transaction::with('items')->lockForUpdate()->findOrFail($id);

            if ($trx->status === 'paid') {
                return $trx;
            }

            foreach ($trx->items as $item) {
                $book = Book::lockForUpdate()->findOrFail($item->book_id);

                if ($book->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'stock' => "Gagal melunasi pesanan. Stok buku '{$book->title}' tidak mencukupi.",
                    ]);
                }

                $book->decrement('stock', $item->quantity);
            }

            $trx->update(['status' => 'paid']);

            return $trx;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Simulasi pembayaran berhasil. Transaksi lunas dan stok buku telah diperbarui.',
            'data' => $transaction->fresh(['items.book', 'customer']),
        ], 200);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $transaction = Transaction::with(['customer', 'items.book', 'book'])->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $userId = $request->user()->id;
        if ($transaction->customer_id !== $userId && $transaction->user_id !== $userId && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $transaction,
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction deleted successfully',
        ], 200);
    }
}
