<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkdriveTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'linkdrive';

    /**
     * Run the migrations.
     * @table linkdrive
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idlinkdrive');
            $table->string('link', 200);
            $table->smallInteger('anho');
            $table->integer('idnodo')->unsigned();

            $table->index(["idnodo"], 'fk_linkdrive_nodo1_idx');


            $table->foreign('idnodo', 'fk_linkdrive_nodo1_idx')
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
