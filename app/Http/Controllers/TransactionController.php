<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MidtransService;

class TransactionController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtrans = $midtransService;
    }

    public function createTransaction()
    {
        $transactionDetails = [
            'transaction_details' => [
                'order_id' => 'INV-' . rand(100000, 999999),
                'gross_amount' => 10000,
            ],
            'customer_details' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'phone' => '081234567890',
            ],
        ];

        $snapToken = $this->midtrans->getSnapToken($transactionDetails);

        return view('transaction', compact('snapToken'));
    }
}