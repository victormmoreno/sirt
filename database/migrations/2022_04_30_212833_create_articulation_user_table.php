<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulation_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('articulation_id');
            $table->unsignedInteger('user_id');
            $table->foreign('articulation_id')->references('id')->on('articulations')->onDelete('no action');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulation_user');
    }
}
