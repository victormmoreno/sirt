<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepreciacionesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'depreciaciones';

    /**
     * Run the migrations.
     * @table depreciaciones
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('equipo', 45)->nullable();
            $table->string('marcal', 45)->nullable();
            $table->string('referencia', 45)->nullable();
            $table->string('costo', 45)->nullable();
            $table->string('vidautil', 45)->nullable();
            $table->string('anio', 45)->nullable();
            $table->string('horasuso', 45)->nullable();
            $table->integer('laboratorio_id')->unsigned();
            $table->timestamps();

            $table->index(["laboratorio_id"], 'fk_depreciaciones_laboratorios1_idx');

            $table->foreign('laboratorio_id', 'fk_depreciaciones_laboratorios1_idx')
                ->references('id')->on('laboratorios')
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
