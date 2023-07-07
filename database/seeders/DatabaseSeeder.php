<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            RoleSeeder::class,
            PermissionSeeder::class,
            PermissionRoleSeeder::class,
            // ServiceSeeder::class,
            TitleSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            StatusSeeder::class,
            AreaSeeder::class,
            CustomerSeeder::class,
            // OrderSeeder::class,
            // MessageSeeder::class,
        ]);
    }
}
