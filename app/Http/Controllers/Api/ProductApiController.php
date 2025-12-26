<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    // GET /api/products
    public function index()
    {
        $products = Product::with(['category', 'reviews'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar produk',
            'data' => $products
        ], 200);
    }

    // GET /api/products/{id}
    public function show($id)
    {
        $product = Product::with(['category', 'reviews'])->find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail produk',
            'data' => $product
        ], 200);
    }
}
