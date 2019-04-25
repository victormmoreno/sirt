<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestorTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'gestor';

    /**
     * Run the migrations.
     * @table gestor
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idgestor');
            $table->integer('user_id')->unsigned();
            $table->integer('linea')->unsigned();
            $table->decimal('salario', 10, 0)->nullable()->default(null);

            $table->index(["linea"], 'fk_gestor_linea1_idx');

            $table->index(["user_id"], 'fk_gestor_user_id1_idx');


            $table->foreign('linea', 'fk_gestor_linea1_idx')
                ->references('idlinea')->on('linea');
                

            $table->foreign('user_id', 'fk_gestor_user_id1_idx')
                ->references('id')->on('users');
                
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
