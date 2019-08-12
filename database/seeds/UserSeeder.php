<?php

use App\Models\User;
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
                'name' => 'Phạm Ly',
                'email' => 'phamly@gmail.com',
                'password' => '123456',
            ],
            [
                'name' => 'Đang Thùy',
                'email' => 'dangthuy@gmail.com',
                'password' => '123456',
            ],
            [
                'name' => 'Phú Chinh',
                'email' => 'phuchinh@gmail.com',
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
