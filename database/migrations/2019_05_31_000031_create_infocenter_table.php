<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfocenterTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'infocenter';

    /**
     * Run the migrations.
     * @table infocenter
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('user_id');
            $table->string('extension',7);
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_infocenter_nodos1_idx');

            $table->index(["user_id"], 'fk_infocenter_user1_idx');


            $table->foreign('nodo_id', 'fk_infocenter_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_infocenter_user1_idx')
                ->references('id')->on('users')
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
