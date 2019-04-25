<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'material';

    /**
     * Run the migrations.
     * @table material
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idmaterial');
            $table->integer('tipomaterial')->unsigned();
            $table->integer('laboratorio')->unsigned();
            $table->string('cantidad', 45);
            $table->string('item');
            $table->string('anoc', 45);
            $table->string('horasuso', 45);
            $table->string('preciouni', 45);
            $table->tinyInteger('estado')->default('1');

            $table->index(["laboratorio"], 'fk_material_laboratorio1_idx');

            $table->index(["tipomaterial"], 'fk_material_tipomaterial1_idx');


            $table->foreign('laboratorio', 'fk_material_laboratorio1_idx')
                ->references('idlaboratorio')->on('laboratorio')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipomaterial', 'fk_material_tipomaterial1_idx')
                ->references('idtipomaterial')->on('tipomaterial')
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
