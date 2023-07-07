<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'name_ar' => 'الادارة', 
                'name_en' => 'Management', 
                'active' => 1, 
                'is_service' => 0, 
            ],
            [
                'name_ar' => 'تكييف وثلاجات', 
                'name_en' => 'Structure',
                'active' => 1,
                'is_service' => 1, 
            ],
            [
                'name_ar' => 'صحي', 
                'name_en' => 'Structure',
                'active' => 1,
                'is_service' => 1, 
            ],
            [
                'name_ar' => 'كهرباء', 
                'name_en' => 'Structure',
                'active' => 1,
                'is_service' => 1, 
            ],
            [
                'name_ar' => 'الومنيوم ونجارة', 
                'name_en' => 'Aluminum & Carpentry',
                'active' => 1,
                'is_service' => 1, 
            ],
            [
                'name_ar' => 'كاميرات', 
                'name_en' => 'Cameras',
                'active' => 1,
                'is_service' => 1, 
            ],
            [
                'name_ar' => 'ستالايت', 
                'name_en' => 'Satellite',
                'active' => 1,
                'is_service' => 1, 
            ],
            [
                'name_ar' => 'صبغ', 
                'name_en' => 'Painting',
                'active' => 1,
                'is_service' => 1, 
            ],
            [
                'name_ar' => 'انشائي', 
                'name_en' => 'Structure',
                'active' => 1,
                'is_service' => 1, 
            ],
        ];
        Department::insert($departments);

        User::find(1)->departments()->attach(Department::pluck('id'));

    }
}
