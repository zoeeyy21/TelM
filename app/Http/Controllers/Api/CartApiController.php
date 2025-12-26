<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartApiController extends Controller
{
    public function index()
    {
        return Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ],
            ['quantity' => 0]
        );

        $cart->increment('quantity');

        return response()->json([
            'message' => 'Produk ditambahkan ke keranjang'
        ]);
    }

    public function destroy($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'message' => 'Produk dihapus dari keranjang'
        ]);
    }
}
