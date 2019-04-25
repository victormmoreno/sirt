<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleideacomiteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'detalleideacomite';

    /**
     * Run the migrations.
     * @table detalleideacomite
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idcomite')->unsigned();
            $table->integer('ididea')->unsigned();
            $table->time('hora');
            $table->tinyInteger('admitido');
            $table->tinyInteger('asistencia');
            $table->string('observaciones')->nullable()->default(null);

            $table->index(["ididea"], 'fk_comite_has_entrenamiento_idea1_idx');

            $table->index(["idcomite"], 'fk_comite_has_entrenamiento_comite1_idx');


            $table->foreign('idcomite', 'detalleideacomite_idcomite')
                ->references('idcomite')->on('comite')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ididea', 'fk_comite_has_entrenamiento_idea1_idx')
                ->references('ididea')->on('idea')
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
