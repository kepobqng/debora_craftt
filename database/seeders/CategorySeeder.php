<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Buket Bunga',
                'slug' => 'buket-bunga',
                'description' => 'Berbagai macam buket bunga untuk berbagai acara',
                'image' => 'buket-bunga.jpg'
            ],
            [
                'name' => 'Buket Mawar',
                'slug' => 'buket-mawar',
                'description' => 'Buket bunga mawar dalam berbagai warna dan ukuran',
                'image' => 'buket-mawar.jpg'
            ],
            [
                'name' => 'Buket Wisuda',
                'slug' => 'buket-wisuda',
                'description' => 'Buket khusus untuk acara wisuda',
                'image' => 'buket-wisuda.jpg'
            ],
            [
                'name' => 'Buket Ulang Tahun',
                'slug' => 'buket-ulang-tahun',
                'description' => 'Buket bunga untuk hadiah ulang tahun',
                'image' => 'buket-ulang-tahun.jpg'
            ],
            [
                'name' => 'Buket Valentine',
                'slug' => 'buket-valentine',
                'description' => 'Buket bunga romantis untuk Hari Valentine',
                'image' => 'buket-valentine.jpg'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
