<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsosinfraestructurasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'usosinfraestructuras';

    /**
     * Run the migrations.
     * @table usosinfraestructuras
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fecha');
            $table->string('asesoria_directa', 45)->nullable();
            $table->string('asesoria_indirecta', 45)->nullable();
            $table->text('descripcion')->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->unsignedInteger('proyecto_id');
            $table->unsignedInteger('gestor_id');
            $table->timestamps();

            $table->index(["gestor_id"], 'fk_usosinfraestructuras_gestores1_idx');

            $table->index(["proyecto_id"], 'fk_usosinfraestructuras_proyectos1_idx');

            $table->foreign('proyecto_id', 'fk_usosinfraestructuras_proyectos1_idx')
                ->references('id')->on('proyectos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gestor_id', 'fk_usosinfraestructuras_gestores1_idx')
                ->references('id')->on('gestores')
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
