@extends('layouts.app')

@section('title', 'Tentang Kami - Debora Craft')

@section('content')
<div class="min-h-screen py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tentang Debora Craft</h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Kami adalah toko bunga online yang berkomitmen menyediakan bunga segar berkualitas 
                untuk setiap momen berharga dalam hidup Anda.
            </p>
        </div>
        <div class="max-w-3xl mx-auto space-y-8">
            <div class="p-8 border border-gray-200 rounded-xl bg-white shadow-sm">
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">Bunga Segar</h3>
                <p class="text-gray-600">Kami hanya menggunakan bunga segar berkualitas tinggi dari supplier terpercaya.</p>
            </div>
            <div class="p-8 border border-gray-200 rounded-xl bg-white shadow-sm">
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">Desain Eksklusif</h3>
                <p class="text-gray-600">Setiap karangan bunga dirancang dengan detail yang rapi oleh florist profesional.</p>
            </div>
            <div class="p-8 border border-gray-200 rounded-xl bg-white shadow-sm">
                <h3 class="text-2xl font-semibold text-gray-900 mb-3">Pengiriman Cepat</h3>
                <p class="text-gray-600">Pengiriman cepat dan aman memastikan bunga tiba dalam keadaan sempurna.</p>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Lokasi Kami</h2>
            <p class="text-gray-600 mb-4">Kunjungi toko kami atau lihat lokasi di peta berikut.</p>
            <div class="w-full">
                @if(!empty($mapEmbedUrl))
                    <iframe
                        src="{{ $mapEmbedUrl }}"
                        class="w-full h-96 rounded-lg"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                @else
                    <div class="w-full h-24 flex items-center justify-center bg-gray-50 border border-dashed border-gray-300 rounded-lg text-gray-600">
                        Embed peta belum dikonfigurasi.
                    </div>
                @endif
            </div>
            <div class="mt-3">
                <a href="{{ $mapsLink ?? 'https://maps.app.goo.gl/zGSAj2x9je85Bp1Y7' }}" target="_blank" class="text-blue-600 hover:text-blue-800">Buka di Google Maps</a>
            </div>
        </div>
    </div>
</div>
@endsection

