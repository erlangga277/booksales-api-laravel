<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $books = Book::all();

        if ($customers->isEmpty() || $books->isEmpty()) {
            return;
        }

        $sampleTransactions = [
            [
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => $customers->first()->id,
                'book_id' => $books->first()->id,
                'total_amount' => $books->first()->price,
            ],
            [
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => $customers->count() > 1 ? $customers[1]->id : $customers->first()->id,
                'book_id' => $books->count() > 1 ? $books[1]->id : $books->first()->id,
                'total_amount' => $books->count() > 1 ? $books[1]->price : $books->first()->price,
            ],
            [
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'customer_id' => $customers->first()->id,
                'book_id' => $books->count() > 2 ? $books[2]->id : $books->first()->id,
                'total_amount' => $books->count() > 2 ? $books[2]->price : $books->first()->price,
            ],
        ];

        foreach ($sampleTransactions as $data) {
            Transaction::updateOrCreate(
                ['order_number' => $data['order_number']],
                $data
            );
        }
    }
}
