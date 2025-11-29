<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::with(['product', 'category'])
            ->latest()
            ->get();
        
        return view('dashboard.admin.promo.index', compact('promos'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->latest()->get();
        $categories = Category::where('is_active', true)
            ->orderByRaw("FIELD(slug, 'bunga', 'aksesoris', 'gift-set')")
            ->get();
        
        return view('dashboard.admin.promo.create', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'product_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'code' => 'nullable|string|max:50|unique:promos,code',
        ]);

        // Generate code if not provided
        if (empty($validated['code'])) {
            $validated['code'] = strtoupper(Str::random(8));
        }

        // Ensure at least one of product_id or category_id is set
        if (empty($validated['product_id']) && empty($validated['category_id'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih minimal satu produk atau kategori untuk promo.');
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;

        Promo::create($validated);

        return redirect()->route('admin.promo')
            ->with('success', 'Promo berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        $products = Product::where('is_active', true)->latest()->get();
        $categories = Category::where('is_active', true)
            ->orderByRaw("FIELD(slug, 'bunga', 'aksesoris', 'gift-set')")
            ->get();
        
        return view('dashboard.admin.promo.edit', compact('promo', 'products', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'product_id' => 'nullable|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'code' => 'nullable|string|max:50|unique:promos,code,' . $id,
        ]);

        // Ensure at least one of product_id or category_id is set
        if (empty($validated['product_id']) && empty($validated['category_id'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih minimal satu produk atau kategori untuk promo.');
        }

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $promo->update($validated);

        return redirect()->route('admin.promo')
            ->with('success', 'Promo berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promo')
            ->with('success', 'Promo berhasil dihapus!');
    }
}
