<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsoTalentoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'uso_talento';

    /**
     * Run the migrations.
     * @table uso_talento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('usoinfraestructura')->unsigned();
            $table->integer('talento')->unsigned();

            $table->index(["talento"], 'fk_detalleusotalento_talento1_idx');

            $table->index(["usoinfraestructura"], 'fk_detalleusotalento_usoinfraestructura1_idx');


            $table->foreign('talento', 'fk_detalleusotalento_talento1_idx')
                ->references('idtalento')->on('talento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('usoinfraestructura', 'uso_talento_usoinfraestructura')
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
