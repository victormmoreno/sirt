<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeaComiteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'idea_comite';

    /**
     * Run the migrations.
     * @table idea_comite
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->time('hora');
            $table->tinyInteger('admitido')->nullable()->default('0');
            $table->tinyInteger('asistencia')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedInteger('comite_id');
            $table->unsignedInteger('idea_id');
            $table->timestamps();

            $table->index(["idea_id"], 'fk_idea_comite_ideas1_idx');

            $table->index(["comite_id"], 'fk_idea_comite_comites1_idx');

            $table->foreign('comite_id', 'fk_idea_comite_comites1_idx')
                ->references('id')->on('comites')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idea_id', 'fk_idea_comite_ideas1_idx')
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
