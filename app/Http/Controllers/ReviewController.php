<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($request->product_id);

        // 1. Simpan review baru ke dalam tabel reviews
        $review = new Review([
            //isi disini
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        $product->reviews()->save($review);

        session()->flash('success', 'Review berhasil ditambahkan!');
        return redirect()->route('products.show', $product->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // not used
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        // 2. Cari review berdasarkan id
        $productId = $review->product_id;
        //3. delete review
        $review->delete();


        session()->flash('success', 'Review berhasil dihapus!');
        return redirect()->route('products.show', ['product' => $productId]);
    }
}
