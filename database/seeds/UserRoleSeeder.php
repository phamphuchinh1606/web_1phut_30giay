<?php

use App\Models\UserRole;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayUsers = [
            [
                'email' => 'admin',
                'id' => 1,
                'role_id' => 1
            ],
            [
                'email' => 'phamly',
                'id' => 2,
                'role_id' => 2
            ],
            [
                'email' => 'phamthuy',
                'id' => 3,
                'role_id' => 2
            ],
            [
                'email' => 'phamchinh',
                'id' => 4,
                'role_id' => 2
            ]
        ];
        foreach ($arrayUsers as $user){
            DB::table(UserRole::getTableName())->insert([
                'user_id' => $user['id'],
                'role_id' => $user['role_id']
            ]);
        }
    }
}
