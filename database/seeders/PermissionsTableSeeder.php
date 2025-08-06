<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'team_create',
            ],
            [
                'id'    => 18,
                'title' => 'team_edit',
            ],
            [
                'id'    => 19,
                'title' => 'team_show',
            ],
            [
                'id'    => 20,
                'title' => 'team_delete',
            ],
            [
                'id'    => 21,
                'title' => 'team_access',
            ],
            [
                'id'    => 22,
                'title' => 'task_management_access',
            ],
            [
                'id'    => 23,
                'title' => 'task_status_create',
            ],
            [
                'id'    => 24,
                'title' => 'task_status_edit',
            ],
            [
                'id'    => 25,
                'title' => 'task_status_show',
            ],
            [
                'id'    => 26,
                'title' => 'task_status_delete',
            ],
            [
                'id'    => 27,
                'title' => 'task_status_access',
            ],
            [
                'id'    => 28,
                'title' => 'task_tag_create',
            ],
            [
                'id'    => 29,
                'title' => 'task_tag_edit',
            ],
            [
                'id'    => 30,
                'title' => 'task_tag_show',
            ],
            [
                'id'    => 31,
                'title' => 'task_tag_delete',
            ],
            [
                'id'    => 32,
                'title' => 'task_tag_access',
            ],
            [
                'id'    => 33,
                'title' => 'task_create',
            ],
            [
                'id'    => 34,
                'title' => 'task_edit',
            ],
            [
                'id'    => 35,
                'title' => 'task_show',
            ],
            [
                'id'    => 36,
                'title' => 'task_delete',
            ],
            [
                'id'    => 37,
                'title' => 'task_access',
            ],
            [
                'id'    => 38,
                'title' => 'tasks_calendar_access',
            ],
            [
                'id'    => 39,
                'title' => 'school_management_access',
            ],
            [
                'id'    => 40,
                'title' => 'school_create',
            ],
            [
                'id'    => 41,
                'title' => 'school_edit',
            ],
            [
                'id'    => 42,
                'title' => 'school_show',
            ],
            [
                'id'    => 43,
                'title' => 'school_delete',
            ],
            [
                'id'    => 44,
                'title' => 'school_access',
            ],
            [
                'id'    => 45,
                'title' => 'asset_management_access',
            ],
            [
                'id'    => 46,
                'title' => 'category_create',
            ],
            [
                'id'    => 47,
                'title' => 'category_edit',
            ],
            [
                'id'    => 48,
                'title' => 'category_show',
            ],
            [
                'id'    => 49,
                'title' => 'category_delete',
            ],
            [
                'id'    => 50,
                'title' => 'category_access',
            ],
            [
                'id'    => 51,
                'title' => 'location_create',
            ],
            [
                'id'    => 52,
                'title' => 'location_edit',
            ],
            [
                'id'    => 53,
                'title' => 'location_show',
            ],
            [
                'id'    => 54,
                'title' => 'location_delete',
            ],
            [
                'id'    => 55,
                'title' => 'location_access',
            ],
            [
                'id'    => 56,
                'title' => 'status_create',
            ],
            [
                'id'    => 57,
                'title' => 'status_edit',
            ],
            [
                'id'    => 58,
                'title' => 'status_show',
            ],
            [
                'id'    => 59,
                'title' => 'status_delete',
            ],
            [
                'id'    => 60,
                'title' => 'status_access',
            ],
            [
                'id'    => 61,
                'title' => 'asset_allocation_access',
            ],
            [
                'id'    => 62,
                'title' => 'allocation_create',
            ],
            [
                'id'    => 63,
                'title' => 'allocation_edit',
            ],
            [
                'id'    => 64,
                'title' => 'allocation_show',
            ],
            [
                'id'    => 65,
                'title' => 'allocation_delete',
            ],
            [
                'id'    => 66,
                'title' => 'allocation_access',
            ],
            [
                'id'    => 67,
                'title' => 'employee_management_access',
            ],
            [
                'id'    => 68,
                'title' => 'department_create',
            ],
            [
                'id'    => 69,
                'title' => 'department_edit',
            ],
            [
                'id'    => 70,
                'title' => 'department_show',
            ],
            [
                'id'    => 71,
                'title' => 'department_delete',
            ],
            [
                'id'    => 72,
                'title' => 'department_access',
            ],
            [
                'id'    => 73,
                'title' => 'employee_create',
            ],
            [
                'id'    => 74,
                'title' => 'employee_edit',
            ],
            [
                'id'    => 75,
                'title' => 'employee_show',
            ],
            [
                'id'    => 76,
                'title' => 'employee_delete',
            ],
            [
                'id'    => 77,
                'title' => 'employee_access',
            ],
            [
                'id'    => 78,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
