<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivoscharlasinformativasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'archivoscharlasinformativas';

    /**
     * Run the migrations.
     * @table archivoscharlasinformativas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('charlainformativa_id');
            $table->string('ruta');

            $table->index(["charlainformativa_id"], 'fk_archivoscharlasinformativas_charlasinformativas1_idx');

            $table->unique(["ruta"], 'ruta_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('charlainformativa_id', 'fk_archivoscharlasinformativas_charlasinformativas1_idx')
                ->references('id')->on('charlasinformativas')
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
