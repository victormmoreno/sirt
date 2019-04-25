<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComiteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comite';

    /**
     * Run the migrations.
     * @table comite
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idcomite');
            $table->integer('idnodo')->unsigned();
            $table->date('fechacomite');
            $table->string('observacioncomite')->nullable()->default(null);

            $table->index(["idnodo"], 'fk_comite_nodo1_idx');


            $table->foreign('idnodo', 'fk_comite_nodo1_idx')
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
