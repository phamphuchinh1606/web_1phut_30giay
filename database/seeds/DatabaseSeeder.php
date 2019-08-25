<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MaterialTypeSeeder::class,
            UnitSeeder::class,
            BranchSeeder::class,
            ProductSeeder::class,
            MaterialSeeder::class,
            EmployeeSeeder::class,
            UserSeeder::class,
            SupplierSeeder::class,
            MenuSeeder::class,
            RoleTypeSeeder::class,
            RoleSeeder::class,
            ScreenSeeder::class,
            PermissionSeeder::class
        ]);
    }
}
