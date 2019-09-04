<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'name' => 'Admin',
                'email' => 'admin',
                'password' => '123456',
            ],
            [
                'name' => 'Phạm Ly',
                'email' => 'phamly',
                'password' => '123456',
            ],
            [
                'name' => 'Đang Thùy',
                'email' => 'phamthuy',
                'password' => '123456',
            ],
            [
                'name' => 'Phú Chinh',
                'email' => 'phamphuchinh',
                'password' => '123456',
            ]
        ];
        foreach ($arrayUsers as $user){
            DB::table(User::getTableName())->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
            ]);
        }
    }
}
