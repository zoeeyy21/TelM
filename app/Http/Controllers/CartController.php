<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan halaman cart
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    // Tambah ke cart
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $id],
            ['quantity' => 0]
        );

        $cart->quantity += $quantity;
        $cart->save();

        return redirect()->route('cart.index')
            ->with('success', $product->name . ' berhasil ditambahkan ke keranjang.');
    }

    // Hapus dari cart
    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $id)
                    ->first();

        if($cart){
            $cart->delete();
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk dihapus dari keranjang.');
    }

    // Checkout
    public function checkout()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('home')
            ->with('success', 'Checkout berhasil! Terima kasih.');
    }
}
