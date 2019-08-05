<?php

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['Hamburger','Sandwich','Pita','Hotdog','Hambuger Gà', 'Pita Gà'];
        foreach ($products as $name){
            DB::table(Product::getTableName())->insert([
                'product_name' => $name
            ]);
        }
    }
}
