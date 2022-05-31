<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlNotificacionesTable extends Migration
{
    public $tableName = 'control_notificaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('notificable_type');
            $table->integer('notificable_id')->unsigned();
            $table->unsignedInteger('fase_id')->nullable();
            $table->unsignedInteger('remitente_id');
            $table->unsignedInteger('rol_remitente_id');
            $table->unsignedInteger('receptor_id');
            $table->unsignedInteger('rol_receptor_id');
            $table->datetime('fecha_envio');
            $table->datetime('fecha_aceptacion')->nullable();
            $table->tinyInteger('estado');
            $table->timestamps();

            $table->index(["notificable_type", "notificable_id"], 'control_nofiticaciones_notificable_id_index');
            $table->foreign('fase_id')->references('id')->on('fases')->onDelete('set null');
            $table->foreign('remitente_id')->references('id')->on('users');
            $table->foreign('rol_remitente_id')->references('id')->on('roles');
            $table->foreign('receptor_id')->references('id')->on('users');
            $table->foreign('rol_receptor_id')->references('id')->on('roles');
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
