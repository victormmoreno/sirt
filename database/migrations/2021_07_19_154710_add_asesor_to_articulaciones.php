<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAsesorToArticulaciones extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'articulaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('asesor_id')->nullable()->after('articulacion_proyecto_id');
            $table->unsignedInteger('nodo_id')->nullable()->after('asesor_id');

            $table->foreign('asesor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('nodo_id')->references('id')->on('nodos')->onDelete('set null');
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
            $table->dropColumn(['asesor_id', 'nodo_id']);
        });
    }
}
