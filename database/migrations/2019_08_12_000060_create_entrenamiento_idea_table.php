<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrenamientoIdeaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'entrenamiento_idea';

    /**
     * Run the migrations.
     * @table entrenamiento_idea
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('idea_id');
            $table->unsignedInteger('entrenamiento_id');
            $table->tinyInteger('confirmacion')->nullable()->default('0');
            $table->tinyInteger('canvas')->nullable()->default('0');
            $table->tinyInteger('asistencia1')->nullable()->default('0');
            $table->tinyInteger('asistencia2')->nullable()->default('0');
            $table->tinyInteger('convocado_csibt')->nullable()->default('0');

            $table->index(["entrenamiento_id"], 'fk_ideas_has_entrenamientos_entrenamientos1_idx');

            $table->index(["idea_id"], 'fk_ideas_has_entrenamientos_ideas1_idx');
            $table->nullableTimestamps();


            $table->foreign('entrenamiento_id', 'fk_ideas_has_entrenamientos_entrenamientos1_idx')
                ->references('id')->on('entrenamientos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idea_id', 'fk_ideas_has_entrenamientos_ideas1_idx')
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
