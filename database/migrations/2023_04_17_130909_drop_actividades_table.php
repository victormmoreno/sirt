<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('articulacion_proyecto_talento');
        Schema::table('movimientos_actividades_users_roles', function (Blueprint $table) {
            DB::statement('ALTER TABLE movimientos_actividades_users_roles DROP FOREIGN KEY fk_movimientos_actividades1_idx;');
            DB::statement('ALTER TABLE movimientos_actividades_users_roles DROP INDEX fk_movimientos_actividades1_idx;');
            $table->dropColumn(['actividad_id']);
        });
        Schema::dropIfExists('criterios_calidad');
        Schema::dropIfExists('criterios_cumplimiento');
        Schema::dropIfExists('evaluaciones');
        Schema::dropIfExists('archivos_articulacion_proyecto');
        Schema::table('proyectos', function (Blueprint $table) {
            DB::statement('ALTER TABLE proyectos DROP FOREIGN KEY fk_proyectos_articulacion_proyecto1_idx;');
            DB::statement('ALTER TABLE proyectos DROP INDEX fk_proyectos_articulacion_proyecto1_idx;');
            $table->dropColumn(['articulacion_proyecto_id']);
        });
        Schema::table('articulaciones', function (Blueprint $table) {
            DB::statement('ALTER TABLE articulaciones DROP FOREIGN KEY fk_articulaciones_articulacion_proyecto1_idx;');
            DB::statement('ALTER TABLE articulaciones DROP INDEX fk_articulaciones_articulacion_proyecto1_idx;');
            $table->dropColumn(['articulacion_proyecto_id']);
        });
        Schema::table('edts', function (Blueprint $table) {
            DB::statement('ALTER TABLE edts DROP FOREIGN KEY fk_edts_actividades1_idx;');
            DB::statement('ALTER TABLE edts DROP INDEX fk_edts_actividades1_idx;');
            $table->dropColumn(['actividad_id']);
        });
        Schema::table('objetivos_especificos', function (Blueprint $table) {
            DB::statement('ALTER TABLE objetivos_especificos DROP FOREIGN KEY fk_objetivos_especificos_actividades1_idx;');
            DB::statement('ALTER TABLE objetivos_especificos DROP INDEX fk_objetivos_especificos_actividades1_idx;');
            $table->dropColumn(['actividad_id']);
        });
        Schema::dropIfExists('articulacion_proyecto');
        Schema::dropIfExists('actividades');
        Schema::dropIfExists('gestores');
        DB::statement('DELETE FROM movimientos_actividades_users_roles WHERE proyecto_id IS NULL;');
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
