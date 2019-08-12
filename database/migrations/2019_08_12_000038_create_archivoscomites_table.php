<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivoscomitesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'archivoscomites';

    /**
     * Run the migrations.
     * @table archivoscomites
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('comite_id');
            $table->string('ruta');

            $table->index(["comite_id"], 'fk_archivoscomites_comites1_idx');

            $table->unique(["ruta"], 'ruta_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('comite_id', 'fk_archivoscomites_comites1_idx')
                ->references('id')->on('comites')
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
