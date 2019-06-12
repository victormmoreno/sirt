<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrenamientosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'entrenamientos';

    /**
     * Run the migrations.
     * @table entrenamientos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fecha_sesion1');
            $table->date('fecha_sesion2');
            $table->tinyInteger('correos')->nullable()->default('0');
            $table->string('dir_correos',1000)->nullable();
            $table->tinyInteger('fotos')->nullable()->default('0');
            $table->string('dir_fotos',1000)->nullable();
            $table->tinyInteger('listado_asistencia')->nullable()->default('0');
            $table->string('dir_listado_asistencia',1000)->nullable();
            $table->timestamps();
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
