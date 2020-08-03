<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'articulaciones';

    /**
     * Run the migrations.
     * @table articulaciones
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('articulacion_proyecto_id');
            $table->tinyInteger('tipo_articulacion');
            $table->date('fecha_ejecucion')->nullable()->default(null);
            $table->string('observaciones',1000)->nullable()->default(null);
            $table->tinyInteger('estado')->default('0');
            $table->tinyInteger('acc')->nullable()->default(null);
            $table->tinyInteger('informe_final')->nullable()->default(null);
            $table->tinyInteger('pantallazo')->nullable()->default(null);
            $table->tinyInteger('otros')->nullable()->default(null);

            $table->index(["articulacion_proyecto_id"], 'fk_articulaciones_articulacion_proyecto1_idx');

            $table->index(["tipoarticulacion_id"], 'fk_articulaciones_tiposarticulacion1_idx');
            $table->nullableTimestamps();

            $table->foreign('articulacion_proyecto_id', 'fk_articulaciones_articulacion_proyecto1_idx')
                ->references('id')->on('articulacion_proyecto')
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
