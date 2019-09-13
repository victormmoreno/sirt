<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAprobacionesTable extends Migration
{

    public $tableName = 'aprobaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('proyecto_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->tinyInteger('aprobacion');
            $table->timestamps();

            $table->index(["proyecto_id"], 'fk_aprobaciones_proyectos1_idx');

            $table->index(["user_id"], 'fk_aprobaciones_users1_idx');

            $table->index(["role_id"], 'fk_aprobaciones_roles1_idx');

            $table->foreign('proyecto_id', 'fk_aprobaciones_proyectos1_idx')
                ->references('id')->on('proyectos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_aprobaciones_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('role_id', 'fk_aprobaciones_roles1_idx')
                ->references('id')->on('roles')
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
        Schema::dropIfExists('aprobaciones');
    }
}
