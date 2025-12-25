@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Kategori Produk</h1>

    @if($categories->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('categories.products', $category->id) }}" class="block bg-white rounded-xl shadow-md hover:shadow-xl transition transform hover:scale-105 p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $category->name }}</h2>
                    <p class="text-gray-500 mt-2">{{ Str::limit($category->description, 50) }}</p>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada kategori.</p>
    @endif
</div>
@endsection
