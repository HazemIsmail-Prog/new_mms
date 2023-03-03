<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $departments = array(
            array('id' => '1', 'name_ar' => 'الادارة', 'name_en' => 'Management', 'active' => '1', 'is_service' => '0', 'created_at' => '2021-05-20 23:14:27', 'updated_at' => '2021-05-21 07:18:28', 'deleted_at' => NULL),
            array('id' => '2', 'name_ar' => 'تكييف', 'name_en' => 'Air Conditioning', 'active' => '1', 'is_service' => '1', 'created_at' => '2021-05-20 23:27:50', 'updated_at' => '2021-06-18 18:05:22', 'deleted_at' => NULL),
            // array('id' => '3', 'name_ar' => 'كهرباء', 'name_en' => 'Electricity', 'active' => '1', 'is_service' => '1', 'created_at' => '2021-05-20 23:22:11', 'updated_at' => '2021-06-18 18:05:10', 'deleted_at' => NULL),
            // array('id' => '4', 'name_ar' => 'صحي', 'name_en' => 'Plumbing', 'active' => '1', 'is_service' => '1', 'created_at' => '2021-05-20 23:22:39', 'updated_at' => '2021-06-18 18:05:16', 'deleted_at' => NULL),
        );
        Department::insert($departments);
    }
}
