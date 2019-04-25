<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'nodo';

    /**
     * Run the migrations.
     * @table nodo
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idnodo');
            $table->integer('centroformacion')->unsigned();
            $table->string('nombrenodo', 45);
            $table->string('direccion', 100)->nullable()->default(null);

            $table->index(["centroformacion"], 'fk_nodo_centroformacion1_idx');


            $table->foreign('centroformacion', 'fk_nodo_centroformacion1_idx')
                ->references('id')->on('centroformacion')
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
