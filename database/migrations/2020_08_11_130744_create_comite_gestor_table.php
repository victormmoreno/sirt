<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComiteGestorTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'comite_gestor';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comite_gestor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('gestor_id');
            $table->unsignedInteger('comite_id');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->index(["gestor_id"], 'fk_comites_gestor1_idx');

            $table->index(["comite_id"], 'fk_comites_comites1_idx');
            $table->nullableTimestamps();


            $table->foreign('gestor_id', 'fk_comites_gestor1_idx')
                ->references('id')->on('gestores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('comite_id', 'fk_comites_comites1_idx')
                ->references('id')->on('comites')
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
