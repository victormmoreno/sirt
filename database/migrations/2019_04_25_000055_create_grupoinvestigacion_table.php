<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoinvestigacionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'grupoinvestigacion';

    /**
     * Run the migrations.
     * @table grupoinvestigacion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idgrupoinvestigacion');
            $table->integer('idgestor')->unsigned();
            $table->integer('idclasificacioncolciencias')->unsigned();
            $table->string('nombre', 100);
            $table->string('institucion', 100);
            $table->string('observaciones')->nullable()->default(null);
            $table->tinyInteger('estado')->default('1');
            $table->tinyInteger('tipogrupoinvestigacion')->default('0');
            $table->tinyInteger('tipoarticulacion');
            $table->date('fecha');

            $table->index(["idgestor"], 'fk_grupoinvestigacion_gestor1_idx');

            $table->index(["idclasificacioncolciencias"], 'fk_grupoinvestigacion_clasificacioncolciencias1_idx');


            $table->foreign('idclasificacioncolciencias', 'fk_grupoinvestigacion_clasificacioncolciencias1_idx')
                ->references('idclasificacioncolciencias')->on('clasificacioncolciencias')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idgestor', 'fk_grupoinvestigacion_gestor1_idx')
                ->references('idgestor')->on('gestor')
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
