<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestorUsoTable extends Migration
{

    public $tableName = 'gestor_uso';
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
            $table->unsignedInteger('gestor_id');
            $table->unsignedBigInteger('usoinfraestructura_id');
            $table->string('asesoria_directa',10)->default(0);
            $table->string('asesoria_indirecta',10)->default(0);
            $table->float('costo_asesoria',30,2)->default(0);
            $table->timestamps();

            $table->index(["gestor_id"], 'fk_gestor_uso_gestor1_idx');
            $table->index(["usoinfraestructura_id"], 'fk_gestor_uso_usoinfraestructura1_idx');


            $table->foreign('gestor_id', 'fk_gestor_uso_gestor1_idx')
                ->references('id')->on('gestores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('usoinfraestructura_id', 'fk_gestor_uso_usoinfraestructura1_idx')
                ->references('id')->on('usoinfraestructuras')
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
