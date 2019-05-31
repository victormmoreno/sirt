<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentrosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'centros';

    /**
     * Run the migrations.
     * @table centros
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('regional_id');
            $table->unsignedInteger('entidad_id');
            $table->string('codigo_centro', 45);
            $table->string('descripcion', 200)->nullable();
            $table->timestamps();
            $table->index(["entidad_id"], 'fk_centro_entidad1_idx');

            $table->index(["regional_id"], 'fk_centro_regional1_idx');


            $table->foreign('regional_id', 'fk_centro_regional1_idx')
                ->references('id')->on('regionales')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('entidad_id', 'fk_centro_entidad1_idx')
                ->references('id')->on('entidades')
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
