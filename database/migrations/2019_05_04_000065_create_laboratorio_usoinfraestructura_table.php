<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioUsoinfraestructuraTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'laboratorio_usoinfraestructura';

    /**
     * Run the migrations.
     * @table laboratorio_usoinfraestructura
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('laboratorios_id')->unsigned();
            $table->integer('usosinfraestructuras_id')->unsigned();
            $table->timestamps();

            $table->index(["laboratorios_id"], 'fk_laboratorio_usoinfraestructura_laboratorios1_idx');

            $table->index(["usosinfraestructuras_id"], 'fk_laboratorio_usoinfraestructura_usosinfraestructuras1_idx');

            $table->foreign('laboratorios_id', 'fk_laboratorio_usoinfraestructura_laboratorios1_idx')
                ->references('id')->on('laboratorios')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('usosinfraestructuras_id', 'fk_laboratorio_usoinfraestructura_usosinfraestructuras1_idx')
                ->references('id')->on('usosinfraestructuras')
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
