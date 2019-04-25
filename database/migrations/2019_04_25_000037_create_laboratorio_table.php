<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratorioTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'laboratorio';

    /**
     * Run the migrations.
     * @table laboratorio
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idlaboratorio');
            $table->integer('linea')->unsigned();
            $table->integer('idnodo')->unsigned();
            $table->string('nombre', 45)->nullable()->default(null);
            $table->string('participacioncostos', 20);
            $table->tinyInteger('estado')->nullable()->default('1');

            $table->index(["linea"], 'fk_laboratorio_linea1_idx');

            $table->index(["idnodo"], 'fk_laboratorio_nodo1_idx');


            $table->foreign('linea', 'fk_laboratorio_linea1_idx')
                ->references('idlinea')->on('linea')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idnodo', 'fk_laboratorio_nodo1_idx')
                ->references('idnodo')->on('nodo')
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
