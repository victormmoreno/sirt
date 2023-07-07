<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterArticulacionesAddCamposActividadesTable extends Migration
{
    public $tableName = 'articulaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('codigo_articulacion', 20)->after('fase_id');
            $table->string('nombre', 500)->after('codigo_articulacion');
            $table->date('fecha_inicio')->nullable()->after('nombre');
            $table->date('fecha_cierre')->nullable()->after('fecha_inicio');
            $table->string('objetivo_general', 500)->nullable()->after('fecha_cierre');
            $table->string('conclusiones', 1000)->nullable()->after('objetivo_general');
            $table->tinyInteger('formulario_inicio')->default(0)->after('conclusiones');
            $table->tinyInteger('cronograma')->default(0)->after('formulario_inicio');
            $table->tinyInteger('seguimiento')->default(0)->after('cronograma');
            $table->tinyInteger('formulario_final')->default(0)->after('seguimiento');
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
            $table->dropColumn(['codigo_actividad']);
            $table->dropColumn(['nombre']);
            $table->dropColumn(['fecha_inicio']);
            $table->dropColumn(['fecha_cierre']);
            $table->dropColumn(['objetivo_general']);
            $table->dropColumn(['conclusiones']);
            $table->dropColumn(['formulario_inicio']);
            $table->dropColumn(['cronograma']);
            $table->dropColumn(['seguimiento']);
            $table->dropColumn(['formulario_final']);
        });
    }
}
