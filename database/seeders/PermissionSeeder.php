<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = array(
            array(
                'name' => 'dashboard_menu', 
                'section_name_ar' => 'لوحة التحكم',
                'section_name_en' => 'dashboard',
                'desc_ar' => 'عرض قائمة لوحة المعلومات', 
                'desc_en' => 'Dashboard Menu',
            ),
            array(
                'name' => 'settings_menu', 
                'section_name_ar' => 'الاعدادات',
                'section_name_en' => 'settings',
                'desc_ar' => 'عرض قائمة الاعدادات', 
                'desc_en' => 'Settings Menu',
            ),


            //roles
            array(
                'name' => 'roles_menu',
                'section_name_ar' => 'الأدوار',
                'section_name_en' => 'roles',
                'desc_ar' => 'عرض قائمة الادوار',
                'desc_en' => 'Roles Menu',
            ),
            array(
                'name' => 'roles_create',
                'section_name_ar' => 'الأدوار',
                'section_name_en' => 'roles',
                'desc_ar' => 'انشاء ادوار',
                'desc_en' => 'Roles Create',
            ),
            array(
                'name' => 'roles_edit',
                'section_name_ar' => 'الأدوار',
                'section_name_en' => 'roles',
                'desc_ar' => 'تعديل الادوار',
                'desc_en' => 'Roles Edit',
            ),
            array(
                'name' => 'roles_delete',
                'section_name_ar' => 'الأدوار',
                'section_name_en' => 'roles',
                'desc_ar' => 'حذف الادوار',
                'desc_en' => 'Roles Delete',
            ),

            //departments
            array(
                'name' => 'departments_menu',
                'section_name_ar' => 'الأقسام',
                'section_name_en' => 'departments',
                'desc_ar' => 'عرض قائمة الاقسام',
                'desc_en' => 'Departments Menu',
            ),
            array(
                'name' => 'departments_create',
                'section_name_ar' => 'الأقسام',
                'section_name_en' => 'departments',
                'desc_ar' => 'انشاء اقسام',
                'desc_en' => 'Departments Create',
            ),
            array(
                'name' => 'departments_edit',
                'section_name_ar' => 'الأقسام',
                'section_name_en' => 'departments',
                'desc_ar' => 'تعديل الاقسام',
                'desc_en' => 'Departments Edit',
            ),
            array(
                'name' => 'departments_delete',
                'section_name_ar' => 'الأقسام',
                'section_name_en' => 'departments',
                'desc_ar' => 'حذف الاقسام',
                'desc_en' => 'Departments Delete',
            ),

            //services
            array(
                'name' => 'services_menu',
                'section_name_ar' => 'الخدمات',
                'section_name_en' => 'Services',
                'desc_ar' => 'عرض قائمة الخدمات',
                'desc_en' => 'Services Menu',
            ),
            array(
                'name' => 'services_create',
                'section_name_ar' => 'الخدمات',
                'section_name_en' => 'Services',
                'desc_ar' => 'انشاء خدمات',
                'desc_en' => 'Services Create',
            ),
            array(
                'name' => 'services_edit',
                'section_name_ar' => 'الخدمات',
                'section_name_en' => 'Services',
                'desc_ar' => 'تعديل الخدمات',
                'desc_en' => 'Services Edit',
            ),
            array(
                'name' => 'services_delete',
                'section_name_ar' => 'الخدمات',
                'section_name_en' => 'Services',
                'desc_ar' => 'حذف الخدمات',
                'desc_en' => 'Services Delete',
            ),


            //titles
            array(
                'name' => 'titles_menu',
                'section_name_ar' => 'الوظائف',
                'section_name_en' => 'titles',
                'desc_ar' => 'عرض قائمة الوظائف',
                'desc_en' => 'Titles Menu',
            ),
            array(
                'name' => 'titles_create',
                'section_name_ar' => 'الوظائف',
                'section_name_en' => 'titles',
                'desc_ar' => 'انشاء وظائف',
                'desc_en' => 'Titles Create',
            ),
            array(
                'name' => 'titles_edit',
                'section_name_ar' => 'الوظائف',
                'section_name_en' => 'titles',
                'desc_ar' => 'تعديل الوظائف',
                'desc_en' => 'Titles Edit',
            ),
            array(
                'name' => 'titles_delete',
                'section_name_ar' => 'الوظائف',
                'section_name_en' => 'titles',
                'desc_ar' => 'حذف الوظائف',
                'desc_en' => 'Titles Delete',
            ),


            //users

            array(
                'name' => 'users_menu',
                'section_name_ar' => 'المستخدمين',
                'section_name_en' => 'users',
                'desc_ar' => 'عرض قائمة المستخدمين',
                'desc_en' => 'Users Menu',
            ),
            array(
                'name' => 'users_create',
                'section_name_ar' => 'المستخدمين',
                'section_name_en' => 'users',
                'desc_ar' => 'انشاء مستخدمين',
                'desc_en' => 'Users Create',
            ),
            array(
                'name' => 'users_edit',
                'section_name_ar' => 'المستخدمين',
                'section_name_en' => 'users',
                'desc_ar' => 'تعديل بيانات المستخدمين',
                'desc_en' => 'Users Edit',
            ),
            array(
                'name' => 'users_delete',
                'section_name_ar' => 'المستخدمين',
                'section_name_en' => 'users',
                'desc_ar' => 'حذف المستخدمين',
                'desc_en' => 'Users Delete',
            ),

            //statuses

            array(
                'name' => 'statuses_menu',
                'section_name_ar' => 'الحالات',
                'section_name_en' => 'statuses',
                'desc_ar' => 'عرض قائمة الحالات',
                'desc_en' => 'Statuses Menu',
            ),
            array(
                'name' => 'statuses_edit',
                'section_name_ar' => 'الحالات',
                'section_name_en' => 'statuses',
                'desc_ar' => 'تعديل الحالات',
                'desc_en' => 'Statuses Edit',
            ),


            //areas

            array(
                'name' => 'areas_menu',
                'section_name_ar' => 'المناطق',
                'section_name_en' => 'areas',
                'desc_ar' => 'عرض قائمة المناطق',
                'desc_en' => 'Areas Menu',
            ),
            array(
                'name' => 'areas_create',
                'section_name_ar' => 'المناطق',
                'section_name_en' => 'areas',
                'desc_ar' => 'انشاء المناطق',
                'desc_en' => 'Areas Create',
            ),
            array(
                'name' => 'areas_edit',
                'section_name_ar' => 'المناطق',
                'section_name_en' => 'areas',
                'desc_ar' => 'تعديل المناطق',
                'desc_en' => 'Areas Edit',
            ),
            array(
                'name' => 'areas_delete',
                'section_name_ar' => 'المناطق',
                'section_name_en' => 'areas',
                'desc_ar' => 'حذف المناطق',
                'desc_en' => 'Areas Delete',
            ),


            //operations title
            array(
                'name' => 'operations_menu',
                'section_name_ar' => 'العمليات',
                'section_name_en' => 'operations',
                'desc_ar' => 'عرض قائمة العمليات',
                'desc_en' => 'Operations Menu',
            ),



            //customers

            array(
                'name' => 'customers_menu',
                'section_name_ar' => 'العملاء',
                'section_name_en' => 'customers',
                'desc_ar' => 'عرض قائمة العملاء',
                'desc_en' => 'Customers Menu',
            ),
            array(
                'name' => 'customers_create',
                'section_name_ar' => 'العملاء',
                'section_name_en' => 'customers',
                'desc_ar' => 'انشاء عميل جديد',
                'desc_en' => 'Customers Create',
            ),
            array(
                'name' => 'customers_edit',
                'section_name_ar' => 'العملاء',
                'section_name_en' => 'customers',
                'desc_ar' => 'تعديل بيانات العملاء',
                'desc_en' => 'Customers Edit',
            ),
            array(
                'name' => 'customers_delete',
                'section_name_ar' => 'العملاء',
                'section_name_en' => 'customers',
                'desc_ar' => 'حذف العملاء',
                'desc_en' => 'Customers Delete',
            ),


            //orders

            array(
                'name' => 'orders_menu',
                'section_name_ar' => 'الطلبات',
                'section_name_en' => 'orders',
                'desc_ar' => 'عرض قائمة الطلبات',
                'desc_en' => 'Orders Menu',
            ),
            array(
                'name' => 'orders_create',
                'section_name_ar' => 'الطلبات',
                'section_name_en' => 'orders',
                'desc_ar' => 'انشاء طلبات',
                'desc_en' => 'Orders Create',
            ),
            array(
                'name' => 'orders_edit',
                'section_name_ar' => 'الطلبات',
                'section_name_en' => 'orders',
                'desc_ar' => 'تعديل الطلبات',
                'desc_en' => 'Orders Edit',
            ),
            array(
                'name' => 'orders_show',
                'section_name_ar' => 'الطلبات',
                'section_name_en' => 'orders',
                'desc_ar' => 'عرض تفاصيل الطلبات',
                'desc_en' => 'Orders Show',
            ),

            //Invoices
            array(
                'name' => 'invoices_menu',
                'section_name_ar' => 'الفواتير',
                'section_name_en' => 'Invoices',
                'desc_ar' => 'عرض قائمة الفواتير',
                'desc_en' => 'Invoices Menu',
            ),
            

            //dispatching
            
            array(
                'name' => 'dispatching_menu', 
                'section_name_ar' => 'التوزيع',
                'section_name_en' => 'dispatching',
                'desc_ar' => 'عرض قائمة التوزيع', 
                'desc_en' => 'Dispatching Menu',
            ),

            //reports
            array(
                'name' => 'reports_menu', 
                'section_name_ar' => 'التقارير',
                'section_name_en' => 'reports',
                'desc_ar' => 'عرض قائمة التقارير', 
                'desc_en' => 'Reports Menu',
            ),


            
        );

        DB::table('permission_role')->delete();
        DB::table('permissions')->delete();
        Permission::insert($permissions);

        // Attach All Created Permissions to the Super Admin Role
        $permissions = Permission::all();
        foreach($permissions as $permission){
            Role::find(1)->permissions()->attach($permission->id);
        }
        // Role::find(2)->permissions()->attach([1,35]);
        // Role::find(3)->permissions()->attach([1,2,21,22,23,24,25,26,27,28,29,30,31,32,33,35]);
        // Role::find(4)->permissions()->attach([1,25,26,27,30,31,33,35]);
        // Role::find(5)->permissions()->attach([1,25,26,30,33,34,35]);
    }
}
