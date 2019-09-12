<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsoLaboratoriosTable extends Migration
{

    public $tableName = 'uso_laboratorios';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usoinfraestructura_id');
            $table->unsignedBigInteger('laboratorio_id');
            $table->float('tiempo')->default(0);
            $table->timestamps();

            $table->index(["usoinfraestructura_id"], 'fk_uso_laboratorio_usoinfraestructura1_idx');
            $table->index(["laboratorio_id"], 'fk_uso_laboratorio_laboratorio1_idx');

            $table->foreign('usoinfraestructura_id', 'fk_uso_laboratorio_usoinfraestructura1_idx')
                ->references('id')->on('usoinfraestructuras')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('laboratorio_id', 'fk_uso_laboratorio_laboratorio1_idx')
                ->references('id')->on('laboratorios')
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
