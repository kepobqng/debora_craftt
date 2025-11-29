<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori yang tersedia
        $allCategories = Category::whereIn('slug', ['bunga', 'aksesoris', 'gift-set'])
            ->where('is_active', true)
            ->orderByRaw("FIELD(slug, 'bunga', 'aksesoris', 'gift-set')")
            ->get();

        // Filter kategori berdasarkan pilihan user
        $selectedCategory = $request->get('category');
        if ($selectedCategory) {
            $categories = $allCategories->where('slug', $selectedCategory);
        } else {
            $categories = $allCategories;
        }

        // Filter produk berdasarkan kategori yang dipilih
        $search = $request->get('search');
        $statusFilter = $request->get('status');
        
        $productsByCategory = [];
        foreach ($categories as $category) {
            $query = Product::where('category_id', $category->id)
                ->with('category');
            
            // Filter by search
            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }
            
            // Filter by status
            if ($statusFilter) {
                if ($statusFilter == 'safe') {
                    $query->where('stock', '>', 5);
                } elseif ($statusFilter == 'low') {
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                } elseif ($statusFilter == 'empty') {
                    $query->where('stock', 0);
                }
            }
            
            $productsByCategory[$category->slug] = $query->orderBy('name')->get();
        }

        // Hitung statistik stok (hanya untuk kategori yang dipilih jika ada filter)
        $statQuery = Product::query();
        
        if ($selectedCategory) {
            $categoryIds = $categories->pluck('id');
            $statQuery->whereIn('category_id', $categoryIds);
        }
        
        if ($search) {
            $statQuery->where('name', 'like', '%' . $search . '%');
        }
        
        $allProducts = $statQuery->get();
        
        $stats = [
            'total' => $allProducts->count(),
            'safe_stock' => $allProducts->filter(function ($product) {
                return $product->stock > 5;
            })->count(),
            'low_stock' => $allProducts->filter(function ($product) {
                return $product->stock > 0 && $product->stock <= 5;
            })->count(),
            'out_of_stock' => $allProducts->filter(function ($product) {
                return $product->stock == 0;
            })->count(),
        ];

        // Produk dengan stok rendah untuk alert (semua produk, tidak difilter)
        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->with('category')
            ->take(3)
            ->get();

        return view('dashboard.admin.stock.index', compact(
            'categories',
            'allCategories',
            'productsByCategory',
            'stats',
            'lowStockProducts',
            'selectedCategory'
        ));
    }
}
