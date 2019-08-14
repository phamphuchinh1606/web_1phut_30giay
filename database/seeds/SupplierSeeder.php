<?php

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arraySuppliers = ['1 Phút 30 Giấy','Cung Cấp Đá'];
        foreach ($arraySuppliers as $supplier){
            DB::table(Supplier::getTableName())->insert([
                'supplier_name' => $supplier,
                'branch_id' => 1
            ]);
        }
    }
}
