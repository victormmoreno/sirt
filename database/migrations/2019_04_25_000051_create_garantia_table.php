<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'garantia';

    /**
     * Run the migrations.
     * @table garantia
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_garantia');
            $table->string('nombre_garantia', 45)->nullable()->default(null);
            $table->text('descripcion_garantia')->nullable()->default(null);
            $table->string('estado_garantia', 45)->nullable()->default(null);
            $table->integer('mantenimiento')->unsigned();

            $table->index(["mantenimiento"], 'fk_garantia_mantenimiento1_idx');


            $table->foreign('mantenimiento', 'fk_garantia_mantenimiento1_idx')
                ->references('id_mantenimiento')->on('mantenimiento_equipo')
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
