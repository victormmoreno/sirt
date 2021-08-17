<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharlasinformativasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'charlasinformativas';

    /**
     * Run the migrations.
     * @table charlasinformativas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('nodo_id');
            $table->string('codigo_charla', 20);
            $table->date('fecha');
            $table->string('encargado', 75);
            $table->integer('nro_asistentes');
            $table->string('observacion',1000)->nullable()->default(null);
            $table->tinyInteger('listado_asistentes')->nullable()->default('0');
            $table->tinyInteger('evidencia_fotografica')->nullable()->default('0');
            $table->tinyInteger('programacion')->nullable()->default('0');
            $table->tinyInteger('estado')->nullable()->default('1');

            $table->index(["nodo_id"], 'fk_charlasinvformativas_nodos1_idx');

            $table->unique(["codigo_charla"], 'codigo_charla_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('nodo_id', 'fk_charlasinvformativas_nodos1_idx')
                ->references('id')->on('nodos')
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
