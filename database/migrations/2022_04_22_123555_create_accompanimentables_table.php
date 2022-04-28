<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccompanimentablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accompanimentables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('accompanimentable_id');
            $table->string('accompanimentable_type');
            $table->unsignedBigInteger('accompaniment_id');

            $table->foreign('accompaniment_id')->references('id')->on('accompaniments')->onDelete('cascade');
            $table->timestamps();
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
