<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoMantenimientoTable extends Migration
{

     public $tableName = 'equipo_mantenimiento';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('equipo_id');
            $table->year('ultimo_anio_mantenimiento')->default(Carbon::now()->year); //ultimo año del matenimiento
            $table->string('valor_mantenimiento', 45)->default(0);
            $table->timestamps();

            $table->index(["equipo_id"], 'fk_laboratorio_id_equipo1_idx');

            $table->foreign('equipo_id', 'fk_equipo_equipo_mantenimiento1_idx')
                ->references('id')->on('equipos')
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
