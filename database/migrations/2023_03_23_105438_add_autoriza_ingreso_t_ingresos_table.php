<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutorizaIngresoTIngresosTable extends Migration
{
    public $tableName = 'ingresos_visitantes';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('quien_autoriza', 200)->nullable()->default(null)->after('hora_salida');
            $table->unsignedInteger('user_id')->nullable()->after('id');
            $table->index(["user_id"], 'fk_ingresos_visitantes_users1_idx');
            $table->foreign('user_id', 'fk_ingresos_visitantes_users1_idx')
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
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['quien_autoriza']);
            $table->dropColumn(['user_id']);
        });
    }
}
