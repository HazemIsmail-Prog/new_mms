<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $user = User::create(
                [
                    'name_ar' => $row['name_ar'],
                    'name_en' => $row['name_en'],
                    'username' => $row['username'],
                    'password' => bcrypt($row['password']),
                    'active' => 1,
                    'title_id' => $row['title_id'],
                ]
            );

            $user->departments()->attach($this->getDepartmentIds(explode(',', $row['department'])));

            if($row['role']){
                $user->roles()->attach($this->getRoleId($row['role']));
            }
        }
    }

    public function getDepartmentIds($names)
    {
        return Department::whereIn('name_ar', $names)->pluck('id');
    }
    public function getRoleId($name)
    {
        return Role::where('name_ar', $name)->first()->id;
    }
}
