@extends('layouts.app')

@section('title', ($product->name ?? 'Detail Produk') . ' - Debora Craft')

@section('content')
<div class="min-h-screen py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a></li>
                <li>/</li>
                <li><a href="{{ route('kategori') }}" class="hover:text-pink-600">Bunga</a></li>
                <li>/</li>
                <li class="text-gray-900">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid md:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div>
                <div class="mb-4">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset($product->images[0]) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-auto rounded-lg shadow-lg object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-pink-600 text-6xl">🌸</span>
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnail Images -->
                @if($product->images && count($product->images) > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $index => $image)
                        <img src="{{ asset($image) }}" 
                             alt="{{ $product->name }} - Image {{ $index + 1 }}" 
                             class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-75 transition"
                             onclick="changeMainImage('{{ asset($image) }}')">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Information -->
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                @if($product->category)
                <p class="text-sm text-gray-500 mb-4">Kategori: <span class="text-pink-600">{{ $product->category->name }}</span></p>
                @endif

                <!-- Promo Badge -->
                @if(isset($promo) && $promo)
                    <div class="mb-4">
                        <div class="bg-gradient-to-r from-pink-500 to-red-500 text-white px-4 py-2 rounded-lg inline-block">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🎉</span>
                                <div>
                                    <div class="font-bold">{{ $promo->name }}</div>
                                    @if($promo->code)
                                        <div class="text-xs opacity-90">Kode: {{ $promo->code }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Price -->
                <div class="mb-6">
                    @if(isset($discountPrice) && $discountPrice && $discountPrice < $product->price)
                        <div class="flex items-center gap-4 flex-wrap">
                            <span class="text-3xl font-bold text-pink-600">Rp {{ number_format($discountPrice, 0, ',', '.') }}</span>
                            <span class="text-xl text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if(isset($promo))
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                    @if($promo->discount_type === 'percentage')
                                        Diskon {{ $promo->discount_value }}%
                                    @else
                                        Diskon Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                                    @endif
                                </span>
                            @endif
                        </div>
                    @elseif($product->discount_price)
                        <div class="flex items-center gap-4">
                            <span class="text-3xl font-bold text-pink-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="text-xl text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                                Diskon {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                            </span>
                        </div>
                    @else
                        <span class="text-3xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </div>

                <!-- Stock Info -->
                <div class="mb-6">
                    @if($product->stock > 0)
                        <p class="text-green-600 font-medium">✓ Tersedia (Stok: {{ $product->stock }} {{ $product->unit ?? 'pcs' }})</p>
                    @else
                        <p class="text-red-600 font-medium">✗ Stok Habis</p>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Produk</h2>
                    <div class="text-gray-700 leading-relaxed">
                        {!! nl2br(e($product->description ?? 'Deskripsi produk belum tersedia.')) !!}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="addToCart({{ $product->id }})" 
                            class="flex-1 bg-pink-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-pink-700 transition duration-300 flex items-center justify-center gap-3"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        <span class="text-xl">🛒</span>
                        <span>Tambah ke Keranjang</span>
                    </button>
                    <button onclick="buyNow({{ $product->id }})" 
                            class="flex-1 bg-gray-900 text-white px-8 py-4 rounded-lg font-semibold hover:bg-gray-800 transition duration-300"
                            {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        Beli Sekarang
                    </button>
                </div>

                <!-- Product Info -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900">SKU:</span>
                            <span>{{ $product->sku ?? 'N/A' }}</span>
                        </div>
                        @if($product->unit)
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900">Satuan:</span>
                            <span>{{ $product->unit }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function changeMainImage(imageSrc) {
        document.querySelector('.mb-4 img').src = imageSrc;
    }

    function addToCart(productId) {
        @auth
            // User sudah login, tambah ke keranjang dengan AJAX
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
        @else
            // User belum login, redirect ke halaman login dengan return URL
            var currentUrl = window.location.href;
            window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(currentUrl);
        @endauth
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

    function buyNow(productId) {
        @auth
            // User sudah login, bisa langsung checkout
            // TODO: Implement buy now functionality
            alert('Fitur Beli Sekarang akan segera tersedia!');
            // You can redirect to checkout page here
        @else
            // User belum login, redirect ke halaman login dengan return URL
            var currentUrl = window.location.href;
            window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(currentUrl);
        @endauth
    }
</script>
@endpush
@endsection

