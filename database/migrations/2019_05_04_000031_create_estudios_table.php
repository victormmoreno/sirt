<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'estudios';

    /**
     * Run the migrations.
     * @table estudios
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->string('titulo')->nullable();
            $table->integer('duracion')->nullable();
            $table->integer('nivelacademico_id')->unsigned();
            $table->timestamps();

            $table->index(["nivelacademico_id"], 'fk_estudios_nivelesacademicos1_idx');

            $table->foreign('nivelacademico_id', 'fk_estudios_nivelesacademicos1_idx')
                ->references('id')->on('nivelesacademicos')
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
