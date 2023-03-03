<?php

namespace Database\Seeders;

use App\Models\DepartmentUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department_user = array(
            array('id' => '1', 'department_id' => '1', 'user_id' => '1', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '2', 'department_id' => '2', 'user_id' => '1', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '3', 'department_id' => '3', 'user_id' => '1', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '4', 'department_id' => '4', 'user_id' => '1', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '5', 'department_id' => '1', 'user_id' => '2', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '6', 'department_id' => '1', 'user_id' => '3', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '7', 'department_id' => '2', 'user_id' => '3', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '8', 'department_id' => '3', 'user_id' => '3', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '9', 'department_id' => '4', 'user_id' => '3', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '10', 'department_id' => '1', 'user_id' => '4', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '11', 'department_id' => '2', 'user_id' => '5', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '12', 'department_id' => '3', 'user_id' => '6', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '13', 'department_id' => '4', 'user_id' => '7', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '14', 'department_id' => '2', 'user_id' => '8', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '15', 'department_id' => '2', 'user_id' => '9', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '16', 'department_id' => '2', 'user_id' => '10', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '17', 'department_id' => '3', 'user_id' => '11', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '18', 'department_id' => '3', 'user_id' => '12', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '19', 'department_id' => '3', 'user_id' => '13', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '20', 'department_id' => '4', 'user_id' => '14', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '21', 'department_id' => '4', 'user_id' => '15', 'created_at' => NULL, 'updated_at' => NULL),
            array('id' => '22', 'department_id' => '4', 'user_id' => '16', 'created_at' => NULL, 'updated_at' => NULL)
        );

        DepartmentUser::insert($department_user);
    }
}
