<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposinvestigacionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'gruposinvestigacion';

    /**
     * Run the migrations.
     * @table gruposinvestigacion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('entidad_id');
            $table->unsignedInteger('clasificacioncolciencias_id');
            $table->string('codigo_grupo', 15);
            $table->tinyInteger('tipogrupo')->default(1);
            $table->tinyInteger('estado')->default(1);
            $table->string('institucion',200);
            $table->string('nombres_contacto',60);
            $table->string('correo_contacto',100);
            $table->integer('telefono_contacto')->nullable();
            $table->timestamps();
            
            $table->index(["entidad_id"], 'fk_gruposinvestigacion_entidades1_idx');

            $table->index(["clasificacioncolciencias_id"], 'fk_gruposinvestigacion_clasificacionescolciencias1_idx');

            $table->unique(["codigo_grupo"], 'codigo_grupo_UNIQUE');

            $table->foreign('entidad_id', 'fk_gruposinvestigacion_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('clasificacioncolciencias_id', 'fk_gruposinvestigacion_clasificacionescolciencias1_idx')
                ->references('id')->on('clasificacionescolciencias')
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
