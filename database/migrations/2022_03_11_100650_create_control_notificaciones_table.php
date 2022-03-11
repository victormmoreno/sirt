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
            $table->string('model_type');
            $table->integer('model_id')->unsigned();
            $table->unsignedInteger('fase_id');
            $table->unsignedInteger('remitente_id');
            $table->unsignedInteger('receptor_id');
            $table->date('fecha_envio');
            $table->date('fecha_aceptacion')->nullable();
            $table->timestamps();

            $table->index(["model_type", "model_id"], 'control_nofiticaciones_model_id_index');
            $table->foreign('fase_id')->references('id')->on('fases');
            $table->foreign('remitente_id')->references('id')->on('users');
            $table->foreign('receptor_id')->references('id')->on('users');
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
