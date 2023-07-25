<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulationablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulationables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('articulationable_id');
            $table->string('articulationable_type');
            $table->unsignedInteger('articulation_stage_id');
            $table->foreign('articulation_stage_id')
                ->references('id')->on('articulation_stages')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulationables');
    }
}
