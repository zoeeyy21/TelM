@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Pembayaran</h1>

    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4">Rincian Transaksi</h2>
        <ul class="mb-4">
            @foreach($transaction->details as $item)
            <li class="flex justify-between mb-2">
                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
            </li>
            @endforeach
        </ul>
        <div class="flex justify-between font-bold text-lg">
            <span>Total:</span>
            <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($transaction->status === 'pending')
    <form action="{{ route('payment.pay', $transaction) }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition">
            Bayar Sekarang
        </button>
    </form>
    @else
        <div class="bg-blue-100 text-blue-800 px-4 py-3 rounded-lg text-center">
            Transaksi sudah dibayar ✅
        </div>
    @endif
</div>
@endsection
