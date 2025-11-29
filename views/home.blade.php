@extends('layouts.app')

@section('title', 'Beranda - Debora Craft')

@section('content')
    <!-- Hero Section - Two Column Layout -->
    <section class="min-h-screen flex hero-background">
        <!-- Left Column - Content -->
        <div class="w-full lg:w-3/5 flex items-center px-8 lg:px-16 py-16 lg:py-24">
            <div class="max-w-2xl">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-6 leading-tight">
                    Hadirkan keindahan yang tidak pernah layu.<br>
                    <span style="color: #EE7FA5;">beautiful flowers</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 leading-relaxed">
                    Express your deepest emotions through our handcrafted bouquets, perfect for every special moment and celebration.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('kategori') }}" class="bg-pink-500 text-white px-8 py-4 rounded-lg font-semibold hover:bg-pink-600 transition duration-300 text-center">
                        Explore Bouquet
                    </a>
                    <a href="{{ route('kategori') }}" class="bg-transparent border-2 border-pink-500 text-pink-600 px-8 py-4 rounded-lg font-semibold hover:bg-pink-50 transition duration-300 text-center">
                        See Collections
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column - Image -->
        <div class="hidden lg:flex lg:w-2/5 items-center justify-center p-8 lg:p-16">
            <div class="w-full max-w-md">
                <div class="rounded-2xl shadow-xl overflow-hidden">
                    <img src="{{ asset('img/Beautiful Flower Bouquet.png') }}" 
                         alt="Beautiful Flower Bouquet" 
                         class="w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </section>
@endsection
