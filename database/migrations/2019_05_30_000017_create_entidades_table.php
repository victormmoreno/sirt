<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntidadesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'entidades';

    /**
     * Run the migrations.
     * @table entidades
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ciudad_id')->unsigned();
            $table->string('nombre', 45);
            $table->string('direccion', 100)->nullable();
            $table->string('contacto', 45)->nullable();
            $table->unique(["nombre"], 'nombre_UNIQUE');
            $table->timestamps();

            $table->index(["ciudad_id"], 'fk_entidad_ciudad1_idx');


            $table->foreign('ciudad_id', 'fk_entidad_ciudad1_idx')
                ->references('id')->on('ciudades')
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
