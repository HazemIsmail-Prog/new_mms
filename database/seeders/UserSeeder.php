<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name_ar' => 'مسؤول عام',
                'name_en' => 'Super Admin',
                'username' => 'admin',
                'password' => bcrypt('123123123'),
                'active' => 1,
                'title_id' => 2,

            ],
        ];

        User::insert($users);

        User::find(1)->roles()->attach(1); // Attach Super Admin Role to Super Admin User
    }
}
