<?php

use App\Models\MaterialType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayStatus = ['Nguyên Liệu','Nước Uống', 'Bao Bì'];
        foreach ($arrayStatus as $unitName){
            DB::table(MaterialType::getTableName())->insert([
                'material_type_name' => $unitName
            ]);
        }
    }
}
