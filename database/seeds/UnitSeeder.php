<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayStatus = ['Cái','Cây','Chai', 'Cuộn', 'Bao', 'Miếng','Kg','Lít', 'Thẻ', 'Trái', 'Xấp' ];
        foreach ($arrayStatus as $unitName){
            DB::table(Unit::getTableName())->insert([
                'unit_name' => $unitName
            ]);
        }
    }
}
