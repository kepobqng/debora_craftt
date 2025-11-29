<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function kategori()
    {
        // Hanya ambil 3 kategori utama: Bunga, Aksesoris, Gift Set
        // Pastikan kategori-kategori ini ada di database (bisa dikelola admin)
        $allowedSlugs = ['bunga', 'aksesoris', 'gift-set'];
        
        // Buat kategori jika belum ada
        $categoryData = [
            'bunga' => ['name' => 'Bunga', 'slug' => 'bunga'],
            'aksesoris' => ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
            'gift-set' => ['name' => 'Gift Set', 'slug' => 'gift-set'],
        ];
        
        foreach ($categoryData as $slug => $data) {
            Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => null,
                    'is_active' => true
                ]
            );
        }

        // Ambil hanya 3 kategori utama yang aktif
        $categories = Category::whereIn('slug', $allowedSlugs)
            ->where('is_active', true)
            ->orderByRaw("FIELD(slug, 'bunga', 'aksesoris', 'gift-set')")
            ->get();
        
        $sections = $categories->pluck('name', 'slug')->toArray();

        $productsByCategory = [];
        foreach ($categories as $category) {
            $productsByCategory[$category->slug] = Product::where('is_active', true)
                ->where('category_id', $category->id)
                ->with('category')
                ->latest()
                ->take(6)
                ->get();
        }

        return view('kategori', [
            'sections' => $sections,
            'productsByCategory' => $productsByCategory,
        ]);
    }

    public function tentang()
    {
        $mapEmbedUrl = config('site.map_embed_url');
        $mapsLink = config('site.maps_link', 'https://maps.app.goo.gl/zGSAj2x9je85Bp1Y7');
        return view('tentang', compact('mapEmbedUrl', 'mapsLink'));
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function productDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);
        
        // Cari promo aktif untuk produk ini
        $now = now();
        $promo = \App\Models\Promo::where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->where(function($query) use ($product) {
                $query->where('product_id', $product->id)
                      ->orWhere('category_id', $product->category_id);
            })
            ->first();
        
        // Hitung harga diskon jika ada promo
        $discountPrice = null;
        if ($promo) {
            if ($promo->discount_type === 'percentage') {
                $discount = ($product->price * $promo->discount_value) / 100;
                // Jika ada max_discount, gunakan yang lebih kecil
                if ($promo->max_discount && $discount > $promo->max_discount) {
                    $discount = $promo->max_discount;
                }
                $discountPrice = $product->price - $discount;
            } else {
                // Fixed discount
                $discountPrice = $product->price - $promo->discount_value;
            }
            // Pastikan harga diskon tidak negatif
            if ($discountPrice < 0) {
                $discountPrice = 0;
            }
        }
        
        return view('product-detail', compact('product', 'promo', 'discountPrice'));
    }

    public function userDashboard()
    {
        $products = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(12)
            ->get();
        return view('dashboard.user.index', compact('products'));
    }
}
