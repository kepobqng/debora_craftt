@extends('dashboard.layouts.app')

@section('title', 'Manajemen Pelanggan - Toko Bunga')

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
    <a href="{{ route('admin.customers') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-black border-b-2 border-black">
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
                        <h2 class="text-2xl font-bold text-black">Manajemen Pelanggan</h2>
                        <p class="text-gray-600 mt-1">Kelola data pelanggan dan lihat total pembelian mereka</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-black">{{ $stats['total'] }}</div>
                        <div class="text-sm text-gray-600">Total Pelanggan</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['with_orders'] }}</div>
                        <div class="text-sm text-gray-600">Sudah Berbelanja</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-600">Total Revenue</div>
                    </div>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-black">Daftar Pelanggan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembelian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($customers as $customer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                                @if($customer['profile_photo'])
                                                    <img src="{{ asset($customer['profile_photo']) }}" alt="{{ $customer['name'] }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-gray-500 text-sm font-medium">{{ strtoupper(substr($customer['name'], 0, 1)) }}</span>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-black">{{ $customer['name'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $customer['email'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $customer['created_at']->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-black">{{ $customer['total_orders'] }} pesanan</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-green-600">Rp {{ number_format($customer['total_spent'], 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                        Belum ada pelanggan yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
