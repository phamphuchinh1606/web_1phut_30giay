<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayRoleTypes = [
            [
                'role_id' => 1,
                'role_name' => 'RootAdmin',
                'role_type_id' => 1, //Type Screen Admin
            ],
            [
                'role_id' => 2,
                'role_name' => 'Quản Lý Công Ty',
                'role_type_id' => 1, //Type Screen Admin
            ],
            [
                'role_id' => 3,
                'role_name' => 'Quản Lý Chi Nhánh',
                'role_type_id' => 1, //Type Screen Admin
            ],
            [
                'role_id' => 4,
                'role_name' => 'Quản Lý Nhân Viên',
                'role_type_id' => 1, //Type Screen Admin
            ],
            [
                'role_id' => 5,
                'role_name' => 'Quản Lý Bán Hàng',
                'role_type_id' => 1, //Type Screen Admin
            ],
            [
                'role_id' => 6,
                'role_name' => 'Quản Lý Chi Tiêu',
                'role_type_id' => 1, //Type Screen Admin
            ],

            [
                'role_id' => 7,
                'role_name' => 'Nhân Viên Bán Hàng',
                'role_type_id' => 1, //Type Screen Admin
            ],
            [
                'role_id' => 8,
                'role_name' => 'Quản Lý Bán Hàng',
                'role_type_id' => 1, //Type Screen Admin
            ],
            [
                'role_id' => 9,
                'role_name' => 'Quản Lý Nhân Viên',
                'role_type_id' => 1, //Type Screen Admin
            ]
        ];
        foreach ($arrayRoleTypes as $roleType){
            DB::table(Role::getTableName())->insert([
                'id' => $roleType['role_id'],
                'role_name' => $roleType['role_name'],
                'role_type_id' => $roleType['role_type_id'],
            ]);
        }
    }
}
