<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->info('Tidak ada kategori yang ditemukan. Pastikan CategorySeeder sudah dijalankan.');
            return;
        }

        $products = [
            [
                'name' => 'Bouquet Mawar Merah',
                'description' => 'Karangan bunga mawar merah yang romantis, cocok untuk menyatakan cinta. Terdiri dari 12 tangkai mawar merah segar dengan hiasan baby breath dan daun hijau.',
                'price' => 250000,
                'discount_price' => 200000,
                'stock' => 15,
                'unit' => 'bouquet',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Bouquet Mawar Pink',
                'description' => 'Bouquet mawar pink yang manis dan elegan. Kombinasi mawar pink dengan bunas baby breath membuatnya sempurna untuk hadiah spesial.',
                'price' => 220000,
                'stock' => 20,
                'unit' => 'bouquet',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Karangan Bunga Wisuda',
                'description' => 'Karangan bunga untuk perayaan wisuda. Terdiri dari mawar, lily, dan bunga musim dengan warna-warna cerah yang melambangkan kebahagiaan.',
                'price' => 350000,
                'stock' => 10,
                'unit' => 'bouquet',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Bouquet Lily Putih',
                'description' => 'Bouquet lily putih yang anggun dan harum. Lily putih melambangkan kesucian dan ketulusan, cocok untuk berbagai acara formal.',
                'price' => 280000,
                'discount_price' => 250000,
                'stock' => 12,
                'unit' => 'bouquet',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Bouquet Mawar Kuning',
                'description' => 'Bouquet mawar kuning yang ceria dan penuh semangat. Mawar kuning melambangkan persahabatan dan kebahagiaan.',
                'price' => 180000,
                'stock' => 25,
                'unit' => 'bouquet',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Karangan Bunga Duka',
                'description' => 'Karangan bunga untuk menyampaikan belasungkawa. Terdiri dari bunga berwarna putih dan biru dengan tata letak yang sopan dan menghormati.',
                'price' => 400000,
                'stock' => 8,
                'unit' => 'standing',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Bouquet Mawar Campur',
                'description' => 'Bouquet mawar campuran warna-warni yang ceria. Kombinasi mawar merah, pink, kuning, dan putih menciptakan tampilan yang vibrant.',
                'price' => 300000,
                'stock' => 18,
                'unit' => 'bouquet',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Bouquet Tulip',
                'description' => 'Bouquet tulip yang eksotis dan elegan. Tulip melambangkan cinta yang sempurna dan tersedia dalam berbagai warna menarik.',
                'price' => 320000,
                'discount_price' => 290000,
                'stock' => 14,
                'unit' => 'bouquet',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $index => $productData) {
            $category = $categories->random();
            
            Product::create([
                'name' => $productData['name'],
                'slug' => \Str::slug($productData['name']) . '-' . time() . '-' . $index,
                'description' => $productData['description'],
                'price' => $productData['price'],
                'discount_price' => $productData['discount_price'] ?? null,
                'sku' => 'FLW-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'stock' => $productData['stock'],
                'unit' => $productData['unit'],
                'images' => json_encode(['https://via.placeholder.com/400x300/FFC0CB/FFFFFF?text=Bunga']),
                'category_id' => $category->id,
                'is_active' => $productData['is_active'],
                'is_featured' => $productData['is_featured'],
            ]);
        }

        $this->command->info('Berhasil membuat ' . count($products) . ' produk bunga.');
    }
}
