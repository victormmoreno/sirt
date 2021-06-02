<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySedesTable extends Migration
{
    public $tableName = 'sedes';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            // Nuevos campos
            $table->unsignedInteger('ciudad_id')->after('empresa_id');
            $table->string('direccion', 100)->after('nombre_sede');

            $table->index(["ciudad_id"], 'fk_sedes_ciudad1_idx');

            $table->foreign('ciudad_id', 'fk_sedes_ciudad1_idx')
                ->references('id')->on('ciudades')
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
            $table->dropColumn(['ciudad_id', 'direccion']);
        });
    }
}
