@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Toast Notifications -->
    @if(session('error') || session('success'))
        @php
            $type = session('error') ? 'error' : 'success';
            $message = session($type);
            $bgColor = $type === 'error' ? 'bg-red-500' : 'bg-green-500';
            $id = $type . 'Message';
            $closeFunction = 'close' . ucfirst($type) . 'Message';
        @endphp

        <div id="{{ $id }}" class="fixed top-4 right-4 {{ $bgColor }} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 z-50 animate-slide-in">
            <span>{{ $message }}</span>
            <button class="ml-4" onclick="{{ $closeFunction }}()">✕</button>
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
    @endif

    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center space-x-1">
                <span>← Kembali</span>
            </a>
        </div>

        <!-- Product Container -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 sm:p-10">
                <!-- Product Image -->
                <div class="flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl overflow-hidden min-h-96">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-fit h-fit object-cover">
                    @else
                        <div class="flex items-center justify-center w-full h-full">
                            <svg class="w-24 h-24 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="flex flex-col justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        
                        <!-- Price Badge -->
                        <div class="mb-6">
                            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <!-- Rating Summary -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            @php
                                $avgRating = $product->reviews->avg('rating') ?? 0;
                                $reviewCount = $product->reviews->count();
                            @endphp
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ number_format($avgRating, 1) }}</span>
                                <span class="text-sm text-gray-500">({{ $reviewCount }} ulasan)</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-2">Deskripsi</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Add to Cart Form -->
                    @auth
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                            @csrf
                            <div class="flex items-center space-x-4 mb-4">
                                <label for="quantity" class="font-medium text-gray-700">Jumlah</label>
                                <input type="number" name="quantity" id="quantity" min="1" value="1" class="w-20 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
                                Tambahkan ke Keranjang
                            </button>
                        </form>

                        <!-- Review Form -->
                        @if(auth()->user()->role == 'mahasiswa' || auth()->user()->role == 'admin')
                            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10 mt-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Bagikan Ulasanmu</h2>
                                <form method="POST" action="{{ route('reviews.store') }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                    
                                    <div>
                                        <label for="rating" class="block text-sm font-semibold text-gray-900 mb-3">Rating Produk</label>
                                        <div class="flex items-center space-x-2">
                                            <select name="rating" id="rating" class="hidden" required>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                            <div id="ratingStars" class="flex items-center space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" class="rating-star w-8 h-8 cursor-pointer" data-value="{{ $i }}">
                                                        <svg class="w-full h-full text-gray-300 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    </button>
                                                @endfor
                                            </div>
                                            <span id="ratingValue" class="ml-2 text-sm font-medium text-gray-600">Pilih rating</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="comment" class="block text-sm font-semibold text-gray-900 mb-2">Komentar (Opsional)</label>
                                        <textarea name="comment" id="comment" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" placeholder="Bagikan pengalamanmu dengan produk ini..."></textarea>
                                    </div>

                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
                                        Kirim Ulasan
                                    </button>
                                </form>

                                <script>
                                    const ratingStars = document.querySelectorAll('.rating-star');
                                    const ratingInput = document.querySelector('select[name="rating"]');
                                    const ratingValue = document.getElementById('ratingValue');

                                    ratingStars.forEach(star => {
                                        star.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            const value = this.dataset.value;
                                            ratingInput.value = value;
                                            ratingValue.textContent = value + ' dari 5';
                                            
                                            ratingStars.forEach(s => {
                                                if (s.dataset.value <= value) {
                                                    s.querySelector('svg').classList.remove('text-gray-300');
                                                    s.querySelector('svg').classList.add('text-yellow-400');
                                                } else {
                                                    s.querySelector('svg').classList.add('text-gray-300');
                                                    s.querySelector('svg').classList.remove('text-yellow-400');
                                                }
                                            });
                                        });
                                    });
                                </script>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="mt-6 inline-block w-full text-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
                            Masuk untuk membeli
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="mt-12 bg-white rounded-2xl shadow-lg p-6 sm:p-10">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pelanggan</h2>
            
            @forelse($product->reviews as $review)
                <div class="mb-6 pb-6 border-b border-gray-200 last:border-b-0 last:mb-0 last:pb-0">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($review->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="text-gray-700 leading-relaxed mt-3">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <p class="mt-4 text-gray-600 text-lg">Belum ada ulasan untuk produk ini</p>
                    <p class="text-gray-500 text-sm mt-1">Jadilah yang pertama untuk memberikan ulasan</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
