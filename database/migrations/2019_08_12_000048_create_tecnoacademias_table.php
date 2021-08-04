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
    protected $tableName = 'tecnoacademias';

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
            $table->unsignedInteger('regional_id');
            $table->unsignedInteger('entidad_id');
            $table->unsignedInteger('centro_id');

            $table->index(["entidad_id"], 'fk_tecnoacademias_entidad1_idx');

            $table->index(["centro_id"], 'fk_tecnoacademias_centro1_idx');

            $table->index(["regional_id"], 'fk_tecnoacademias_regional1_idx');
            $table->nullableTimestamps();


            $table->foreign('centro_id', 'fk_tecnoacademias_centro1_idx')
                ->references('id')->on('centros')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('entidad_id', 'fk_tecnoacademias_entidad1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('regional_id', 'fk_tecnoacademias_regional1_idx')
                ->references('id')->on('regionales')
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
