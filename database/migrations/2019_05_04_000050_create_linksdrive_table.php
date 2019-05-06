<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksdriveTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'linksdrive';

    /**
     * Run the migrations.
     * @table linksdrive
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('link');
            $table->smallInteger('anio');
            $table->unsignedInteger('nodo_id');
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_linksdrive_nodos1_idx');

            $table->unique(["link"], 'link_UNIQUE');

            $table->foreign('nodo_id', 'fk_linksdrive_nodos1_idx')
                ->references('id')->on('nodos')
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
