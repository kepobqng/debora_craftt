@extends('dashboard.layouts.app')

@section('title', 'Detail Pesanan - Toko Bunga')

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
            <!-- Header -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="flex items-center space-x-4 mb-2">
                            <a href="{{ route('admin.orders') }}" class="text-gray-500 hover:text-gray-700">
                                ← Kembali ke Daftar Pesanan
                            </a>
                        </div>
                        <h2 class="text-2xl font-bold text-black">Detail Pesanan #ORD-2024-001</h2>
                        <p class="text-gray-600 mt-1">Informasi lengkap pesanan Budi Santoso</p>
                    </div>
                    <div class="flex space-x-3">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            📄 Cetak Invoice
                        </button>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            📋 Salin Pesanan
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Status Timeline -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Status Pesanan</h3>
                        <div class="flex items-center justify-between">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mb-2">1</div>
                                <p class="text-sm font-medium text-black">Pesanan Baru</p>
                                <p class="text-xs text-gray-500">25 Nov 2024, 10:30</p>
                            </div>
                            <div class="flex-1 h-1 bg-blue-600 mx-4"></div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold mb-2">2</div>
                                <p class="text-sm font-medium text-gray-500">Diproses</p>
                                <p class="text-xs text-gray-500">-</p>
                            </div>
                            <div class="flex-1 h-1 bg-gray-300 mx-4"></div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold mb-2">3</div>
                                <p class="text-sm font-medium text-gray-500">Dikirim</p>
                                <p class="text-xs text-gray-500">-</p>
                            </div>
                            <div class="flex-1 h-1 bg-gray-300 mx-4"></div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold mb-2">4</div>
                                <p class="text-sm font-medium text-gray-500">Selesai</p>
                                <p class="text-xs text-gray-500">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Detail Produk</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                        <span class="text-gray-500">🌹</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-black">Buket Mawar Merah</p>
                                        <p class="text-sm text-gray-500">1 x Rp 150,000</p>
                                    </div>
                                </div>
                                <p class="font-medium text-black">Rp 150,000</p>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                        <span class="text-gray-500">🎀</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-black">Pita Satin</p>
                                        <p class="text-sm text-gray-500">1 x Rp 15,000</p>
                                    </div>
                                </div>
                                <p class="font-medium text-black">Rp 15,000</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-black font-medium">Rp 165,000</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Ongkir</span>
                                <span class="text-black font-medium">Rp 150,000</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-black">Total</span>
                                <span class="text-lg font-semibold text-black">Rp 315,000</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Informasi Pembayaran</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Metode Pembayaran</p>
                                <p class="font-medium text-black">Transfer Bank (BCA)</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Status Pembayaran</p>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Lunas
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Tanggal Pembayaran</p>
                                <p class="font-medium text-black">25 Nov 2024, 10:45</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Bukti Transfer</p>
                                <a href="#" class="text-blue-600 hover:text-blue-900">Lihat Bukti</a>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Informasi Pengiriman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Jasa Pengiriman</p>
                                <p class="font-medium text-black">Grab Express (Same Day)</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">No. Resi</p>
                                <p class="font-medium text-black">-</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Estimasi Tiba</p>
                                <p class="font-medium text-black">Hari ini, 15:00 - 17:00</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Status</p>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Menunggu Pickup
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Informasi Pelanggan</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Nama</p>
                                <p class="font-medium text-black">Budi Santoso</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Telepon</p>
                                <p class="font-medium text-black">08123456789</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Email</p>
                                <p class="font-medium text-black">budi.santoso@email.com</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Catatan</p>
                                <p class="text-sm text-gray-900">Mohon kirim sebelum jam 14:00, karena mau dijadikan kado ulang tahun.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Alamat Pengiriman</h3>
                        <div class="space-y-2">
                            <p class="font-medium text-black">Rumah</p>
                            <p class="text-sm text-gray-700">
                                Jl. Melati No. 123<br>
                                RT 01 RW 05, Kel. Cipedes<br>
                                Kec. Cipedes, Kota Bandung<br>
                                Jawa Barat 40151
                            </p>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-black mb-4">Aksi Pesanan</h3>
                        <div class="space-y-3">
                            <button class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                🚚 Proses & Kirim
                            </button>
                            <button class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                                📞 Hubungi Pelanggan
                            </button>
                            <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                📝 Tambah Catatan
                            </button>
                            <button class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                ❌ Batalkan Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection