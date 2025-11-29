@extends('dashboard.layouts.app')

@section('title', 'Manajemen Stok Bahan - Toko Bunga')

@php
use Illuminate\Support\Str;
@endphp

@section('navigation')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Dashboard
    </a>
    <a href="{{ route('admin.products') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Produk
    </a>
    <a href="{{ route('admin.orders') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Pesanan
    </a>
    <a href="{{ route('admin.stock') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-black border-b-2 border-black">
        Stok Bahan
    </a>
    <a href="{{ route('admin.customers') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Pelanggan
    </a>
    <a href="{{ route('admin.promo') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Promo
    </a>
    <a href="{{ route('admin.reports') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Laporan
    </a>
    <a href="{{ route('admin.settings') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Pengaturan
    </a>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-black">Manajemen Stok Bahan</h2>
                        <p class="text-gray-600 mt-1">Kelola stok bunga segar dan bahan kemasan toko Anda</p>
                    </div>
                    <div class="flex space-x-3">
                        <button class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                            📊 Laporan Stok
                        </button>
                        <button onclick="document.getElementById('addStockModal').classList.remove('hidden')" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                            + Input Stok Masuk
                        </button>
                    </div>
                </div>
            </div>

            @if($lowStockProducts && $lowStockProducts->count() > 0)
            <!-- Stock Alert -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <span class="text-red-600 text-xl mr-3">⚠️</span>
                    <div>
                        <h4 class="font-medium text-red-800">Peringatan Stok Menipis</h4>
                        <p class="text-sm text-red-700">
                            {{ $lowStockProducts->count() }} jenis produk memerlukan perhatian segera: 
                            @foreach($lowStockProducts as $product)
                                {{ $product->name }} ({{ $product->stock }} {{ $product->unit ?? 'unit' }})@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Stock Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
                        <div class="text-sm text-gray-600">Total Produk</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['safe_stock'] }}</div>
                        <div class="text-sm text-gray-600">Stok Aman</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['low_stock'] }}</div>
                        <div class="text-sm text-gray-600">Stok Rendah</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</div>
                        <div class="text-sm text-gray-600">Stok Habis</div>
                    </div>
                </div>
            </div>

            <!-- Filter and Search Section -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('admin.stock') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Bahan</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama bahan..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category" id="categoryFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($allCategories ?? $categories as $category)
                                <option value="{{ $category->slug }}" {{ (request('category') == $category->slug) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Stok</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="safe" {{ request('status') == 'safe' ? 'selected' : '' }}>Aman</option>
                            <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>Rendah</option>
                            <option value="empty" {{ request('status') == 'empty' ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors flex-1">
                            Filter
                        </button>
                        @if(request('category') || request('status') || request('search'))
                        <a href="{{ route('admin.stock') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                            Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Stock Items per Category -->
            @foreach($categories as $category)
                @php
                    $categoryProducts = $productsByCategory[$category->slug] ?? collect();
                @endphp
                
                @if($categoryProducts->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-black">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">Total {{ $categoryProducts->count() }} produk</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Tersedia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($categoryProducts as $product)
                                    @php
                                        $stockStatus = 'safe';
                                        $stockColor = 'green';
                                        $statusBadge = 'bg-green-100 text-green-800';
                                        $statusText = 'Stok Aman';
                                        
                                        if($product->stock == 0) {
                                            $stockStatus = 'empty';
                                            $stockColor = 'red';
                                            $statusBadge = 'bg-red-100 text-red-800';
                                            $statusText = 'Stok Habis';
                                        } elseif($product->stock <= 5) {
                                            $stockStatus = 'low';
                                            $stockColor = 'yellow';
                                            $statusBadge = 'bg-yellow-100 text-yellow-800';
                                            $statusText = 'Stok Rendah';
                                        }
                                    @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-black">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($product->description ?? '', 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-{{ $stockColor }}-600">{{ $product->stock }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product->unit ?? 'unit' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBadge }}">
                                                {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                </td>
                            </tr>
                                @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                @endif
            @endforeach

            @if(!isset($productsByCategory) || collect($productsByCategory)->flatten()->count() == 0)
            <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada produk</h3>
                <p class="text-gray-600">Silakan tambahkan produk terlebih dahulu di halaman Manajemen Produk.</p>
                <a href="{{ route('admin.products.create') }}" class="inline-block mt-4 bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                    Tambah Produk
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div id="addStockModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 text-center">Input Stok Masuk</h3>
                <form class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Bahan</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                            <option value="">Pilih Bahan</option>
                            <option value="mawar-merah">Mawar Merah</option>
                            <option value="mawar-putih">Mawar Putih</option>
                            <option value="kertas-wrapping">Kertas Wrapping Korea</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Masuk</label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Contoh: 50">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga per Satuan</label>
                        <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Contoh: 5000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                        <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Supplier</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Nama supplier">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catatan</label>
                        <textarea rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Catatan tambahan..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="document.getElementById('addStockModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection