<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFocoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'foco';

    /**
     * Run the migrations.
     * @table foco
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idfoco');
            $table->string('nombre', 100)->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->integer('linea')->unsigned();

            $table->index(["linea"], 'fk_foco_linea1_idx');


            $table->foreign('linea', 'fk_foco_linea1_idx')
                ->references('idlinea')->on('linea')
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
