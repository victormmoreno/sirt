<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmpresasTableVersion2 extends Migration
{
    public $tableName = 'empresas';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            // Nuevos campos
            $table->unsignedInteger('user_id')->nullable()->after('tamanhoempresa_id');
            $table->string('nombre', 300)->nullable()->after('user_id');
            $table->string('email', 200)->nullable()->after('nombre');
            $table->string('direccion', 100)->nullable()->change();

            // Nuevas llaves
            $table->index(["user_id"], 'fk_empresas_user1_idx');

            $table->foreign('user_id', 'fk_empresas_user1_idx')
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
            $table->dropColumn(['user_id', 'nombre', 'email']);
        });
    }
}
