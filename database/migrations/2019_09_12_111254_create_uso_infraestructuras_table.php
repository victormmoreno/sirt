<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsoInfraestructurasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'usoinfraestructuras';
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
            $table->unsignedInteger('actividad_id');
            $table->date('fecha');
            $table->string('descripcion', 2000)->nullable();
            $table->tinyInteger('estado')->default('1');
            $table->timestamps();

            $table->index(["actividad_id"], 'fk_usoinfraestructura_actividad1_idx');

            $table->foreign('actividad_id', 'actividad_id')
                ->references('id')->on('actividades')
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
