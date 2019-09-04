<?php

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'name' => 'Ly',
                'price_first_hour' => 25000,
                'price_last_hour' => 25000,
                'employee_login_id' => 'phamly',
                'password' => '123456'
            ],
            [
                'branch_id' => 1,
                'name' => 'Thùy',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
                'employee_login_id' => 'phamthuy',
                'password' => '123456'
            ],
            [
                'branch_id' => 1,
                'name' => 'Chinh',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
                'employee_login_id' => 'phamchinh',
                'password' => '123456'
            ],
            [
                'branch_id' => 1,
                'name' => 'Lực',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
                'employee_login_id' => 'luc',
                'password' => '123456'
            ],
            [
                'branch_id' => 1,
                'name' => 'Linh',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
                'employee_login_id' => 'linh',
                'password' => '123456'
            ],
            [
                'branch_id' => 1,
                'name' => 'My',
                'price_first_hour' => 20000,
                'price_last_hour' => 20000,
                'employee_login_id' => 'my',
                'password' => '123456'
            ],
        ];
        foreach ($arrayMaterial as $material) {
            DB::table(Employee::getTableName())->insert([
                'branch_id' => $material['branch_id'],
                'name' => $material['name'],
                'price_first_hour' => $material['price_first_hour'],
                'price_last_hour' => $material['price_last_hour'],
                'employee_sale_card_small' => 1,
                'employee_login_id' => $material['employee_login_id'],
                'password' => Hash::make($material['password']),
            ]);
        }
    }
}
