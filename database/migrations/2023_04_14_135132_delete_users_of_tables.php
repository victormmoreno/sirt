<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteUsersOfTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ideas', function (Blueprint $table) {
            $table->dropColumn(['gestor_id', 'talento_id', 'nombres_contacto', 'apellidos_contacto', 'correo_contacto', 'telefono_contacto']);
        });
        Schema::table('comite_gestor', function (Blueprint $table) {
            $table->dropColumn(['gestor_id']);
        });
        Schema::table('proyectos', function (Blueprint $table) {
            $table->dropColumn(['asesor_id']);
        });

        Schema::table('gestor_uso', function (Blueprint $table) {
            $table->dropColumn(['gestor_id', 'asesorable_type', 'asesorable_id']);
        });
        Schema::table('uso_talentos', function (Blueprint $table) {
            $table->dropColumn(['talento_id']);
        });
        Schema::table('proyecto_talento', function (Blueprint $table) {
            $table->dropColumn(['talento_id']);
        });
        Schema::table('usoinfraestructuras', function (Blueprint $table) {
            $table->dropColumn(['actividad_id', 'tipo_usoinfraestructura']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
