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
            DepartmentSeeder::class,
            ServiceSeeder::class,
            TitleSeeder::class,
            UserSeeder::class,
            // DepartmentUserSeeder::class,
            StatusSeeder::class,
            AreaSeeder::class,
            CustomerSeeder::class,
            // OrderSeeder::class,
            // MessageSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
