<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Debora Craft - Toko Bunga Online')</title>
    <!-- Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
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
        .hero-background {
            background-image: url('{{ asset("img/background.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }
        
        .profile-dropdown-menu {
            pointer-events: none;
        }
        
        .profile-dropdown:hover .profile-dropdown-menu {
            pointer-events: auto;
        }
    </style>
    @stack('styles')
</head>
<body class="{{ request()->routeIs('home') ? '' : 'bg-white' }}">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Debora Craft Logo" class="h-10 w-10 object-contain">
                    </a>
                    <a href="{{ route('home') }}" class="text-xl font-semibold text-gray-800">Debora Craft</a>
                </div>
                
                <!-- Menu -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-gray-800 border-b-2 border-pink-600' : 'text-gray-600 hover:text-pink-600' }} px-1 pt-1 text-sm font-medium transition">Beranda</a>
                    <a href="{{ route('kategori') }}" class="{{ request()->routeIs('kategori') ? 'text-gray-800 border-b-2 border-pink-600' : 'text-gray-600 hover:text-pink-600' }} px-1 pt-1 text-sm font-medium transition">Kategori</a>
                    <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'text-gray-800 border-b-2 border-pink-600' : 'text-gray-600 hover:text-pink-600' }} px-1 pt-1 text-sm font-medium transition">Tentang</a>
                </div>
                
                <!-- Icons -->
                <div class="flex items-center space-x-4">
                    @auth
                        @php
                            $cartSummary = Auth::user()
                                ->cart()
                                ->withSum('items as items_quantity_sum', 'quantity')
                                ->first();
                            $navCartCount = optional($cartSummary)->items_quantity_sum ?? 0;
                        @endphp
                        <a href="{{ route('cart') }}" class="text-gray-600 hover:text-pink-600 relative text-lg" aria-label="Keranjang">
                            🛒
                            @if($navCartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-pink-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs" id="cart-count">{{ $navCartCount }}</span>
                            @endif
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-pink-600 relative text-lg" aria-label="Keranjang">
                            🛒
                        </a>
                    @endauth
                    
                    @auth
                        <!-- Profile Photo Dropdown -->
                        <div class="relative profile-dropdown group">
                            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" 
                               class="flex items-center space-x-2 cursor-pointer">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="h-10 w-10 rounded-full object-cover border-2 border-pink-500">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-pink-500 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </a>
                            <!-- Dropdown Menu -->
                            <div class="profile-dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-200">
                                <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                                    Dashboard
                                </a>
                                <a href="{{ Auth::user()->role === 'admin' ? route('admin.settings') : route('user.profile') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                                    Profile
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" 
                           class="text-gray-600 hover:text-pink-600 px-4 py-2 text-sm font-medium border border-gray-300 rounded-md hover:border-pink-500 transition">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        @php
            // Ambil kategori dari database
            $footerCategories = \App\Models\Category::whereIn('slug', ['bunga', 'aksesoris', 'gift-set'])
                ->where('is_active', true)
                ->orderByRaw("FIELD(slug, 'bunga', 'aksesoris', 'gift-set')")
                ->get();
            
            $whatsappNumber = '6285754336802';
            $whatsappUrl = 'https://wa.me/' . $whatsappNumber;
            $instagramUrl = 'https://instagram.com/debora.craft_';
            $gmailAddress = 'deboracraft@gmail.com';
            $gmailUrl = 'mailto:' . $gmailAddress;
        @endphp
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Debora Craft</h3>
                    <p class="text-gray-400">Toko bunga online terpercaya dengan koleksi bunga segar berkualitas tinggi.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Produk</h4>
                    <ul class="space-y-2 text-gray-400">
                        @forelse($footerCategories as $category)
                            <li>
                                <a href="{{ route('kategori') }}#{{ $category->slug }}" class="hover:text-white transition">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li><a href="{{ route('kategori') }}" class="hover:text-white transition">Bunga</a></li>
                            <li><a href="{{ route('kategori') }}" class="hover:text-white transition">Aksesoris</a></li>
                            <li><a href="{{ route('kategori') }}" class="hover:text-white transition">Gift Set</a></li>
                        @endforelse
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>
                            <a href="{{ $whatsappUrl }}" target="_blank" class="hover:text-white transition">
                                Pengiriman Cepat
                            </a>
                        </li>
                        <li>
                            <a href="{{ $whatsappUrl }}" target="_blank" class="hover:text-white transition">
                                Custom Design
                            </a>
                        </li>
                        <li>
                            <a href="{{ $whatsappUrl }}" target="_blank" class="hover:text-white transition">
                                Event Decoration
                            </a>
                        </li>
                        <li>
                            <a href="{{ $whatsappUrl }}" target="_blank" class="hover:text-white transition">
                                Konsultasi Gratis
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                    <div class="flex space-x-4">
                        <a href="https://facebook.com" target="_blank" class="text-gray-400 hover:text-white transition" aria-label="Facebook">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="{{ $instagramUrl }}" target="_blank" class="text-gray-400 hover:text-white transition" aria-label="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.192 3.192 0 00-.748-1.15 3.192 3.192 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="{{ $whatsappUrl }}" target="_blank" class="text-gray-400 hover:text-white transition" aria-label="WhatsApp">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                        <a href="{{ $gmailUrl }}" class="text-gray-400 hover:text-white transition" aria-label="Gmail">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Debora Craft. Hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

