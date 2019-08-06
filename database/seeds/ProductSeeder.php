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
        $prices = ['Hamburger' => 20000,'Sandwich' => 20000,'Pita' => 20000,'Hotdog' => 20000,'Hambuger Gà' => 25000,'Pita Gà' => 25000];
        $parts = ['Hamburger' => 1,'Sandwich' => 2,'Pita' => 1,'Hotdog' => 1,'Hambuger Gà' => 1,'Pita Gà' => 1];
        foreach ($products as $name){
            DB::table(Product::getTableName())->insert([
                'product_name' => $name,
                'price' => $prices[$name],
                'part_num' => $parts[$name],
            ]);
        }
    }
}
