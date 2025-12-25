@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Toast Notifications -->
    @if(session('error') || session('success'))
        @php
            $type = session('error') ? 'error' : 'success';
            $message = session($type);
            $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
            $id = $type . 'Message';
            $closeFunction = 'close' . ucfirst($type) . 'Message';
        @endphp

        <div id="{{ $id }}" class="fixed top-20 right-4 {{ $bgColor }} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 z-50 animate-slide-in">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $message }}</span>
            <button class="ml-4 hover:opacity-75" onclick="{{ $closeFunction }}()">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>

        <script>
            function {{ $closeFunction }}() {
                document.getElementById('{{ $id }}').classList.add('opacity-0', 'translate-x-full');
            }
            setTimeout(function() {
                var el = document.getElementById('{{ $id }}');
                if (el) el.classList.add('opacity-0', 'translate-x-full');
            }, 5000);
        </script>

        <style>
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(400px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }
        </style>
    @endif

    <!-- Header Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 sm:px-10 py-8 sm:py-12">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">Manajemen Produk</h1>
                        <p class="text-blue-100 text-lg">Kelola semua produk Anda dengan mudah dan efisien</p>
                    </div>
                    <a href="{{ route('admin.create') }}" class="hidden sm:inline-flex items-center space-x-2 bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Tambah Produk</span>
                    </a>
                </div>

                <!-- Mobile Button -->
                <div class="sm:hidden mt-6">
                    <a href="{{ route('admin.create') }}" class="block w-full bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold text-center transition duration-300">
                        + Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Products Grid -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($products->count() > 0)
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Produk</h2>
                <p class="text-gray-600 text-sm mt-1">Kelola, edit, atau hapus produk sesuai kebutuhan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                @foreach ($products as $product)
                    <div class="group bg-white border border-gray-200 rounded-xl hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                        <!-- Product Image -->
                        <div class="relative w-full h-48 bg-gradient-to-br from-slate-100 to-slate-200 overflow-auto">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-fit h-fit object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="flex items-center justify-center w-full h-full">
                                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                {{ $product->name }}
                            </h3>

                            <!-- Price -->
                            <p class="text-2xl font-bold text-blue-600 mb-3">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-1">
                                {{ Str::limit($product->description, 80) }}
                            </p>

                            <!-- Action Buttons -->
                            <div class="pt-4 border-t border-gray-100 flex gap-2">
                                <a href="{{ route('admin.edit', $product) }}" class="flex-1 inline-flex items-center justify-center space-x-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Edit</span>
                                </a>

                                <a href="{{ route('products.show', $product->id) }}" class="flex-1 inline-flex items-center justify-center space-x-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>Lihat</span>
                                </a>

                                <form action="{{ route('admin.destroy', $product) }}" method="POST" class="inline-flex flex-1" onsubmit="return confirm('Hapus produk ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex items-center justify-center space-x-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="px-6 py-16 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10"/>
                </svg>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak Ada Produk</h3>
                <p class="text-gray-600 mb-6">Mulai tambahkan produk baru untuk memulai bisnis Anda</p>
                <a href="{{ route('admin.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Produk Pertama</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection