<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHonorariosTable extends Migration
{
    public $tableName = 'honorarios';
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
            $table->unsignedInteger('gestor_id');
            $table->year('anio');
            $table->float('valor', 20, 2)->default(0);
            $table->timestamps();

            $table->index(["gestor_id"], 'fk_honorarios_gestor1_idx');

            $table->foreign('gestor_id', 'fk_honorarios_gestor1_idx')
                ->references('id')->on('gestores')
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
