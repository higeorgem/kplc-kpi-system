<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKPISTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('k_p_i_s', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('perspective');
            $table->string('period');
            $table->string('structure');
            $table->string('structure_id');
            $table->string('kpi');
            $table->string('kpi_type');
            $table->string('created_by');
            $table->string('unit_of_measure');
            // $table->string('weight');
            // $table->string('previous_target');
            // $table->string('target');
            // $table->string('achievement');
            // $table->string('validated_achievement');
            // $table->string('row_score')->nullable();
            // $table->string('weighted_score')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('k_p_i_s');
    }
}
