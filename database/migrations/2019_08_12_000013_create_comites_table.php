<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComitesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comites';

    /**
     * Run the migrations.
     * @table comites
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigo', 20);
            $table->date('fechacomite');
            $table->string('observaciones',1000)->nullable()->default(null);
            $table->tinyInteger('correos')->nullable()->default('0');
            $table->tinyInteger('listado_asistencia')->nullable()->default('0');
            $table->tinyInteger('otros')->nullable()->default('0');
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
