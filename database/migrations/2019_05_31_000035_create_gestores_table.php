<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestoresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'gestores';

    /**
     * Run the migrations.
     * @table gestores
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('lineatecnologica_id');
            $table->float('honorarios', 10, 0);
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_gestores_nodos1_idx');

            $table->index(["lineatecnologica_id"], 'fk_gestores_lineastecnologicas1_idx');

            $table->index(["user_id"], 'fk_gestor_user1_idx');


            $table->foreign('user_id', 'fk_gestor_user1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('nodo_id', 'fk_gestores_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('lineatecnologica_id', 'fk_gestores_lineastecnologicas1_idx')
                ->references('id')->on('lineastecnologicas')
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
