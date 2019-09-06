<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineastecnologicasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'lineastecnologicas';

    /**
     * Run the migrations.
     * @table lineastecnologicas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 45)->unique();
            $table->string('abreviatura', 5);
            $table->string('descripcion',1000)->nullable()->default(null);

            $table->unique(["abreviatura"], 'abreviatura_UNIQUE');

            $table->unique(["nombre"], 'nombre_UNIQUE');
            $table->nullableTimestamps();
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
