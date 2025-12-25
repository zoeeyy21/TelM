<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Halaman dashboard admin (list produk)
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.index', compact('products'));
    }

    // Form create produk
    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category_id']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category_id']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Produk berhasil dihapus');
    }
}
