<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'mantenimiento';

    /**
     * Run the migrations.
     * @table mantenimiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idmantenimiento');
            $table->integer('laboratorio')->unsigned();
            $table->string('item', 200);
            $table->string('precio', 45);
            $table->string('vidautil', 45);
            $table->string('anoum', 45);
            $table->string('horasuso', 45);

            $table->index(["laboratorio"], 'fk_mantenimiento_laboratorio1_idx');


            $table->foreign('laboratorio', 'fk_mantenimiento_laboratorio1_idx')
                ->references('idlaboratorio')->on('laboratorio')
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
