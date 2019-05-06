<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoTalentoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proyecto_talento';

    /**
     * Run the migrations.
     * @table proyecto_talento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('proyecto_id')->unsigned();
            $table->integer('talento_id')->unsigned();
            $table->timestamps();

            $table->index(["talento_id"], 'fk_detalleproyectostalentos_talentos1_idx');

            $table->index(["proyecto_id"], 'fk_detalleproyectostalentos_proyectos1_idx');

            $table->foreign('proyecto_id', 'fk_detalleproyectostalentos_proyectos1_idx')
                ->references('id')->on('proyectos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('talento_id', 'fk_detalleproyectostalentos_talentos1_idx')
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
