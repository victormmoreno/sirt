<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComiteIdeaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comite_idea';

    /**
     * Run the migrations.
     * @table entrenamiento_comite
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('idea_id');
            $table->unsignedInteger('comite_id');
            $table->time('hora');
            $table->tinyInteger('admitido')->default('0');
            $table->tinyInteger('asistencia')->default('0');
            $table->string('observaciones',2000)->nullable();
            $table->timestamps();

            $table->index(["idea_id"], 'fk_entrenamiento_comite_idea1_idx');

            $table->index(["comite_id"], 'fk_entrenamientos_has_comites_comites1_idx');


            $table->foreign('comite_id', 'fk_entrenamientos_has_comites_comites1_idx')
                ->references('id')->on('comites')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idea_id', 'fk_entrenamiento_comite_idea1_idx')
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
