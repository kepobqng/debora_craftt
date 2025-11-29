@extends('dashboard.layouts.app')

@section('navigation')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-black border-b-2 border-black">
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
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-black">Ringkasan</h1>
                <div class="flex items-center space-x-3">
                    <input type="text" placeholder="Cari" class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-black focus:border-black w-64">
                    <button class="border border-gray-300 rounded-md py-2 px-3 text-sm">30 Hari</button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <p class="text-sm text-gray-600">Total Revenue</p>
                <div class="mt-2 text-2xl font-bold text-black">Rp {{ number_format(($salesToday ?? 0), 0, ',', '.') }}</div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <p class="text-sm text-gray-600">Total Order</p>
                <div class="mt-2 text-2xl font-bold text-black">{{ $totalOrders ?? 0 }}</div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <p class="text-sm text-gray-600">Total Customer</p>
                <div class="mt-2 text-2xl font-bold text-black">0</div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <p class="text-sm text-gray-600">Pending Delivery</p>
                <div class="mt-2 text-2xl font-bold text-black">0</div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-black">Sales Analytic</h2>
                    <div class="text-sm text-gray-500">Jul</div>
                </div>
                <div class="h-64 bg-gray-50 border border-dashed border-gray-200 rounded-lg flex items-center justify-center text-gray-400">Grafik penjualan</div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-bold text-black mb-4">Sales Target</h2>
                <div class="h-64 bg-gray-50 border border-dashed border-gray-200 rounded-full flex items-center justify-center text-gray-400">Target</div>
                <div class="mt-4 text-sm text-gray-600">Daily Target: 0</div>
                <div class="text-sm text-gray-600">Monthly Target: 0</div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-black">Top Selling Products</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="h-32 bg-gray-100"></div>
                        <div class="p-4">
                            <div class="text-sm font-medium text-black">Produk A</div>
                            <div class="text-xs text-gray-500">0 pcs</div>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="h-32 bg-gray-100"></div>
                        <div class="p-4">
                            <div class="text-sm font-medium text-black">Produk B</div>
                            <div class="text-xs text-gray-500">0 pcs</div>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <div class="h-32 bg-gray-100"></div>
                        <div class="p-4">
                            <div class="text-sm font-medium text-black">Produk C</div>
                            <div class="text-xs text-gray-500">0 pcs</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-bold text-black mb-4">Current Offer</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm">
                            <span>Diskon 40%</span>
                            <span class="text-gray-500">Expire</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded">
                            <div class="h-2 bg-black rounded" style="width: 40%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm">
                            <span>Kupon 100 Taka</span>
                            <span class="text-gray-500">Expire</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded">
                            <div class="h-2 bg-black rounded" style="width: 20%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm">
                            <span>Stock Out Sell</span>
                            <span class="text-gray-500">Upcoming</span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded">
                            <div class="h-2 bg-black rounded" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
