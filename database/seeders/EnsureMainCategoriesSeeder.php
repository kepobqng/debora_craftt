<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class EnsureMainCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Bunga', 'slug' => 'bunga'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
            ['name' => 'Gift Set', 'slug' => 'gift-set'],
        ];
        
        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'description' => null,
                    'is_active' => true
                ]
            );
        }
        
        $this->command->info('3 kategori utama sudah dipastikan ada di database!');
    }
}