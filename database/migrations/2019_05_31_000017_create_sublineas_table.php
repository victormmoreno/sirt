<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSublineasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'sublineas';

    /**
     * Run the migrations.
     * @table sublineas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('lineatecnologica_id');
            $table->string('nombre', 45);
            $table->timestamps();

            $table->index(["lineatecnologica_id"], 'fk_sublineas_lineastecnologicas1_idx');

            $table->unique(["nombre"], 'nombre_UNIQUE');


            $table->foreign('lineatecnologica_id', 'fk_sublineas_lineastecnologicas1_idx')
                ->references('id')->on('lineastecnologicas')
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
