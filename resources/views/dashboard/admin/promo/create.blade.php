@extends('dashboard.layouts.app')

@section('title', 'Tambah Promo Baru - Toko Bunga')

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
    <a href="{{ route('admin.stock') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Stok Bahan
    </a>
    <a href="{{ route('admin.customers') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">
        Pelanggan
    </a>
    <a href="{{ route('admin.promo') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-black border-b-2 border-black">
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.promo') }}" class="text-gray-500 hover:text-gray-700">
                        ← Kembali ke Daftar Promo
                    </a>
                </div>
                <h2 class="text-2xl font-bold text-black mt-4">Tambah Promo Baru</h2>
                <p class="text-gray-600 mt-1">Buat promo atau diskon untuk produk atau kategori</p>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Section -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <form action="{{ route('admin.promo.store') }}" method="POST">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Informasi Promo</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Promo *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Contoh: Diskon Lebaran 50%" required>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Jelaskan detail promo...">{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Promo (Opsional)</label>
                                <input type="text" name="code" id="code" value="{{ old('code') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Kosongkan untuk generate otomatis">
                                <p class="text-sm text-gray-500 mt-1">Jika dikosongkan, kode akan dibuat otomatis</p>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Informasi Diskon</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-2">Tipe Diskon *</label>
                                <select name="discount_type" id="discount_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" required>
                                    <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                                </select>
                            </div>
                            <div>
                                <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2">Nilai Diskon *</label>
                                <input type="number" name="discount_value" id="discount_value" value="{{ old('discount_value') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="50 atau 50000" step="0.01" required>
                                <p class="text-sm text-gray-500 mt-1" id="discount_hint">Masukkan persentase (contoh: 50 untuk 50%)</p>
                            </div>
                            <div>
                                <label for="min_purchase" class="block text-sm font-medium text-gray-700 mb-2">Minimum Pembelian (Opsional)</label>
                                <input type="number" name="min_purchase" id="min_purchase" value="{{ old('min_purchase') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="100000" step="0.01">
                            </div>
                            <div>
                                <label for="max_discount" class="block text-sm font-medium text-gray-700 mb-2">Maksimal Diskon (Opsional)</label>
                                <input type="number" name="max_discount" id="max_discount" value="{{ old('max_discount') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="50000" step="0.01">
                            </div>
                        </div>
                    </div>

                    <!-- Target Promo -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Target Promo</h3>
                        <p class="text-sm text-gray-600 mb-4">Pilih produk atau kategori yang akan diberi promo</p>
                        
                        <!-- Tab untuk Produk dan Kategori -->
                        <div class="mb-4">
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8">
                                    <button type="button" onclick="showProductTab()" id="product-tab" class="py-2 px-1 border-b-2 border-black font-medium text-sm text-black">
                                        Pilih Produk
                                    </button>
                                    <button type="button" onclick="showCategoryTab()" id="category-tab" class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        Pilih Kategori
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Produk Selection -->
                        <div id="product-selection" class="mt-4">
                            <div class="mb-4">
                                <input type="text" id="product-search" placeholder="Cari produk..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-h-96 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                                @forelse($products as $product)
                                    <div class="product-card border-2 border-gray-200 rounded-lg p-3 cursor-pointer hover:border-black transition-colors" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
                                        <input type="radio" name="product_id" id="product_{{ $product->id }}" value="{{ $product->id }}" class="hidden" {{ old('product_id') == $product->id ? 'checked' : '' }}>
                                        <label for="product_{{ $product->id }}" class="cursor-pointer">
                                            @if($product->images && count($product->images) > 0)
                                                <img src="{{ asset($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded mb-2">
                                            @else
                                                <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center">
                                                    <span class="text-gray-400 text-2xl">📦</span>
                                                </div>
                                            @endif
                                            <div class="font-medium text-sm text-black">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col-span-3 text-center text-gray-500 py-8">
                                        Belum ada produk. Silakan tambahkan produk terlebih dahulu.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Kategori Selection -->
                        <div id="category-selection" class="mt-4 hidden">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach($categories as $category)
                                    <div class="category-card border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-black transition-colors" data-category-id="{{ $category->id }}">
                                        <input type="radio" name="category_id" id="category_{{ $category->id }}" value="{{ $category->id }}" class="hidden" {{ old('category_id') == $category->id ? 'checked' : '' }}>
                                        <label for="category_{{ $category->id }}" class="cursor-pointer block text-center">
                                            <div class="text-4xl mb-2">🏷️</div>
                                            <div class="font-medium text-black">{{ $category->name }}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <p class="text-sm text-red-600 mt-4">* Pilih minimal satu produk atau kategori</p>
                    </div>

                    <!-- Period -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Periode Promo</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" required>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir *</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" required>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Status</h3>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" class="text-black focus:ring-black" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Aktifkan promo</span>
                        </label>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.promo') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                            Simpan Promo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Update hint berdasarkan tipe diskon
        document.getElementById('discount_type').addEventListener('change', function() {
            const hint = document.getElementById('discount_hint');
            if (this.value === 'percentage') {
                hint.textContent = 'Masukkan persentase (contoh: 50 untuk 50%)';
            } else {
                hint.textContent = 'Masukkan nominal dalam rupiah (contoh: 50000)';
            }
        });

        // Tab switching
        function showProductTab() {
            document.getElementById('product-selection').classList.remove('hidden');
            document.getElementById('category-selection').classList.add('hidden');
            document.getElementById('product-tab').classList.add('border-black', 'text-black');
            document.getElementById('product-tab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('category-tab').classList.remove('border-black', 'text-black');
            document.getElementById('category-tab').classList.add('border-transparent', 'text-gray-500');
            
            // Uncheck category when switching to product tab
            document.querySelectorAll('input[name="category_id"]').forEach(radio => {
                radio.checked = false;
            });
        }

        function showCategoryTab() {
            document.getElementById('category-selection').classList.remove('hidden');
            document.getElementById('product-selection').classList.add('hidden');
            document.getElementById('category-tab').classList.add('border-black', 'text-black');
            document.getElementById('category-tab').classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('product-tab').classList.remove('border-black', 'text-black');
            document.getElementById('product-tab').classList.add('border-transparent', 'text-gray-500');
            
            // Uncheck product when switching to category tab
            document.querySelectorAll('input[name="product_id"]').forEach(radio => {
                radio.checked = false;
            });
        }

        // Product card selection
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Update card styling
                document.querySelectorAll('.product-card').forEach(c => {
                    c.classList.remove('border-black', 'bg-gray-50');
                    c.classList.add('border-gray-200');
                });
                this.classList.remove('border-gray-200');
                this.classList.add('border-black', 'bg-gray-50');
            });
        });

        // Category card selection
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Update card styling
                document.querySelectorAll('.category-card').forEach(c => {
                    c.classList.remove('border-black', 'bg-gray-50');
                    c.classList.add('border-gray-200');
                });
                this.classList.remove('border-gray-200');
                this.classList.add('border-black', 'bg-gray-50');
            });
        });

        // Product search
        document.getElementById('product-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                const productName = card.getAttribute('data-product-name').toLowerCase();
                if (productName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Highlight selected product/category on load
        document.querySelectorAll('input[name="product_id"]:checked').forEach(radio => {
            const card = radio.closest('.product-card');
            if (card) {
                card.classList.remove('border-gray-200');
                card.classList.add('border-black', 'bg-gray-50');
            }
        });

        document.querySelectorAll('input[name="category_id"]:checked').forEach(radio => {
            const card = radio.closest('.category-card');
            if (card) {
                card.classList.remove('border-gray-200');
                card.classList.add('border-black', 'bg-gray-50');
            }
            showCategoryTab();
        });

        // Validasi: minimal satu produk atau kategori harus dipilih
        document.querySelector('form').addEventListener('submit', function(e) {
            const productId = document.querySelector('input[name="product_id"]:checked');
            const categoryId = document.querySelector('input[name="category_id"]:checked');
            
            if (!productId && !categoryId) {
                e.preventDefault();
                alert('Pilih minimal satu produk atau kategori untuk promo.');
                return false;
            }
        });
    </script>
@endsection

