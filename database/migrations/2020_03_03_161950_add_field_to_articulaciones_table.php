<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToArticulacionesTable extends Migration
{
    public $tableName = 'articulaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('tipoarticulacion_id')->nullable()->change();
            $table->string('acuerdos', 1000)->nullable()->default(null)->after('observaciones');
            $table->string('alcance_articulacion', 1000)->nullable()->default(null)->after('acuerdos');
            $table->unsignedInteger('fase_id')->nullable()->default(null)->after('tipoarticulacion_id');

            $table->index(["fase_id"], 'fk_articulaciones_fases1_idx');
            
            $table->foreign('fase_id', 'fk_articulaciones_fases1_idx')
            ->references('id')->on('fases')
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
            $table->dropIndex(['fase_id']);
            $table->dropColumn(['acuerdos', 'alcance_articulacion', 'fase_id']);
        });
    }
}
