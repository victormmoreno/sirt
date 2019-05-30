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
    public $tableName = 'charlasinformativas';

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
            $table->integer('nodo_id')->unsigned();
            $table->date('fecha');
            $table->string('encargado', 75);
            $table->integer('nro_asistentes');
            $table->text('observacion')->nullable();
            $table->tinyInteger('listado_asistentes')->nullable()->default('0');
            $table->string('evidencia_fotografica', 45)->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_charlasinvformativas_nodos1_idx');


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
