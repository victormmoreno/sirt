<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosActividadesUsersRolesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'movimientos_actividades_users_roles';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('actividad_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('movimiento_id');
            $table->unsignedInteger('fase_id');
            $table->unsignedInteger('role_id');
            $table->timestamps();

            $table->index(["actividad_id"], 'fk_movimientos_actividades1_idx');
            $table->index(["user_id"], 'fk_movimientos_users1_idx');
            $table->index(["movimiento_id"], 'fk_movimientos_movimientos1_idx');
            $table->index(["fase_id"], 'fk_movimientos_fases1_idx');
            $table->index(["role_id"], 'fk_movimientos_roles1_idx');

            $table->foreign('actividad_id', 'fk_movimientos_actividades1_idx')
            ->references('id')->on('actividades')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('user_id', 'fk_movimientos_users1_idx')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('movimiento_id', 'fk_movimientos_movimientos1_idx')
            ->references('id')->on('movimientos')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('fase_id', 'fk_movimientos_fases1_idx')
            ->references('id')->on('fases')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('role_id', 'fk_movimientos_roles1_idx')
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
        Schema::dropIfExists($this->tableName);
    }
}
