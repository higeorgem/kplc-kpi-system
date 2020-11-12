<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('task');
            $table->string('status');
            $table->string('resolution_date');
            $table->string('creation_date');
            $table->string('time_spent');
            $table->string('units');
            $table->string('description');
            $table->string('responsible');
            $table->timestamps();

            // $table->foreign('responsible')->references('staff_no')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('targets');
    }
}
