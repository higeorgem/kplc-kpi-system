<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {

    $kpi_task_count = Task::withTrashed()->where('description', 'kpi001')->where('flag', 0)->count() + 1;
    //generate the task id
    $taskID = str_pad($kpi_task_count, 4, '0', STR_PAD_LEFT);
    return [
        "key" =>  'kpi001-' . $taskID,
        "task" => $faker->word,
        "status" => 0,
        "units" => 'Hours',
        "created_date" => $faker->date('Y-m-d', 'now'),
        "resolution_date" => $faker->dateTimeBetween('-1 year','now'),
        "description" => 'kpi001',
        "responsible" => 14758,
    ];
});
