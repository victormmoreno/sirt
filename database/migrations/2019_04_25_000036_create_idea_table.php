<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'idea';

    /**
     * Run the migrations.
     * @table idea
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ididea');
            $table->integer('idnodo')->unsigned();
            $table->string('nombrec', 45);
            $table->string('apellidoc', 45);
            $table->string('correo', 100);
            $table->string('telefono', 45);
            $table->string('nombreproyecto', 100);
            $table->tinyInteger('aprendizsena');
            $table->tinyInteger('pregunta1');
            $table->tinyInteger('pregunta2');
            $table->tinyInteger('pregunta3');
            $table->string('descripcion');
            $table->string('objetivo');
            $table->string('alcance');
            $table->date('fecha');
            $table->tinyInteger('estado')->default('1');
            $table->tinyInteger('tipoidea')->default('1');

            $table->index(["idnodo"], 'fk_idea_nodo1_idx');


            $table->foreign('idnodo', 'fk_idea_nodo1_idx')
                ->references('idnodo')->on('nodo')
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
