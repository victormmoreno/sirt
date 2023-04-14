<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->unsignedInteger('asesor_id')->nullable()->after('id');
            $table->foreign('asesor_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
            
            $table->unsignedInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::table('comite_gestor', function (Blueprint $table) {
            $table->unsignedInteger('evaluador_id')->nullable()->after('id');
            $table->foreign('evaluador_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::table('proyectos', function (Blueprint $table) {
            $table->unsignedInteger('experto_id')->nullable()->after('id');
            $table->foreign('experto_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
            
        });

        Schema::table('gestor_uso', function (Blueprint $table) {
            $table->unsignedInteger('asesor_id')->nullable()->after('id');
            $table->foreign('asesor_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::table('uso_talentos', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::table('proyecto_talento', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::table('user_nodo', function (Blueprint $table) {
            $table->unsignedInteger('linea_id')->nullable()->after('id');
            $table->foreign('linea_id')
            ->references('id')->on('lineastecnologicas')
            ->onDelete('no action')
            ->onUpdate('no action');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->longText('tipo_usuario')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropForeign(['asesor_id', 'user_id']);
        });
        Schema::table('comite_gestor', function (Blueprint $table) {
            $table->dropForeign(['evaluador_id']);
        });
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropForeign(['experto_id']);
        });
        Schema::table('gestor_uso', function (Blueprint $table) {
            $table->dropForeign(['asesor_id']);
        });
        Schema::table('uso_talentos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('proyecto_talento', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('user_nodo', function (Blueprint $table) {
            $table->dropForeign(['linea_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tipo_usuario']);
        });
    }
}
