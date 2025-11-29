@extends('dashboard.layouts.app')

@section('title', 'Kelola Kategori Produk - Toko Bunga')

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
                        <h2 class="text-2xl font-bold text-black">Kelola Kategori Produk</h2>
                        <p class="text-gray-600 mt-1">Atur dan kategorikan produk toko bunga Anda</p>
                    </div>
                    <a href="{{ route('admin.products') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Kembali ke Produk
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-black">Daftar Kategori</h3>
                            <p class="text-sm text-gray-500">Total {{ $categories->count() }} kategori</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-black">{{ $category->name }}</div>
                                                <div class="text-xs text-gray-500">Slug: {{ $category->slug }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $category->description ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black font-medium">
                                            {{ $category->products_count }} produk
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($category->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('admin.products.categories', ['edit' => $category->id]) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                                <form action="{{ route('admin.products.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">
                                            Belum ada kategori. Tambahkan kategori baru melalui formulir di samping.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Tambah Kategori</h3>
                        <form action="{{ route('admin.products.categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori *</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Slug (opsional)</label>
                                <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="contoh: bunga-segar">
                                <p class="text-xs text-gray-500 mt-1">Jika dikosongkan, slug akan dibuat otomatis.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Jelaskan kategori...">{{ old('description') }}</textarea>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="is_active" id="add_is_active" class="rounded border-gray-300 text-black focus:ring-black" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="add_is_active" class="text-sm text-gray-700">Aktif</label>
                            </div>
                            <button type="submit" class="w-full bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                Simpan Kategori
                            </button>
                        </form>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Edit Kategori</h3>
                        @if($editingCategory)
                            <form action="{{ route('admin.products.categories.update', $editingCategory) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori *</label>
                                    <input type="text" name="name" value="{{ old('name', $editingCategory->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug', $editingCategory->slug) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">{{ old('description', $editingCategory->description) }}</textarea>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" name="is_active" id="edit_is_active" class="rounded border-gray-300 text-black focus:ring-black" {{ old('is_active', $editingCategory->is_active) ? 'checked' : '' }}>
                                    <label for="edit_is_active" class="text-sm text-gray-700">Aktif</label>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="submit" class="flex-1 bg-black text-white py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                        Perbarui
                                    </button>
                                    <a href="{{ route('admin.products.categories') }}" class="flex-1 text-center border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50">
                                        Batal
                                    </a>
                                </div>
                            </form>
                        @else
                            <p class="text-sm text-gray-600">
                                Pilih tombol <span class="font-semibold">Edit</span> pada salah satu kategori untuk mengubah data.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-black">{{ $stats['total'] }}</div>
                        <div class="text-sm text-gray-600">Total Kategori</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['total_products'] }}</div>
                        <div class="text-sm text-gray-600">Total Produk</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['active_percentage'] }}%</div>
                        <div class="text-sm text-gray-600">Kategori Aktif ({{ $stats['active'] }})</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
