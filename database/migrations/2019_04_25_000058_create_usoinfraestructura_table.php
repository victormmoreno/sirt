<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsoinfraestructuraTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'usoinfraestructura';

    /**
     * Run the migrations.
     * @table usoinfraestructura
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idusoinfraestructura');
            $table->integer('gestor')->unsigned();
            $table->integer('proyecto')->unsigned();
            $table->date('fecha');
            $table->string('asesoriad', 45)->nullable()->default(null);
            $table->string('asesoriai', 45)->nullable()->default(null);
            $table->string('descripcion')->nullable()->default(null);
            $table->integer('estado')->nullable()->default('1');

            $table->index(["gestor"], 'fk_usoinfraestructura_gestor1_idx');

            $table->index(["proyecto"], 'fk_usoinfraestructura_proyecto1_idx');


            $table->foreign('gestor', 'fk_usoinfraestructura_gestor1_idx')
                ->references('idgestor')->on('gestor')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('proyecto', 'fk_usoinfraestructura_proyecto1_idx')
                ->references('idproyecto')->on('proyecto')
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
