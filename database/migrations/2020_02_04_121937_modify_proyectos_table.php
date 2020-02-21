<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyProyectosTable extends Migration
{
    public $tableName = 'proyectos';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            // Cambios de columnas existentes
            $table->unsignedInteger('sector_id')->nullable()->change();
            $table->unsignedInteger('estadoproyecto_id')->nullable()->change();
            $table->unsignedInteger('tipoarticulacionproyecto_id')->nullable()->change();
            $table->unsignedInteger('estadoprototipo_id')->nullable()->change();
            // Nuevos campos
            $table->string('alcance_proyecto', 1000)->nullable()->default(null)->after('universidad_proyecto');
            $table->string('tipo_economianaranja', 100)->nullable()->default(null)->after('economia_naranja');
            $table->tinyInteger('dirigido_discapacitados')->default('0')->after('observaciones_proyecto');
            $table->string('tipo_discapacitados', 100)->nullable()->default(null)->after('dirigido_discapacitados');
            $table->string('otro_areaconocimiento', 100)->nullable()->default(null)->after('otro_estadoprototipo');
            $table->tinyInteger('trl_esperado')->default('0')->after('alcance_proyecto');
            $table->tinyInteger('trl_obtenido')->nullable()->default('0')->after('trl_esperado');
            $table->unsignedInteger('fase_id')->nullable()->after('areaconocimiento_id');
            // Nuevas llaves
            $table->index(["fase_id"], 'fk_proyectos_fases1_idx');
            
            $table->foreign('fase_id', 'fk_proyectos_fases1_idx')
            ->references('id')->on('fases')
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
            $table->unsignedInteger('sector_id')->change();
            $table->unsignedInteger('estadoproyecto_id')->change();
            $table->unsignedInteger('tipoarticulacionproyecto_id')->change();
            $table->unsignedInteger('estadoprototipo_id')->change();

            $table->dropColumn(['alcance_proyecto', 'tipo_economianaranja', 'dirigido_discapacitados', 'tipo_discapacitados', 'otro_areaconocimiento', 'trl_esperado', 'trl_obtenido']);

            $table->dropIndex(['fase_id']);

            $table->dropColumn(['fase_id']);
        });
    }
}
