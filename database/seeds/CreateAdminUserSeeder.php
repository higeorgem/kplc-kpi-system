<?php

use App\Department;
use App\Division;
use App\Section;
use App\SubSection;
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // division
        $division = Division::create(['name' => 'ICT']);

        // department
        $department = Department::create([
            'division_id'=> $division->id,
            'department_name' => 'Systems'
        ]);
        // section
        $section = Section::create([
            'department_id'=> $department->id,
            'section_name' => 'System Administrators'
        ]);
        // subsection
        $subsection = SubSection::create([
            'division_id'=> $division->id,
            'department_id'=> $department->id,
            'section_id' => $section->id,
            'subsection_name'=> 'Super Admins'
        ]);

        $user = User::create([
            'staff_no' => 88888,
            'first_name' => 'System',
            'middle_name' => 'A',
            'last_name' => 'Administrator',
            'title' => 'System Administrator',
            'email' => 'systemadmin@gmail.com',
            'password' => bcrypt('sys@kplc#2020')
        ]);

        $role = Role::create(['name' => 'Administrator']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
