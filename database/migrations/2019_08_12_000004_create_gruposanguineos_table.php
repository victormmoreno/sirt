<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposanguineosTable extends Migration
{
    /**
     * the attribute that names the table.
     *
     * @var string
     */
    protected $tableName = 'gruposanguineos';

    /**
     * Run the migrations.
     * @table gruposanguineos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 3);

            $table->unique(["nombre"], 'gruposanguineos_nombre_unique');
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
