<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
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
                'id' => 1,
                'permission_name' => 'View',
            ],
            [
                'id' => 2,
                'permission_name' => 'Insert',
            ],
            [
                'id' => 3,
                'permission_name' => 'Update',
            ],
            [
                'id' => 4,
                'permission_name' => 'Delete',
            ],
        ];
        foreach ($arrayRoleTypes as $roleType){
            DB::table(Permission::getTableName())->insert([
                'id' => $roleType['id'],
                'permission_name' => $roleType['permission_name']
            ]);
        }
    }
}
