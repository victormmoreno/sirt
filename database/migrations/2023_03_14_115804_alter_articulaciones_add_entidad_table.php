<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterArticulacionesAddEntidadTable extends Migration
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
            $table->unsignedInteger('entidad_id')->nullable()->after('id');
            $table->index(["entidad_id"], 'fk_articulacion_entidades1_idx');
            $table->foreign('entidad_id', 'fk_articulacion_entidades1_idx')
            ->references('id')->on('entidades')
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
            $table->dropColumn(['entidad_id']);
        });
    }
}
