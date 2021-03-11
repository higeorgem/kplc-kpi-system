<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'kpi-list',
            'kpi-create',
            'kpi-edit',
            'kpi-delete',
            'task-list',
            'task-create',
            'task-edit',
            'task-delete',
            'structures-list',
            'division-list',
            'division-create',
            'division-edit',
            'division-delete',
            'department-list',
            'department-create',
            'department-edit',
            'department-delete',
            'section-list',
            'section-create',
            'section-edit',
            'section-delete',
            'subsection-list',
            'subsection-create',
            'subsection-edit',
            'subsection-delete',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
