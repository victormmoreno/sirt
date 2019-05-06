<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposinvestigacionesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'gruposinvestigaciones';

    /**
     * Run the migrations.
     * @table gruposinvestigaciones
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->string('institucion');
            $table->text('observaciones')->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->date('fecha')->nullable();
            $table->unsignedInteger('gestor_id');
            $table->unsignedInteger('clasificacioncolciencias_id');
            $table->unsignedInteger('tipogrupoinvestigacion_id');
            $table->unsignedInteger('tipoarticulacion_id');
            $table->timestamps();

            $table->index(["tipoarticulacion_id"], 'fk_gruposinvestigaciones_tiposarticulaciones1_idx');

            $table->index(["gestor_id"], 'fk_gruposinvestigaciones_gestores1_idx');

            $table->index(["clasificacioncolciencias_id"], 'fk_gruposinvestigaciones_clasificacionescolciencias1_idx');

            $table->index(["tipogrupoinvestigacion_id"], 'fk_gruposinvestigaciones_tiposgruposinvestigaciones1_idx');

            $table->foreign('tipoarticulacion_id', 'fk_gruposinvestigaciones_tiposarticulaciones1_idx')
                ->references('id')->on('tiposarticulaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gestor_id', 'fk_gruposinvestigaciones_gestores1_idx')
                ->references('id')->on('gestores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('clasificacioncolciencias_id', 'fk_gruposinvestigaciones_clasificacionescolciencias1_idx')
                ->references('id')->on('clasificacionescolciencias')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipogrupoinvestigacion_id', 'fk_gruposinvestigaciones_tiposgruposinvestigaciones1_idx')
                ->references('id')->on('tiposgruposinvestigaciones')
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
