<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoriosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'laboratorios';

    /**
     * Run the migrations.
     * @table laboratorios
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->string('participacioncostos', 20)->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->integer('nodo_id')->unsigned();
            $table->integer('linea_id')->unsigned();
            $table->timestamps();

            $table->index(["linea_id"], 'fk_laboratorios_lineas1_idx');

            $table->index(["nodo_id"], 'fk_laboratorios_nodos1_idx');

            $table->foreign('nodo_id', 'fk_laboratorios_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('linea_id', 'fk_laboratorios_lineas1_idx')
                ->references('id')->on('lineas')
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
