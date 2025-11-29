@extends('layouts.app')

@section('title', 'Keranjang - Debora Craft')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="min-h-screen py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Keranjang Belanja</h1>
            <nav class="text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a> / 
                <a href="{{ route('kategori') }}" class="hover:text-pink-600">Kategori</a> / 
                <span class="text-gray-900">Keranjang</span>
            </nav>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($cartItems) && $cartItems->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="md:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                <div class="bg-white border border-gray-200 rounded-lg p-6 flex flex-col md:flex-row gap-6">
                    <!-- Product Image -->
                    <div class="w-full md:w-32 h-32 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                        @if($item->product && $item->product->images && count($item->product->images) > 0)
                            <img src="{{ asset($item->product->images[0]) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-pink-600 text-4xl">🌸</span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            <a href="{{ $item->product ? route('product.detail', $item->product->id) : '#' }}" class="hover:text-pink-600">
                                {{ $item->product->name ?? 'Produk tidak tersedia' }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4">
                            {{ Str::limit($item->product->description ?? 'Produk bunga berkualitas tinggi', 100) }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                @if($item->product && $item->product->discount_price)
                                    <span class="text-lg font-bold text-pink-600">Rp {{ number_format($item->product->discount_price, 0, ',', '.') }}</span>
                                    <span class="text-sm text-gray-400 line-through ml-2">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-lg font-bold text-pink-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quantity and Actions -->
                    <div class="flex flex-col items-end justify-between">
                        <form action="{{ route('cart.update', $item->product_id) }}" method="POST" class="mb-4">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center gap-2">
                                <label for="quantity-{{ $item->product_id }}" class="text-sm text-gray-600">Jumlah:</label>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity-{{ $item->product_id }}"
                                       value="{{ $item->quantity }}" 
                                       min="1" 
                                       max="{{ $item->product->stock ?? 999 }}"
                                       class="w-20 border border-gray-300 rounded-lg px-3 py-1 text-center"
                                       onchange="this.form.submit()">
                            </div>
                        </form>

                        <div class="text-right mb-4">
                            <p class="text-sm text-gray-600">Subtotal:</p>
                            <p class="text-lg font-bold text-pink-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('cart.remove', $item->product_id) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                <div class="flex justify-end mt-6">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="md:col-span-1">
                <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-20">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkir:</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total:</span>
                                <span class="text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('user.checkout') }}" class="block w-full bg-pink-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-pink-700 transition duration-300 mb-4">
                        Checkout
                    </a>

                    <a href="{{ route('kategori') }}" class="block w-full bg-gray-100 text-gray-700 text-center px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition duration-300">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🛒</div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-600 mb-8">Mulai berbelanja dan tambahkan produk ke keranjang Anda</p>
            <a href="{{ route('kategori') }}" class="inline-block bg-pink-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-pink-700 transition duration-300">
                Lihat Produk
            </a>
        </div>
        @endif
    </div>
</div>

@endsection

