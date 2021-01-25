<?php

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
