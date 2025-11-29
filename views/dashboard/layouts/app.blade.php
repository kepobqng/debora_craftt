<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Debora Craft - Dashboard</title>

    <!-- Fonts -->
    <style>
        /* Cotoris Font */
        @font-face {
            font-family: 'Cotoris';
            src: url('{{ asset("fonts/Cotoris-Regular.ttf") }}') format('truetype'),
                 url('{{ asset("fonts/Cotoris-Regular.otf") }}') format('opentype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Cotoris';
            src: url('{{ asset("fonts/Cotoris-Bold.ttf") }}') format('truetype'),
                 url('{{ asset("fonts/Cotoris-Bold.otf") }}') format('opentype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Cotoris';
            src: url('{{ asset("fonts/Cotoris-Italic.ttf") }}') format('truetype'),
                 url('{{ asset("fonts/Cotoris-Italic.otf") }}') format('opentype');
            font-weight: 400;
            font-style: italic;
            font-display: swap;
        }

        body {
            font-family: 'Cotoris', sans-serif;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-black">
    <div class="min-h-screen bg-white">
        <!-- Top Bar -->
        <nav class="bg-white border-b border-gray-200">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" class="text-xl font-bold text-black">
                            Debora Craft
                        </a>
                        @if(Auth::user()->role !== 'admin')
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            @yield('navigation')
                        </div>
                        @endif
                    </div>
                    <div class="hidden sm:flex sm:items-center">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content with Sidebar for Admin -->
        @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 border-r border-gray-200 min-h-screen p-4 sticky top-0">
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Dashboard</a>
                    <a href="{{ route('admin.products') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.products*') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Produk</a>
                    <a href="{{ route('admin.orders') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.orders*') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Pesanan</a>
                    <a href="{{ route('admin.stock') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.stock*') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Stok Bahan</a>
                    <a href="{{ route('admin.customers') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.customers') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Pelanggan</a>
                    <a href="{{ route('admin.promo') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.promo') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Promo</a>
                    <a href="{{ route('admin.reports') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Laporan</a>
                    <a href="{{ route('admin.settings') }}" class="block px-3 py-2 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-100' }}">Pengaturan</a>
                </nav>
            </aside>

            <!-- Main -->
            <main class="flex-1">
                <div class="py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="p-6 text-gray-900">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @else
        <!-- Default Content for non-admin -->
        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="p-6 text-gray-900">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @endif
    </div>
</body>
</html>
