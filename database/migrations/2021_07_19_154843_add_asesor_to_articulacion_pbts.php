<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAsesorToArticulacionPbts extends Migration
{
    /**
     * the attribute that names the table.
     *
     * @var string
     */
    protected $tableName = 'articulacion_pbts';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('asesor_id')->nullable()->after('actividad_id');
            $table->unsignedInteger('nodo_id')->nullable()->after('asesor_id');
            $table->integer('articulable_id')->nullable()->unsigned()->after('alcance_articulacion_id');
            $table->string('articulable_type')->nullable()->after('articulable_id');
            $table->string('codigo', 20)->unique()->nullable()->after('articulable_type');
            $table->string('nombre', 500)->after('codigo');
            $table->date('fecha_inicio')->nullable()->after('nombre');
            $table->date('fecha_cierre')->nullable()->after('fecha_inicio');
            $table->tinyInteger('aprobacion_dinamizador')->default(0)->after('fecha_cierre');
            $table->tinyInteger('formulario_inicio')->default(0)->after('aprobacion_dinamizador');
            $table->tinyInteger('seguimiento')->default(0)->after('formulario_inicio');

            $table->foreign('asesor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('nodo_id')->references('id')->on('nodos')->onDelete('set null');
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
            $table->dropColumn([
                'asesor_id',
                'nodo_id',
                'articulable_id',
                'articulable_type',
                'codigo',
                'nombre',
                'fecha_inicio',
                'fecha_cierre',
                'aprobacion_dinamizador',
                'formulario_inicio',
                'seguimiento',
            ]);
        });
    }
}
