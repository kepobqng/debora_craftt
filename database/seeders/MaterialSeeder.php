<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            // Flowers
            [
                'name' => 'Mawar Merah',
                'code' => 'MW-001',
                'description' => 'Bunga mawar merah segar',
                'unit' => 'batang',
                'current_stock' => 50,
                'min_stock' => 10,
                'price' => 5000,
                'type' => 'flower',
                'status' => 'in_stock',
                'supplier' => 'Kebun Mawar Sejahtera',
                'supplier_phone' => '081234567890'
            ],
            [
                'name' => 'Mawar Putih',
                'code' => 'MW-002',
                'description' => 'Bunga mawar putih segar',
                'unit' => 'batang',
                'current_stock' => 30,
                'min_stock' => 10,
                'price' => 5000,
                'type' => 'flower',
                'status' => 'in_stock',
                'supplier' => 'Kebun Mawar Sejahtera',
                'supplier_phone' => '081234567890'
            ],
            [
                'name' => 'Bunga Matahari',
                'code' => 'BM-001',
                'description' => 'Bunga matahari segar',
                'unit' => 'batang',
                'current_stock' => 25,
                'min_stock' => 5,
                'price' => 8000,
                'type' => 'flower',
                'status' => 'in_stock',
                'supplier' => 'Kebun Bunga Matahari',
                'supplier_phone' => '081234567891'
            ],
            // Packaging
            [
                'name' => 'Kertas Wrapping Korea',
                'code' => 'KW-001',
                'description' => 'Kertas wrapping kualitas premium',
                'unit' => 'lembar',
                'current_stock' => 100,
                'min_stock' => 20,
                'price' => 2000,
                'type' => 'packaging',
                'status' => 'in_stock',
                'supplier' => 'Toko Kemasan',
                'supplier_phone' => '081234567892'
            ],
            [
                'name' => 'Pita Satin',
                'code' => 'PS-001',
                'description' => 'Pita satin untuk dekorasi',
                'unit' => 'meter',
                'current_stock' => 15,
                'min_stock' => 5,
                'price' => 3000,
                'type' => 'packaging',
                'status' => 'low_stock',
                'supplier' => 'Toko Pita',
                'supplier_phone' => '081234567893'
            ],
            // Accessories
            [
                'name' => 'Kartu Ucapan',
                'code' => 'KU-001',
                'description' => 'Kartu ucapan kosong',
                'unit' => 'pcs',
                'current_stock' => 50,
                'min_stock' => 10,
                'price' => 1000,
                'type' => 'accessories',
                'status' => 'in_stock',
                'supplier' => 'Toko ATK',
                'supplier_phone' => '081234567894'
            ]
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}
