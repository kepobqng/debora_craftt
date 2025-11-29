@extends('layouts.app')

@section('title', 'Dashboard - Debora Craft')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- Hero Section - Two Column Layout -->
    <section class="min-h-screen flex hero-background">
        <!-- Left Column - Content -->
        <div class="w-full lg:w-3/5 flex items-center px-8 lg:px-16 py-16 lg:py-24">
            <div class="max-w-2xl">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-6 leading-tight">
                    Selamat datang, {{ Auth::user()->name }}!<br>
                    <span style="color: #EE7FA5;">beautiful flowers</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed">
                    Express your deepest emotions through our handcrafted bouquets, perfect for every special moment and celebration.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('kategori') }}" class="bg-pink-500 text-white px-8 py-4 rounded-lg font-semibold hover:bg-pink-600 transition duration-300 text-center">
                        Explore Bouquet
                    </a>
                    <a href="{{ route('cart') }}" class="bg-transparent border-2 border-pink-500 text-pink-600 px-8 py-4 rounded-lg font-semibold hover:bg-pink-50 transition duration-300 text-center">
                        Lihat Keranjang
                    </a>
                </div>
            </div>
                        </div>

        <!-- Right Column - Image -->
        <div class="hidden lg:flex lg:w-2/5 items-center justify-center p-8 lg:p-16">
            <div class="w-full max-w-md">
                <div class="rounded-2xl shadow-xl overflow-hidden">
                    <img src="{{ asset('img/Beautiful Flower Bouquet.png') }}" 
                         alt="Beautiful Flower Bouquet" 
                         class="w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Produk Terbaru</h2>
                <p class="text-lg text-gray-600">Pilih produk favorit Anda</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if(isset($products) && count($products) > 0)
                    @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <div class="h-64 bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset($product->images[0]) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <span class="text-pink-600 text-4xl" aria-hidden="true">🌸</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($product->description ?? 'Produk bunga berkualitas tinggi', 80) }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    @if($product->discount_price)
                                        <span class="text-lg font-bold text-pink-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                        <span class="text-sm text-gray-400 line-through ml-2">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-lg font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                    </div>
                </div>
                            <div class="flex gap-3">
                                <a href="{{ route('product.detail', $product->id) }}" class="flex-1 text-center text-pink-600 font-medium hover:text-pink-700 border border-pink-600 px-4 py-2 rounded-lg hover:bg-pink-50 transition">
                                    Detail
                                </a>
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="flex-1 bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition duration-300 font-medium"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    Beli
                                </button>
            </div>
        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-600">Belum ada produk tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

@push('scripts')
<script>
    function addToCart(productId) {
        fetch('{{ url("/cart/add") }}/' + productId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => { throw data; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateCartBadge(data.cart_count);
                alert(data.message || 'Produk berhasil ditambahkan ke keranjang!');
            } else {
                alert(data.message || 'Gagal menambahkan produk ke keranjang.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Terjadi kesalahan saat menambahkan produk ke keranjang.');
        });
    }

    function updateCartBadge(count) {
        const cartLink = document.querySelector('a[aria-label="Keranjang"]');
        if (!cartLink) return;

        let cartCountEl = document.getElementById('cart-count');
        if (!cartCountEl) {
            cartCountEl = document.createElement('span');
            cartCountEl.id = 'cart-count';
            cartCountEl.className = 'absolute -top-2 -right-2 bg-pink-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs';
            cartLink.appendChild(cartCountEl);
        }
        cartCountEl.textContent = count;
    }
</script>
@endpush
@endsection