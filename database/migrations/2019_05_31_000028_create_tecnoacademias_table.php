<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTecnoacademiasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'tecnoacademias';

    /**
     * Run the migrations.
     * @table tecnoacademias
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('regionales_id');
            $table->unsignedInteger('entidades_id');
            $table->unsignedInteger('centro_id');
            $table->timestamps();

            $table->index(["entidades_id"], 'fk_tecnoacademias_entidades1_idx');

            $table->index(["regionales_id"], 'fk_tecnoacademias_regionales1_idx');

            $table->index(["centro_id"], 'fk_tecnoacademias_centros1_idx');


            $table->foreign('regionales_id', 'fk_tecnoacademias_regionales1_idx')
                ->references('id')->on('regionales')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('entidades_id', 'fk_tecnoacademias_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('centro_id', 'fk_tecnoacademias_centros1_idx')
                ->references('id')->on('centros')
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
