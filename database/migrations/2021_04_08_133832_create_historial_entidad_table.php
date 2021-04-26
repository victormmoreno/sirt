<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialEntidadTable extends Migration
{
    public $tableName = 'historial_entidad';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->integer('model_id')->unsigned();
            $table->string('model_type');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('movimiento_id');
            $table->unsignedInteger('role_id');
            $table->string('comentarios', 2100)->nullable();
            $table->string('descripcion', 200)->nullable();
            $table->timestamps();

            $table->index(["user_id"], 'fk_historial_entidad_users1_idx');
            $table->index(["movimiento_id"], 'fk_historial_entidad_movimientos1_idx');
            $table->index(["role_id"], 'fk_historial_entidad_roles1_idx');

            $table->foreign('user_id', 'fk_historial_entidad_users1_idx')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('movimiento_id', 'fk_historial_entidad_movimientos1_idx')
            ->references('id')->on('movimientos')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('role_id', 'fk_historial_entidad_roles1_idx')
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
