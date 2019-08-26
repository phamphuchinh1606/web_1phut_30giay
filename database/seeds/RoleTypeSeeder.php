<?php

use App\Models\RoleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTypeSeeder extends Seeder
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
                'role_type_id' => 1,
                'role_type_name' => 'Admin',
            ],
            [
                'role_type_id' => 2,
                'role_type_name' => 'User',
            ],
            [
                'role_type_id' =>99,
                'role_type_name' => 'Root',
            ],
        ];
        foreach ($arrayRoleTypes as $roleType){
            DB::table(RoleType::getTableName())->insert([
                'id' => $roleType['role_type_id'],
                'role_type_name' => $roleType['role_type_name']
            ]);
        }
    }
}
