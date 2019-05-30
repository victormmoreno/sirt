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
            $table->integer('entidades_id')->unsigned();
            $table->integer('tipoarticulacion_id')->unsigned();
            $table->tinyInteger('revisado_final')->default('0');
            $table->tinyInteger('tipo_articulacion');
            $table->date('fecha_inicio');
            $table->date('fecha_ejecucion')->nullable();
            $table->date('fecha_cierre')->nullable();
            $table->string('nombre', 100);
            $table->string('observaciones')->nullable();
            $table->tinyInteger('estado')->default('0');
            $table->tinyInteger('acta_inicio')->nullable();
            $table->string('dir_acta_inicio')->nullable();
            $table->tinyInteger('acc')->nullable();
            $table->string('dir_acc')->nullable();
            $table->tinyInteger('actas_seguimiento')->nullable();
            $table->string('dir_actas_seguimiento')->nullable();
            $table->integer('acta_cierre')->nullable();
            $table->string('dir_acta_cierre')->nullable();
            $table->tinyInteger('informe_final')->nullable();
            $table->string('dir_informe_final')->nullable();
            $table->tinyInteger('pantallazo')->nullable();
            $table->string('dir_pantallazo')->nullable();
            $table->tinyInteger('otros')->nullable();
            $table->string('dir_otros')->nullable();
            $table->timestamps();

            $table->index(["entidades_id"], 'fk_articulaciones_entidades1_idx');

            $table->index(["tipoarticulacion_id"], 'fk_articulaciones_tiposarticulacion1_idx');


            $table->foreign('entidades_id', 'fk_articulaciones_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipoarticulacion_id', 'fk_articulaciones_tiposarticulacion1_idx')
                ->references('id')->on('tiposarticulacion')
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
