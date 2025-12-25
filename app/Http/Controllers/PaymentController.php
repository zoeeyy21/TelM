<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Tampilkan halaman pembayaran
    public function show(Transaction $transaction)
    {
        // Pastikan transaksi milik user
        if($transaction->user_id != Auth::id()) {
            abort(403);
        }

        return view('payment.show', compact('transaction'));
    }

    // Proses pembayaran (mockup)
    public function pay(Transaction $transaction, Request $request)
    {
        if($transaction->user_id != Auth::id()) {
            abort(403);
        }

        // Update status transaksi menjadi 'paid'
        $transaction->update(['status' => 'paid']);

        return redirect()->route('cart.index')->with('success', 'Pembayaran berhasil! Terima kasih.');
    }
}
