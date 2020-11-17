<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $employees = [
            [
                'staff_no' => 14758,
                'name' => 'Andrew Obadha',
                'status' => 1,
                'title' => 'DEVELOPER',
                'division_id' => 1007,
            ],
            [
                'staff_no' => 15323,
                'name' => 'Joseph Ombaka',
                'status' => 1,
                'title' => 'DEVELOPER',
                'division_id' => 1007,
            ],
            [
                'staff_no' => 14039,
                'name' => 'Paul Mugo',
                'status' => 0,
                'title' => 'DEVELOPER',
                'division_id' => 1007,
            ],
            [
                'staff_no' => 16679,
                'name' => ' Antony Kirubi',
                'status' => 1,
                'title' => 'DEVELOPER',
                'division_id' => 1007,
            ],
            [
                'staff_no' => 85128,
                'name' => 'Muriithi Kinoti',
                'status' => 1,
                'title' => 'JNR DEVELOPER',
                'division_id' => 1007,
            ],
            [
                'staff_no' => 14041,
                'name' => 'Charles Kirimi',
                'status' => 0,
                'title' => 'SNR DEVELOPER',
                'division_id' => 1007,
            ],
            [
                'staff_no' => 13686,
                'name' => 'Charles Ong’wen',
                'status' => 1,
                'title' => 'DEVELOPER',
                'division_id' => 1007,
            ],
            [
                'staff_no' => 51575,
                'name' => 'John Nyaga Ireri',
                'status' => 1,
                'title' => 'DEVELOPER',
                'division_id' => 1007,
            ],
        ];
        foreach ($employees as $key => $employee) {
            DB::table('users')->insert([
                'staff_no' => $employee['staff_no'],
                'name' => $employee['name'],
                'status' => $employee['status'],
                'title' => $employee['title'],
                'division_id' => $employee['division_id'],
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
