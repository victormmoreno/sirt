<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFocosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'focos';

    /**
     * Run the migrations.
     * @table focos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 45);
            $table->text('descripcion')->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->integer('linea_id')->unsigned();
            $table->timestamps();

            $table->index(["linea_id"], 'fk_sublineas_lineas1_idx');

            $table->unique(["nombre"], 'nombre_UNIQUE');

            $table->foreign('linea_id', 'fk_sublineas_lineas1_idx')
                ->references('id')->on('lineas')
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
