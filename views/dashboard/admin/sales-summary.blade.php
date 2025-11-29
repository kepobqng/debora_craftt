@extends('dashboard.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-black mb-2">Ringkasan Penjualan</h1>
        <p class="text-gray-600">Hari ini, {{ date('d F Y') }}</p>
    </div>

    <!-- Sales Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Penjualan</p>
                    <p class="text-2xl font-bold text-black">Rp 2.450.000</p>
                    <p class="text-xs text-green-600 mt-1">+12% dari kemarin</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                    <span class="text-white text-xl">💰</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                    <p class="text-2xl font-bold text-black">24</p>
                    <p class="text-xs text-green-600 mt-1">+8 pesanan baru</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                    <span class="text-white text-xl">📦</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Belum Diproses</p>
                    <p class="text-2xl font-bold text-red-600">7</p>
                    <p class="text-xs text-red-600 mt-1">Perlu perhatian</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <span class="text-red-600 text-xl">⏰</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rata-rata Pesanan</p>
                    <p class="text-2xl font-bold text-black">Rp 102.083</p>
                    <p class="text-xs text-gray-500 mt-1">Per pesanan</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                    <span class="text-gray-600 text-xl">📊</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-8">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-black">Produk Paling Laku Hari Ini</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-gray-600">🌹</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-black">Buket Mawar Merah</h3>
                            <p class="text-sm text-gray-600">8 terjual • Rp 150.000</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-black">Rp 1.200.000</p>
                        <p class="text-xs text-green-600">+15%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-gray-600">🌻</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-black">Buket Bunga Matahari</h3>
                            <p class="text-sm text-gray-600">6 terjual • Rp 125.000</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-black">Rp 750.000</p>
                        <p class="text-xs text-green-600">+20%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                            <span class="text-gray-600">🌷</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-black">Buket Tulip Mix</h3>
                            <p class="text-sm text-gray-600">5 terjual • Rp 200.000</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-black">Rp 1.000.000</p>
                        <p class="text-xs text-red-600">-5%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-black">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-black hover:text-gray-700 font-medium">Lihat Semua</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black">#ORD-2024-001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Budi Santoso</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black font-medium">Rp 350.000</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Diproses
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.orders.detail', 1) }}" class="text-black hover:text-gray-700 font-medium">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black">#ORD-2024-002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Siti Nurhaliza</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black font-medium">Rp 275.000</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Selesai
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.orders.detail', 2) }}" class="text-black hover:text-gray-700 font-medium">Detail</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black">#ORD-2024-003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Ahmad Dahlan</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black font-medium">Rp 425.000</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Baru
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.orders.detail', 3) }}" class="text-black hover:text-gray-700 font-medium">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection