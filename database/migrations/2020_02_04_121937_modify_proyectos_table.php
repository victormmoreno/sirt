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
            // Nuevos campos
            $table->string('tipo_economianaranja', 100)->nullable()->default(null)->after('economia_naranja');
            $table->unsignedInteger('fase_id')->nullable()->after('areaconocimiento_id');
            $table->string('otro_areaconocimiento', 100)->nullable()->default(null)->after('fase_id');
            $table->string('alcance_proyecto', 1000)->nullable()->default(null)->after('otro_areaconocimiento');
            $table->tinyInteger('trl_esperado')->nullable()->default('0')->after('alcance_proyecto');
            $table->tinyInteger('trl_obtenido')->nullable()->default('0')->after('trl_esperado');
            $table->tinyInteger('dirigido_discapacitados')->default('0')->after('trl_obtenido');
            $table->string('tipo_discapacitados', 100)->nullable()->default(null)->after('dirigido_discapacitados');
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
            $table->dropColumn(['alcance_proyecto', 'tipo_economianaranja', 'dirigido_discapacitados', 'tipo_discapacitados', 'otro_areaconocimiento', 'trl_esperado', 'trl_obtenido']);

            $table->dropIndex(['fase_id']);

            $table->dropColumn(['fase_id']);
        });
    }
}
