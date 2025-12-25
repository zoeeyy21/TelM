@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-4">Produk: {{ $category->name }}</h1>
    <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline mb-6 inline-block">← Kembali ke Kategori</a>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada produk di kategori ini.</p>
    @endif
</div>
@endsection
