@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Keranjang Belanja</h1>

    @if($cartItems->count() > 0)
        <div class="bg-white shadow-lg rounded-2xl p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-3 px-4 text-gray-700">Produk</th>
                        <th class="py-3 px-4 text-gray-700">Harga</th>
                        <th class="py-3 px-4 text-gray-700">Jumlah</th>
                        <th class="py-3 px-4 text-gray-700">Subtotal</th>
                        <th class="py-3 px-4 text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cartItems as $cartItem)
                        @php 
                            $subtotal = $cartItem->product->price * $cartItem->quantity; 
                            $total += $subtotal; 
                        @endphp
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4 px-4 flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                <span class="font-medium text-gray-900">{{ $cartItem->product->name }}</span>
                            </td>
                            <td class="py-4 px-4 text-gray-700">Rp {{ number_format($cartItem->product->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-4 text-gray-700">{{ $cartItem->quantity }}</td>
                            <td class="py-4 px-4 font-semibold text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                <form action="{{ route('cart.remove', $cartItem->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg transition-all duration-200">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end mt-6 space-x-6">
                <div class="text-gray-700 font-semibold text-lg">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="bg-white shadow-lg rounded-2xl p-12 text-center">
            <p class="text-gray-500 text-lg mb-4">Keranjang belanja kosong 😢</p>
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                Kembali Belanja
            </a>
        </div>
    @endif
</div>
@endsection
