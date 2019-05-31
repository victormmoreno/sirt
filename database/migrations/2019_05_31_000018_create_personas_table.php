<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'personas';

    /**
     * Run the migrations.
     * @table personas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('tipodocumento_id');
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('documento', 45);
            $table->string('celular', 11)->nullable();
            $table->timestamps();
            $table->index(["tipodocumento_id"], 'fk_personas_tiposdocumentos1_idx');

            $table->unique(["documento"], 'documento_UNIQUE');


            $table->foreign('tipodocumento_id', 'fk_personas_tiposdocumentos1_idx')
                ->references('id')->on('tiposdocumentos')
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
