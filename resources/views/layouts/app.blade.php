<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TelyuMart</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/logo.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Navbar Shadow */
        .navbar-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Smooth transitions */
        a,
        button {
            transition: all 0.3s ease;
        }

        /* Active link indicator */
        .nav-link.active {
            color: #2563eb;
            border-bottom: 3px solid #2563eb;
        }
    </style>
</head>

<body class="antialiased">
    <!-- Navigation Bar -->
    <nav class="navbar-shadow sticky top-0 z-50 bg-white backdrop-blur-lg bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo Section -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <img src="/logo.png" alt="Logo"
                            class="w-10 h-10 group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <span
                        class="text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent group-hover:from-blue-700 group-hover:to-indigo-800 transition">
                        TelyuMart
                    </span>
                </a>

                <!-- Auth Section -->
                <div class="flex items-center space-x-6">
                    @auth
                        <!-- User Profile Dropdown -->
                        <div class="flex items-center space-x-4">
                            <div
                                class="hidden sm:flex items-center space-x-3 px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100 transition cursor-default">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="text-left hidden md:block">
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ Auth::user()->role }}
                                    </p>
                                </div>
                            </div>

                            <!-- Keranjang -->
                            @if(auth()->user()->role === 'mahasiswa')
                                <a href="{{ route('cart.index') }}" class="relative inline-block">
                                    <svg class="w-6 h-6 text-gray-700 hover:text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13l-1.5-7M7 13h10m-2 0v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5" />
                                    </svg>
                                    @php
                                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                                    @endphp
                                    @if($cartCount > 0)
                                        <span
                                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                                            {{ $cartCount }}
                                        </span>
                                    @endif
                                </a>
                            @endif

                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center space-x-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="hidden sm:inline">Logout</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Non-Auth Links -->
                        <div class="flex items-center space-x-3">
                            @if (Request::is('login'))
                                <a href="/register"
                                    class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    <span>Daftar</span>
                                </a>
                            @else
                                <a href="/login"
                                    class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-1" />
                                    </svg>
                                    <span>Masuk</span>
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600 text-sm">© 2025 TelyuMart. Semua hak dilindungi.</p>
                </div>

            </div>
        </div>
    </footer>
</body>

</html>