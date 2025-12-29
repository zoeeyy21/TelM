@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100">
        <!-- Toast Notifications -->
        @if(session('error') || session('success'))
            @php
                $type = session('error') ? 'error' : 'success';
                $message = session($type);
                $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
                $id = $type . 'Message';
                $closeFunction = 'close' . ucfirst($type) . 'Message';
            @endphp

            <div id="{{ $id }}"
                class="fixed top-4 right-4 {{ $bgColor }} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 z-50 animate-slide-in">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ $message }}</span>
                <button class="ml-4" onclick="{{ $closeFunction }}()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <script>
                function {{ $closeFunction }}() {
                    document.getElementById('{{ $id }}').classList.add('opacity-0', 'translate-x-full');
                }
                setTimeout(function () {
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

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Welcome Section -->
            @auth
                <div class="mb-12">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-xl overflow-hidden">
                        <div class="px-6 sm:px-10 py-8 sm:py-12 flex items-center justify-between">
                            <div class="flex-1">
                                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                                    Selamat datang, {{ Auth::user()->name }}! 👋
                                </h1>
                                <p class="text-blue-100 text-lg mb-4">
                                    Jelajahi produk terbaru dan produk berkualitas dari TelyuMart
                                </p>
                                @if (session('status'))
                                    <div
                                        class="inline-block bg-green-400 bg-opacity-20 text-green-50 px-4 py-2 rounded-lg text-sm font-medium">
                                        ✓ {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                                        <div class="hidden sm:block">
                                            <a href="{{ Auth::user()->role === 'superadmin'
                                ? route('superadmin.index')
                                : route('admin.index') }}"
                                                class="inline-flex items-center space-x-2 bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                                </svg>
                                                <span>Kelola Produk</span>
                                            </a>
                                        </div>
                            @endif
                            @if (Auth::user()->role === 'superadmin')
                            <div class="hidden sm:block">
                                <a href="{{ route('admin.index') }}" class="inline-flex items-center space-x-2 bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                    </svg>
                                    <span>Kelola Category</span>
                                </a>
                            </div>
                        @endif
                        </div>
                    </div>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                        <div class="mt-4 sm:hidden">
                            <a href="{{ Auth::user()->role === 'superadmin'
                        ? route('superadmin.index')
                        : route('admin.index') }}"
                                class="block w-full bg-white text-blue-600 hover:bg-slate-50 px-6 py-3 rounded-lg font-semibold text-center transition duration-300">
                                Kelola Produk
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="mb-12">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-xl overflow-hidden">
                        <div class="px-6 sm:px-10 py-12 sm:py-16 text-center">
                            <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">
                                Selamat Datang di TelyuMart
                            </h1>
                            <p class="text-blue-100 text-lg sm:text-xl mb-8 max-w-2xl mx-auto">
                                Temukan produk berkualitas dan baca ulasan jujur dari komunitas Telkom University
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center space-x-2 bg-white text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                                    <span>Masuk Sekarang</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center space-x-2 bg-blue-500 text-white hover:bg-blue-400 px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                                    <span>Daftar Akun</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Products Section -->
            <div class="mb-12">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">Produk Terbaru</h2>
                        <p class="text-gray-600 mt-1">Koleksi produk pilihan terbaru dari kami</p>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse ($products as $product)
                            <a href="{{ route('products.show', $product->id) }}" class="group">
                                <div
                                    class="bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105 overflow-hidden h-full flex flex-col">
                                    <!-- Product Image -->
                                    <div class="relative w-full h-48 bg-gradient-to-br from-slate-100 to-slate-200 overflow-auto">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="w-fit h-fit object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="flex items-center justify-center w-full h-full">
                                                <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-5 flex flex-col flex-1">
                                        <h3
                                            class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition">
                                            {{ $product->name }}
                                        </h3>

                                        <!-- Rating -->
                                        @php
                                            $avgRating = $product->reviews->avg('rating') ?? 0;
                                            $reviewCount = $product->reviews->count();
                                        @endphp
                                        <div class="flex items-center space-x-2 mb-3">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-600 font-medium">
                                                ({{ $reviewCount }})
                                            </span>
                                        </div>

                                        <!-- Description -->
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-1">
                                            {{ Str::limit($product->description, 80) }}
                                        </p>

                                        <!-- Price -->
                                        <div class="pt-4 border-t border-gray-100">
                                            <p class="text-xl font-bold text-blue-600">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- View Button -->
                                        <button
                                            class="mt-4 w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2 rounded-lg transition duration-300 flex items-center justify-center space-x-2">
                                            <span>Lihat Detail</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10" />
                                </svg>
                                <p class="text-gray-600 text-lg font-medium">Belum Ada Produk</p>
                                <p class="text-gray-500 text-sm mt-1">Produk akan segera ditambahkan</p>
                            </div>
                        @endforelse
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-xl shadow-md">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10" />
                        </svg>
                        <p class="text-gray-600 text-lg font-medium">Belum Ada Produk</p>
                        <p class="text-gray-500 text-sm mt-1">Produk akan segera ditambahkan</p>
                    </div>
                @endif
            </div>


        </div>
    </div>
@endsection