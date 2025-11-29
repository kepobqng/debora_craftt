@extends('dashboard.layouts.app')

@section('title', 'Manajemen Pesanan - Toko Bunga')

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
    <a href="{{ route('admin.orders') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-black border-b-2 border-black">
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
                        <h2 class="text-2xl font-bold text-black">Manajemen Pesanan</h2>
                        <p class="text-gray-600 mt-1">Kelola semua pesanan toko bunga Anda</p>
                    </div>
                    <div class="flex space-x-3">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                            Import Pesanan
                        </button>
                        <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                            Cetak Laporan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['new'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Pesanan Baru</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['processing'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Diproses</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['shipped'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Dikirim</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $stats['delivered'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Selesai</div>
                    </div>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Dibatalkan</div>
                    </div>
                </div>
            </div>

            <!-- Filter and Search Section -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pesanan</label>
                        <input type="text" placeholder="No. pesanan atau nama..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                            <option value="">Semua Status</option>
                            <option value="new">Pesanan Baru</option>
                            <option value="processing">Diproses</option>
                            <option value="shipped">Dikirim</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                        <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-black focus:border-black">
                    </div>
                    <div class="flex items-end">
                        <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors w-full">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-black">Daftar Pesanan</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">Export Excel</button>
                        <button class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">Cetak Invoice</button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($allOrders ?? [] as $order)
                                @php
                                    $statusColors = [
                                        'new' => 'bg-blue-100 text-blue-800',
                                        'processing' => 'bg-yellow-100 text-yellow-800',
                                        'shipped' => 'bg-green-100 text-green-800',
                                        'delivered' => 'bg-purple-100 text-purple-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusColor = $statusColors[$order['status']] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-black">{{ $order['order_number'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $order['items_count'] }} item</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-black">{{ $order['customer_name'] }}</div>
                                        <div class="text-sm text-gray-500">{{ $order['customer_email'] }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ Str::limit($order['products'] ?? 'Tidak ada produk', 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black font-medium">
                                        Rp {{ number_format($order['total'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ $order['status_label'] ?? 'Baru' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($order['created_at'])->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 text-sm">
                                        Belum ada pesanan. Pesanan akan muncul ketika user menambahkan produk ke keranjang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(isset($allOrders) && count($allOrders) > 0)
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Menampilkan {{ count($allOrders) }} pesanan
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection