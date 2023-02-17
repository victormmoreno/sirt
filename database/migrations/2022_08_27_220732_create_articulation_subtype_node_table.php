<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulationSubtypeNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulation_subtype_node', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('nodo_id');
            $table->bigInteger('articulation_subtype_id')->unsigned();
            $table->timestamps();

            $table->foreign('nodo_id')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('articulation_subtype_id')
                ->references('id')->on('articulation_subtypes')
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
        Schema::dropIfExists('articulation_subtype_node');
    }
}
