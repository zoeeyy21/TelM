<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::with('reviews')
            ->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->latest()
            ->get();

        return view('home', compact('products', 'categories'));
    }
}
