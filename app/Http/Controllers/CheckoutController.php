<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request) {
        $cartItems = Auth::user()->cart()->with('product')->get();
        if($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending'
        ]);

        foreach($cartItems as $item) {
            $transaction->details()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

       return redirect()->route('payment.show', $transaction)->with('success', 'Checkout berhasil! Silakan lakukan pembayaran.');

    }
}
