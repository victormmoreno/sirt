<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ciudad';

    /**
     * Run the migrations.
     * @table ciudad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idciudad');
            $table->string('nombre', 45);
            $table->integer('departamento')->unsigned();

            $table->index(["departamento"], 'fk_ciudad_departamento1_idx');


            $table->foreign('departamento', 'fk_ciudad_departamento1_idx')
                ->references('iddepartamento')->on('departamento');
                // ->onDelete('no action')
                // ->onUpdate('no action');
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
