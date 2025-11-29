@extends('dashboard.layouts.app')

@section('title', 'Edit Produk - Toko Bunga')

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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.products') }}" class="text-gray-500 hover:text-gray-700">
                        ← Kembali ke Daftar Produk
                    </a>
                </div>
                <h2 class="text-2xl font-bold text-black mt-4">Edit Produk</h2>
                <p class="text-gray-600 mt-1">Perbarui informasi produk bunga atau aksesoris</p>
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

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Section -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Informasi Dasar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk *</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Contoh: Buket Mawar Merah" required>
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                                <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" required>
                                    <option value="">Pilih Kategori</option>
                                    @forelse($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @empty
                                        <option value="" disabled>Kategori belum tersedia. Silakan tambahkan kategori terlebih dahulu.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga *</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="150000" required>
                            </div>
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok *</label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="10" required>
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Produk</label>
                            <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Jelaskan detail produk Anda...">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Foto Produk</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            @php
                                // Ambil gambar yang sudah ada dari database
                                $existingImages = $product->images ?? [];
                                // Pastikan $existingImages adalah array
                                if (!is_array($existingImages)) {
                                    $existingImages = [];
                                }
                            @endphp
                            <!-- Foto 1 -->
                            <div class="relative">
                                <label for="image_1" class="cursor-pointer">
                                    <div id="preview_1" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors">
                                        <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center mb-2 overflow-hidden">
                                            @if(isset($existingImages[0]) && !empty($existingImages[0]))
                                                <img id="img_1" src="{{ asset($existingImages[0]) }}" alt="Preview" class="w-full h-full object-cover">
                                                <span id="icon_1" class="hidden text-gray-400 text-4xl">📷</span>
                                            @else
                                                <span id="icon_1" class="text-gray-400 text-4xl">📷</span>
                                                <img id="img_1" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <input type="file" name="images[]" id="image_1" accept="image/*" class="hidden" onchange="previewImage(this, 1)">
                                        <p class="text-xs text-gray-500 mt-1">Foto Utama</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik untuk upload</p>
                                    </div>
                                </label>
                                @if(isset($existingImages[0]) && !empty($existingImages[0]))
                                    <button type="button" id="remove_1" onclick="removeImage(1)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @else
                                    <button type="button" id="remove_1" onclick="removeImage(1)" class="hidden absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @endif
                            </div>
                            <!-- Foto 2 -->
                            <div class="relative">
                                <label for="image_2" class="cursor-pointer">
                                    <div id="preview_2" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors">
                                        <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center mb-2 overflow-hidden">
                                            @if(isset($existingImages[1]) && !empty($existingImages[1]))
                                                <img id="img_2" src="{{ asset($existingImages[1]) }}" alt="Preview" class="w-full h-full object-cover">
                                                <span id="icon_2" class="hidden text-gray-400 text-4xl">📷</span>
                                            @else
                                                <span id="icon_2" class="text-gray-400 text-4xl">📷</span>
                                                <img id="img_2" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <input type="file" name="images[]" id="image_2" accept="image/*" class="hidden" onchange="previewImage(this, 2)">
                                        <p class="text-xs text-gray-500 mt-1">Foto 2</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik untuk upload</p>
                                    </div>
                                </label>
                                @if(isset($existingImages[1]) && !empty($existingImages[1]))
                                    <button type="button" id="remove_2" onclick="removeImage(2)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @else
                                    <button type="button" id="remove_2" onclick="removeImage(2)" class="hidden absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @endif
                            </div>
                            <!-- Foto 3 -->
                            <div class="relative">
                                <label for="image_3" class="cursor-pointer">
                                    <div id="preview_3" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors">
                                        <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center mb-2 overflow-hidden">
                                            @if(isset($existingImages[2]) && !empty($existingImages[2]))
                                                <img id="img_3" src="{{ asset($existingImages[2]) }}" alt="Preview" class="w-full h-full object-cover">
                                                <span id="icon_3" class="hidden text-gray-400 text-4xl">📷</span>
                                            @else
                                                <span id="icon_3" class="text-gray-400 text-4xl">📷</span>
                                                <img id="img_3" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <input type="file" name="images[]" id="image_3" accept="image/*" class="hidden" onchange="previewImage(this, 3)">
                                        <p class="text-xs text-gray-500 mt-1">Foto 3</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik untuk upload</p>
                                    </div>
                                </label>
                                @if(isset($existingImages[2]) && !empty($existingImages[2]))
                                    <button type="button" id="remove_3" onclick="removeImage(3)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @else
                                    <button type="button" id="remove_3" onclick="removeImage(3)" class="hidden absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @endif
                            </div>
                            <!-- Foto 4 -->
                            <div class="relative">
                                <label for="image_4" class="cursor-pointer">
                                    <div id="preview_4" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-gray-400 transition-colors">
                                        <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center mb-2 overflow-hidden">
                                            @if(isset($existingImages[3]) && !empty($existingImages[3]))
                                                <img id="img_4" src="{{ asset($existingImages[3]) }}" alt="Preview" class="w-full h-full object-cover">
                                                <span id="icon_4" class="hidden text-gray-400 text-4xl">📷</span>
                                            @else
                                                <span id="icon_4" class="text-gray-400 text-4xl">📷</span>
                                                <img id="img_4" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <input type="file" name="images[]" id="image_4" accept="image/*" class="hidden" onchange="previewImage(this, 4)">
                                        <p class="text-xs text-gray-500 mt-1">Foto 4</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik untuk upload</p>
                                    </div>
                                </label>
                                @if(isset($existingImages[3]) && !empty($existingImages[3]))
                                    <button type="button" id="remove_4" onclick="removeImage(4)" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @else
                                    <button type="button" id="remove_4" onclick="removeImage(4)" class="hidden absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">×</button>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Format: JPG, PNG, GIF. Maksimal 2MB per foto. Klik area upload untuk memilih foto.</p>
                    </div>

                    <!-- Product Specifications -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Spesifikasi Produk</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Berat (gram)</label>
                                <input type="number" name="weight" id="weight" value="{{ old('weight', $product->weight) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="500">
                            </div>
                            <div>
                                <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-2">Dimensi (cm)</label>
                                <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions', $product->dimensions) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="P x L x T">
                            </div>
                            <div>
                                <label for="material" class="block text-sm font-medium text-gray-700 mb-2">Bahan/Material</label>
                                <input type="text" name="material" id="material" value="{{ old('material', $product->material) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Contoh: Mawar import, kertas korea">
                            </div>
                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                                <input type="text" name="color" id="color" value="{{ old('color', $product->color) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Contoh: Merah, Pink, Putih">
                            </div>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">SEO & Metadata</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Title untuk SEO">
                            </div>
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="Description untuk SEO">{{ old('meta_description', $product->meta_description) }}</textarea>
                            </div>
                            <div>
                                <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags/Keywords</label>
                                <input type="text" name="tags" id="tags" value="{{ old('tags', $product->tags) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black" placeholder="buket bunga, mawar merah, kado ulang tahun">
                                <p class="text-sm text-gray-500 mt-1">Pisahkan dengan koma</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product Flags -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-black mb-4">Pengaturan Tampilan</h3>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" class="text-black focus:ring-black" {{ $product->is_active ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Tampilkan produk</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_featured" class="text-black focus:ring-black" {{ $product->is_featured ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Jadikan unggulan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.products') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                            Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simpan gambar yang sudah ada untuk referensi
        const existingImages = {
            1: @json(isset($existingImages[0]) && !empty($existingImages[0]) ? $existingImages[0] : null),
            2: @json(isset($existingImages[1]) && !empty($existingImages[1]) ? $existingImages[1] : null),
            3: @json(isset($existingImages[2]) && !empty($existingImages[2]) ? $existingImages[2] : null),
            4: @json(isset($existingImages[3]) && !empty($existingImages[3]) ? $existingImages[3] : null),
        };
        
        function previewImage(input, number) {
            const file = input.files[0];
            const preview = document.getElementById('img_' + number);
            const icon = document.getElementById('icon_' + number);
            const removeBtn = document.getElementById('remove_' + number);
            
            if (file) {
                const reader = new FileReader();
                
                // Validasi ukuran file (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB per foto.');
                    input.value = '';
                    return;
                }
                
                // Validasi tipe file
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar (JPG, PNG, GIF)');
                    input.value = '';
                    return;
                }
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    icon.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                };
                
                reader.readAsDataURL(file);
            }
        }
        
        function removeImage(number) {
            const input = document.getElementById('image_' + number);
            const preview = document.getElementById('img_' + number);
            const icon = document.getElementById('icon_' + number);
            const removeBtn = document.getElementById('remove_' + number);
            
            // Reset input file
            input.value = '';
            
            // Reset preview ke placeholder
            preview.src = '';
            preview.classList.add('hidden');
            icon.classList.remove('hidden');
            removeBtn.classList.add('hidden');
            
            // Tandai bahwa gambar ini akan dihapus dengan menambahkan hidden input
            // (jika diperlukan untuk backend)
            const deleteInput = document.getElementById('delete_image_' + number);
            if (!deleteInput && existingImages[number]) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'delete_images[]';
                hiddenInput.id = 'delete_image_' + number;
                hiddenInput.value = existingImages[number];
                input.parentElement.appendChild(hiddenInput);
            }
        }
    </script>
@endsection
