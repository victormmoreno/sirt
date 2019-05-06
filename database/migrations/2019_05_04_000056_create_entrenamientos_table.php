<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->tinyInteger('confirmacion');
            $table->dateTime('sesion1');
            $table->dateTime('sesion2');
            $table->string('asistencia1', 45)->nullable();
            $table->string('asistencia2', 45)->nullable();
            $table->string('convocado', 45)->nullable();
            $table->string('canvas', 45)->nullable();
            $table->integer('idea_id')->unsigned();
            $table->timestamps();

            $table->index(["idea_id"], 'fk_entrenamientos_ideas1_idx');

            $table->foreign('idea_id', 'fk_entrenamientos_ideas1_idx')
                ->references('id')->on('ideas')
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
