<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $allowed = collect(config('site.fixed_categories'));
        foreach ($allowed as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'description' => null, 'is_active' => true]
            );
        }
        $categories = Category::whereIn('slug', $allowed->pluck('slug'))->orderBy('name')->get();

        $stats = [
            'total' => $products->count(),
            'active' => $products->where('is_active', true)->count(),
            'out_of_stock' => $products->where('stock', 0)->count(),
            'low_stock' => $products->filter(function ($product) {
                return $product->stock > 0 && $product->stock <= 5;
            })->count(),
        ];

        return view('dashboard.admin.products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        // Pastikan 3 kategori utama ada
        $mainCategories = [
            ['name' => 'Bunga', 'slug' => 'bunga'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
            ['name' => 'Gift Set', 'slug' => 'gift-set'],
        ];
        
        foreach ($mainCategories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'description' => null,
                    'is_active' => true
                ]
            );
        }
        
        // Ambil hanya 3 kategori utama
        $categories = Category::whereIn('slug', ['bunga', 'aksesoris', 'gift-set'])
            ->where('is_active', true)
            ->orderByRaw("FIELD(slug, 'bunga', 'aksesoris', 'gift-set')")
            ->get();
            
        return view('dashboard.admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'unit' => 'nullable|string|max:50',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Generate unique slug
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
            
            // Generate unique SKU
            do {
                $validated['sku'] = 'PRD-' . strtoupper(Str::random(8));
            } while (Product::where('sku', $validated['sku'])->exists());

            // Handle image uploads
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image && $image->isValid()) {
                        // Ensure directory exists
                        $uploadPath = public_path('img/bunga');
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }
                        
                        // Store directly in public/img/bunga directory
                        $filename = time() . '_' . $image->getClientOriginalName();
                        $image->move($uploadPath, $filename);
                        $imagePaths[] = 'img/bunga/' . $filename;
                    }
                }
            }
            
            $validated['images'] = !empty($imagePaths) ? $imagePaths : null;
            $validated['is_active'] = $request->has('is_active') ? true : false;
            $validated['is_featured'] = $request->has('is_featured') ? true : false;

            $product = Product::create($validated);

            return redirect()->route('admin.products')->with('success', 'Produk "' . $product->name . '" berhasil ditambahkan!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $allowed = collect(config('site.fixed_categories'));
        foreach ($allowed as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'description' => null, 'is_active' => true]
            );
        }
        // Urutkan sesuai: Bunga, Aksesoris, Gift Set
        $categories = Category::whereIn('slug', $allowed->pluck('slug'))
            ->where('is_active', true)
            ->orderByRaw("FIELD(slug, 'bunga', 'aksesoris', 'gift-set')")
            ->get();
        return view('dashboard.admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update slug if name changed
        if ($product->name !== $validated['name']) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        // Handle new image uploads
        $imagePaths = $product->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    // Ensure directory exists
                    $uploadPath = public_path('img/bunga');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    // Store directly in public/img/bunga directory
                    $filename = time() . '_' . $image->getClientOriginalName();
                    $image->move($uploadPath, $filename);
                    $imagePaths[] = 'img/bunga/' . $filename;
                }
            }
        }
        
        $validated['images'] = !empty($imagePaths) ? $imagePaths : null;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete images
        if ($product->images) {
            foreach ($product->images as $image) {
                $imagePath = public_path($image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
        
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus!');
    }
}
