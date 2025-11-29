@extends('layouts.app')

@section('title', 'Kontak - Debora Craft')

@section('content')
<div class="min-h-screen py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
            <p class="text-lg text-gray-600">Siap membantu Anda dengan kebutuhan bunga</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-pink-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-pink-600 text-xl" aria-hidden="true">📞</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                <p class="text-gray-600">0812-3456-7890</p>
            </div>
            <div class="text-center">
                <div class="bg-pink-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-pink-600 text-xl" aria-hidden="true">✉️</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                <p class="text-gray-600">info@deboracraft.com</p>
            </div>
            <div class="text-center">
                <div class="bg-pink-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-pink-600 text-xl" aria-hidden="true">📍</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat</h3>
                <p class="text-gray-600">Jl. Bunga Indah No. 123, Kota Anda</p>
            </div>
        </div>
    </div>
</div>
@endsection

