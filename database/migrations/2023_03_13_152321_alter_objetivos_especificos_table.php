<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterObjetivosEspecificosTable extends Migration
{
    public $tableName = 'objetivos_especificos';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('proyecto_id')->nullable()->after('id');
            $table->index(["proyecto_id"], 'fk_proyecto_objetivos_especificos1_idx');
            $table->foreign('proyecto_id', 'fk_proyecto_objetivos_especificos1_idx')
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
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['proyecto_id']);
        });
    }
}
