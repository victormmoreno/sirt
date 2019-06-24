<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosArticulacionesTable extends Migration
{

    public $tableName = 'archivosarticulaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('articulacion_id');
            $table->unsignedInteger('fase_id');
            $table->string('ruta',1000);
            $table->timestamps();

            $table->index(["articulacion_id"], 'fk_archivosarticulaciones_articulaciones1_idx');

            $table->index(["fase_id"], 'fk_archivosarticulaciones_fases1_idx');

            $table->unique(["ruta"], 'ruta_UNIQUE');

            $table->foreign('articulacion_id', 'fk_archivosarticulaciones_articulaciones1_idx')
                ->references('id')->on('articulaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('fase_id', 'fk_archivosarticulaciones_fases1_idx')
                ->references('id')->on('fases')
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
