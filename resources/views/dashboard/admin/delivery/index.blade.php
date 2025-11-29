@extends('dashboard.layouts.app')

@section('navigation')
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">Dashboard</a>
    <a href="{{ route('admin.delivery') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-black border-b-2 border-black">Pengiriman</a>
@endsection

@section('content')
    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h1 class="text-2xl font-bold text-black mb-6">Manajemen Pengiriman</h1>
            <p class="text-gray-700">Halaman pengiriman belum memiliki konten. Silakan tambahkan fitur sesuai kebutuhan.</p>
        </div>
    </div>
@endsection

