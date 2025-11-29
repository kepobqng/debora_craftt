<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        CartItem::truncate();
        Cart::truncate();
        Product::truncate();
        Category::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
