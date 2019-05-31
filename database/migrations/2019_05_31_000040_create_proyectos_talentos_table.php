<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTalentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proyectos_talentos';

    /**
     * Run the migrations.
     * @table proyectos_talentos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('proyecto_id');
            $table->increments('talento_id');
            $table->timestamps();

            $table->index(["talento_id"], 'fk_proyectos_talentos_talentos1_idx');

            $table->index(["proyecto_id"], 'fk_proyectos_talentos_proyectos1_idx');


            $table->foreign('proyecto_id', 'fk_proyectos_talentos_proyectos1_idx')
                ->references('id')->on('proyectos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('talento_id', 'fk_proyectos_talentos_talentos1_idx')
                ->references('id')->on('talentos')
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
