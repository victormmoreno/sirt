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
            $table->unsignedInteger('entidad_id');
            $table->unsignedInteger('tipoarticulacion_id');
            $table->unsignedInteger('gestor_id');
            $table->string('codigo_articulacion', 30)->unique();
            $table->string('nombre', 200);
            $table->tinyInteger('revisado_final')->default('0');
            $table->tinyInteger('tipo_articulacion');
            $table->date('fecha_inicio');
            $table->date('fecha_ejecucion')->nullable();
            $table->date('fecha_cierre')->nullable();
            $table->string('observaciones',1000)->nullable();
            $table->tinyInteger('estado')->default('0');
            $table->tinyInteger('acta_inicio')->nullable();
            $table->tinyInteger('acc')->nullable();
            $table->tinyInteger('actas_seguimiento')->nullable();
            $table->integer('acta_cierre')->nullable();
            $table->tinyInteger('informe_final')->nullable();
            $table->tinyInteger('pantallazo')->nullable();
            $table->tinyInteger('otros')->nullable();
            $table->timestamps();

            $table->index(["entidad_id"], 'fk_articulaciones_entidad1_idx');

            $table->index(["tipoarticulacion_id"], 'fk_articulaciones_tiposarticulacion1_idx');
            $table->index(["gestor_id"], 'fk_articulaciones_gestores1_idx');


            $table->foreign('entidad_id', 'fk_articulaciones_entidad1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipoarticulacion_id', 'fk_articulaciones_tiposarticulacion1_idx')
                ->references('id')->on('tiposarticulaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gestor_id', 'fk_articulaciones_gestores1_idx')
                ->references('id')->on('gestores')
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
