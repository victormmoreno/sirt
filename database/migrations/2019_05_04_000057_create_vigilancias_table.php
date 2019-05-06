<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVigilanciasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'vigilancias';

    /**
     * Run the migrations.
     * @table vigilancias
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fechainicio')->nullable();
            $table->date('fechafin')->nullable();
            $table->integer('horas')->nullable();
            $table->text('observacion')->nullable();
            $table->integer('proyecto_id')->unsigned();
            $table->timestamps();

            $table->index(["proyecto_id"], 'fk_vigilancias_proyectos1_idx');

            $table->foreign('proyecto_id', 'fk_vigilancias_proyectos1_idx')
                ->references('id')->on('proyectos')
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
