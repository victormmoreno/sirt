<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleproyectotalentoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'detalleproyectotalento';

    /**
     * Run the migrations.
     * @table detalleproyectotalento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idproyecto')->unsigned();
            $table->integer('idtalento')->unsigned();

            $table->index(["idtalento"], 'fk_detalleproyectotalento_talento1_idx');

            $table->index(["idproyecto"], 'fk_detalleproyectotalento_proyecto1_idx');


            $table->foreign('idproyecto', 'detalleproyectotalento_idproyecto')
                ->references('idproyecto')->on('proyecto')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idtalento', 'fk_detalleproyectotalento_talento1_idx')
                ->references('idtalento')->on('talento')
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
