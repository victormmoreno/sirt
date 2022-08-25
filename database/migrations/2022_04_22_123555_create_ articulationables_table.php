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
            $table->bigInteger('articulationable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accompanimentables');
    }
}
