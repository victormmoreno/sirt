<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsoLaboratorioTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'uso_laboratorio';

    /**
     * Run the migrations.
     * @table uso_laboratorio
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('uso')->unsigned();
            $table->integer('laboratorio')->unsigned();
            $table->string('tiempo', 45);

            $table->index(["uso"], 'fk_detalleusolab_usoinfraestructura1_idx');

            $table->index(["laboratorio"], 'fk_detalleusolab_laboratorio1_idx');


            $table->foreign('laboratorio', 'fk_detalleusolab_laboratorio1_idx')
                ->references('idlaboratorio')->on('laboratorio')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('uso', 'uso_laboratorio_uso')
                ->references('idusoinfraestructura')->on('usoinfraestructura')
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
