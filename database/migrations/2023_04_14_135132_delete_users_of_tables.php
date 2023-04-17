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
        DB::beginTransaction();
        try {
            Schema::table('ideas', function (Blueprint $table) {
                DB::statement('ALTER TABLE ideas DROP FOREIGN KEY fk_ideas_gestores1_idx;');
                DB::statement('ALTER TABLE ideas DROP INDEX fk_ideas_gestores1_idx;');
                DB::statement('ALTER TABLE ideas DROP FOREIGN KEY fk_talentos_ideas1_idx;');
                DB::statement('ALTER TABLE ideas DROP INDEX fk_talentos_ideas1_idx;');
                $table->dropColumn(['gestor_id', 'talento_id', 'nombres_contacto', 'apellidos_contacto', 'correo_contacto', 'telefono_contacto']);
            });
            Schema::table('comite_gestor', function (Blueprint $table) {
                DB::statement('ALTER TABLE comite_gestor DROP FOREIGN KEY fk_comites_gestor1_idx;');
                DB::statement('ALTER TABLE comite_gestor DROP INDEX fk_comites_gestor1_idx;');
                $table->dropColumn(['gestor_id']);
            });
            Schema::table('proyectos', function (Blueprint $table) {
                DB::statement('ALTER TABLE proyectos DROP FOREIGN KEY proyectos_asesor_id_foreign;');
                DB::statement('ALTER TABLE proyectos DROP INDEX proyectos_asesor_id_foreign;');
                $table->dropColumn(['asesor_id']);
            });

            Schema::table('gestor_uso', function (Blueprint $table) {
                DB::statement('ALTER TABLE gestor_uso DROP FOREIGN KEY fk_gestor_uso_gestor1_idx;');
                DB::statement('ALTER TABLE gestor_uso DROP INDEX fk_gestor_uso_gestor1_idx;');
                DB::statement('ALTER TABLE gestor_uso DROP INDEX gestor_uso_asesorable_type_asesorable_id_index;');
                $table->dropColumn(['gestor_id', 'asesorable_type', 'asesorable_id']);
            });
            Schema::table('uso_talentos', function (Blueprint $table) {
                DB::statement('ALTER TABLE uso_talentos DROP FOREIGN KEY fk_uso_talentos_talentos1_idx;');
                DB::statement('ALTER TABLE uso_talentos DROP INDEX fk_uso_talentos_talentos1_idx;');
                $table->dropColumn(['talento_id']);
            });
            Schema::table('proyecto_talento', function (Blueprint $table) {
                DB::statement('ALTER TABLE proyecto_talento DROP FOREIGN KEY fk_proyecto_talentos1_idx;');
                DB::statement('ALTER TABLE proyecto_talento DROP INDEX fk_proyecto_talentos1_idx;');
                $table->dropColumn(['talento_id']);
            });
            Schema::table('usoinfraestructuras', function (Blueprint $table) {
                DB::statement('ALTER TABLE usoinfraestructuras DROP FOREIGN KEY fk_usoinfraestructura_actividad1_idx;');
                DB::statement('ALTER TABLE usoinfraestructuras DROP INDEX fk_usoinfraestructura_actividad1_idx;');
                $table->dropColumn(['actividad_id', 'tipo_usoinfraestructura']);
            });
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
