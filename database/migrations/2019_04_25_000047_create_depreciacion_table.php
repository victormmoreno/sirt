<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepreciacionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'depreciacion';

    /**
     * Run the migrations.
     * @table depreciacion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('iddepreciacion');
            $table->integer('laboratorio')->unsigned();
            $table->string('equipo', 45);
            $table->string('marca', 45);
            $table->string('referencia', 45);
            $table->string('costo', 45);
            $table->string('vidautil', 45);
            $table->integer('ano')->nullable()->default(null);
            $table->string('horauso', 45);

            $table->index(["laboratorio"], 'fk_depreciacion_laboratorio1_idx');


            $table->foreign('laboratorio', 'fk_depreciacion_laboratorio1_idx')
                ->references('idlaboratorio')->on('laboratorio');
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
