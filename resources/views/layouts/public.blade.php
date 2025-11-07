<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kost') - {{ config('app.name', 'Kost Management') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800">Kost Management</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600 {{ request()->routeIs('home') ? 'text-green-600 font-semibold' : '' }} transition">
                        Beranda
                    </a>
                    <a href="{{ route('public.rooms.index') }}" class="text-gray-700 hover:text-green-600 {{ request()->routeIs('public.rooms.*') ? 'text-green-600 font-semibold' : '' }} transition">
                        Kamar
                    </a>
                    <a href="{{ route('public.contact') }}" class="text-gray-700 hover:text-green-600 {{ request()->routeIs('public.contact') ? 'text-green-600 font-semibold' : '' }} transition">
                        Kontak
                    </a>
                    <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-gray-200">
            <div class="px-4 py-2 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-green-50 hover:text-green-600 {{ request()->routeIs('home') ? 'bg-green-50 text-green-600' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('public.rooms.index') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-green-50 hover:text-green-600 {{ request()->routeIs('public.rooms.*') ? 'bg-green-50 text-green-600' : '' }}">
                    Kamar
                </a>
                <a href="{{ route('public.contact') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-green-50 hover:text-green-600 {{ request()->routeIs('public.contact') ? 'bg-green-50 text-green-600' : '' }}">
                    Kontak
                </a>
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        </div>
        @endif

        @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg" role="alert">
                {{ session('info') }}
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Tentang Kami</h3>
                    <p class="text-gray-400">
                        Kost Management System - Solusi modern untuk pengelolaan kost boarding house.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Link Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('public.rooms.index') }}" class="text-gray-400 hover:text-white transition">Kamar</a></li>
                        <li><a href="{{ route('public.contact') }}" class="text-gray-400 hover:text-white transition">Kontak</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            +62 xxx xxxx xxxx
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            info@kost.com
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Jakarta, Indonesia
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Kost Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
