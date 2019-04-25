<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVigilanciaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'vigilancia';

    /**
     * Run the migrations.
     * @table vigilancia
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idvigilancia');
            $table->integer('proyecto')->unsigned();
            $table->date('fechainicio')->nullable()->default(null);
            $table->date('fechafin')->nullable()->default(null);
            $table->integer('horas')->nullable()->default(null);
            $table->string('observaciones', 200)->nullable()->default(null);

            $table->index(["proyecto"], 'fk_vigilancia_proyecto1_idx');


            $table->foreign('proyecto', 'fk_vigilancia_proyecto1_idx')
                ->references('idproyecto')->on('proyecto')
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
