<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionalesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'regionales';

    /**
     * Run the migrations.
     * @table regionales
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('ciudad_id');
            $table->string('nombre', 45);
            $table->string('codigo_regional', 11);
            $table->string('direccion', 200)->nullable()->default(null);
            $table->integer('telefono')->nullable()->default(null);

            $table->index(["ciudad_id"], 'fk_regionales_ciudad1_idx');

            $table->unique(["codigo_regional"], 'codigo_regional_UNIQUE');

            $table->unique(["nombre"], 'nombre_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('ciudad_id', 'fk_regionales_ciudad1_idx')
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
