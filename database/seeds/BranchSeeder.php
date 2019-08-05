<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayStatus = [
            [
                'name' => 'Chi Nhánh Hoàng Việt',
                'address' => '64 Hoàng Việt'
            ],
            [
                'name' => 'Chi Nhánh Thăng Long',
                'address' => 'Thăng Long'
            ]
        ];
        foreach ($arrayStatus as $branch) {
            DB::table(Branch::getTableName())->insert([
                'branch_name' => $branch['name'],
                'address' => $branch['address']
            ]);
        }
    }
}
