<?php

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayMaterial = [
            [
                'branch_id' => 1,
                'name' => 'Phạm Ly',
                'price_first_hour' => 25000,
                'price_last_hour' => 25000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Đang Thùy',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Phú Chinh',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Hoàng',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Khang',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
            ],
            [
                'branch_id' => 1,
                'name' => 'Dũng',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
            ],
        ];
        foreach ($arrayMaterial as $material) {
            DB::table(Employee::getTableName())->insert([
                'branch_id' => $material['branch_id'],
                'name' => $material['name'],
                'price_first_hour' => $material['price_first_hour'],
                'price_last_hour' => $material['price_last_hour'],
                'employee_sale_card_small' => 1
            ]);
        }
    }
}
