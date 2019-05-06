<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeaProyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'idea_proyecto';

    /**
     * Run the migrations.
     * @table idea_proyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('idea_id');
            $table->unsignedInteger('proyecto_id');
            $table->timestamps();

            $table->index(["proyecto_id"], 'fk_idea_proyecto_proyectos1_idx');

            $table->index(["idea_id"], 'fk_idea_proyecto_ideas1_idx');

            $table->foreign('idea_id', 'fk_idea_proyecto_ideas1_idx')
                ->references('id')->on('ideas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('proyecto_id', 'fk_idea_proyecto_proyectos1_idx')
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
