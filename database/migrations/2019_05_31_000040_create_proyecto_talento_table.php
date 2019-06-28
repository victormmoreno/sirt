<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoTalentoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proyecto_talento';

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
            $table->increments('id');
            $table->unsignedInteger('proyecto_id');
            $table->unsignedInteger('talento_id');
            $table->tinyInteger('talento_lider')->default('0');
            $table->timestamps();

            $table->index(["talento_id"], 'fk_proyecto_talento_talentos1_idx');

            $table->index(["proyecto_id"], 'fk_proyecto_talento_proyectos1_idx');


            $table->foreign('proyecto_id', 'fk_proyecto_talento_proyectos1_idx')
                ->references('id')->on('proyectos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('talento_id', 'fk_proyecto_talento_talentos1_idx')
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
