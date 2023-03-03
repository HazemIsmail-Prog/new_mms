<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            ['id' => '1', 'name_ar' => 'مدير عام', 'name_en' => 'General Manager', 'active' => '1', 'created_at' => '2021-06-18 17:47:38', 'updated_at' => '2022-01-06 20:27:18', 'deleted_at' => null],
            ['id' => '2', 'name_ar' => 'نظم معلومات', 'name_en' => 'IT', 'active' => '1', 'created_at' => '2021-06-18 17:48:15', 'updated_at' => '2021-06-18 17:48:15', 'deleted_at' => null],
            ['id' => '3', 'name_ar' => 'موارد بشرية', 'name_en' => 'HR', 'active' => '1', 'created_at' => '2021-06-18 17:49:02', 'updated_at' => '2021-06-18 17:49:02', 'deleted_at' => null],
            ['id' => '4', 'name_ar' => 'مدير مالي', 'name_en' => 'Financial Manager', 'active' => '1', 'created_at' => '2021-06-18 17:49:15', 'updated_at' => '2021-06-18 17:49:15', 'deleted_at' => null],
            ['id' => '5', 'name_ar' => 'محاسب', 'name_en' => 'Accountant', 'active' => '1', 'created_at' => '2021-06-18 17:49:26', 'updated_at' => '2021-06-18 17:49:26', 'deleted_at' => null],
            ['id' => '6', 'name_ar' => 'توزيع', 'name_en' => 'Dispatcher', 'active' => '1', 'created_at' => '2021-06-18 17:51:30', 'updated_at' => '2021-06-18 17:51:30', 'deleted_at' => null],
            ['id' => '7', 'name_ar' => 'مسؤول سيارات', 'name_en' => 'Cars Supervisor', 'active' => '1', 'created_at' => '2021-06-18 17:51:48', 'updated_at' => '2021-06-18 17:51:48', 'deleted_at' => null],
            ['id' => '8', 'name_ar' => 'كاشير', 'name_en' => 'Cashier', 'active' => '1', 'created_at' => '2021-06-18 17:51:57', 'updated_at' => '2021-06-18 17:51:57', 'deleted_at' => null],
            ['id' => '9', 'name_ar' => 'مندوب', 'name_en' => 'MM', 'active' => '1', 'created_at' => '2021-06-18 17:52:11', 'updated_at' => '2021-09-04 08:25:49', 'deleted_at' => null],
            ['id' => '10', 'name_ar' => 'مراقب', 'name_en' => 'Foreman', 'active' => '1', 'created_at' => '2021-06-18 17:52:23', 'updated_at' => '2021-06-18 17:52:23', 'deleted_at' => null],
            ['id' => '11', 'name_ar' => 'فني', 'name_en' => 'Technician', 'active' => '1', 'created_at' => '2021-06-18 17:52:33', 'updated_at' => '2021-06-18 17:52:33', 'deleted_at' => null],
            ['id' => '12', 'name_ar' => 'كول سنتر', 'name_en' => 'Call Center', 'active' => '1', 'created_at' => '2021-06-18 18:02:13', 'updated_at' => '2021-06-18 18:03:35', 'deleted_at' => null],
            ['id' => '13', 'name_ar' => 'مقاول', 'name_en' => 'Sub Contractor', 'active' => '1', 'created_at' => null, 'updated_at' => null, 'deleted_at' => null],
            ['id' => '14', 'name_ar' => 'مسؤول العقود', 'name_en' => 'Contracts Manager', 'active' => '1', 'created_at' => '2021-06-19 02:34:17', 'updated_at' => '2021-06-19 02:34:17', 'deleted_at' => null],
        ];

        Title::insert($titles);
    }
}
