<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivoscomitesTable extends Migration
{

    public $tableName = 'archivoscomites';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comite_id');
            $table->string('ruta',1000);
            $table->timestamps();

            $table->index(["comite_id"], 'fk_archivoscomites_comites1_idx');

            $table->unique(["ruta"], 'ruta_UNIQUE');

            $table->foreign('comite_id', 'fk_archivoscomites_comites1_idx')
                ->references('id')->on('comites')
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
        Schema::dropIfExists($this->tableName);
    }
}
