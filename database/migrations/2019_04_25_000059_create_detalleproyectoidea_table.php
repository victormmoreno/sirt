<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleproyectoideaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'detalleproyectoidea';

    /**
     * Run the migrations.
     * @table detalleproyectoidea
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idproyecto')->unsigned();
            $table->integer('ididea')->unsigned();

            $table->index(["idproyecto"], 'fk_detalle_proyecto_comite_proyecto1_idx');

            $table->index(["ididea"], 'fk_detalle_proyecto_comite_idea1_idx');


            $table->foreign('ididea', 'fk_detalle_proyecto_comite_idea1_idx')
                ->references('ididea')->on('idea')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idproyecto', 'detalleproyectoidea_idproyecto')
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
