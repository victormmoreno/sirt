<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMantenimientoEquipoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'mantenimiento_equipo';

    /**
     * Run the migrations.
     * @table mantenimiento_equipo
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_mantenimiento');
            $table->tinyInteger('encargado_mantenimiento')->nullable()->default(null);
            $table->integer('tipo_mantenimiento')->nullable()->default(null);
            $table->tinyInteger('periodicidad_mantenimiento')->nullable()->default(null);
            $table->integer('proveedor')->nullable()->default(null)->unsigned();
            $table->integer('id_equipo')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('periodicidad_uso')->nullable()->default(null);
            $table->text('observaciones')->nullable()->default(null);
            $table->string('manuales', 45)->nullable()->default(null);
            $table->string('nro_manual', 45)->nullable()->default(null);
            $table->date('fecha_estipulada')->nullable()->default(null);
            $table->date('fecha_prorroga')->nullable()->default(null);
            $table->text('componentes_criticos')->nullable()->default(null);
            $table->text('caracteristicas_comp')->nullable()->default(null);
            $table->tinyInteger('estado_mantenimiento')->nullable()->default('1');

            $table->index(["user_id"], 'mante_persona');

            $table->index(["id_equipo"], 'fk_mantenimiento_equipo1_idx');

            $table->index(["proveedor"], 'mante_proveedor');


            $table->foreign('id_equipo', 'fk_mantenimiento_equipo1_idx')
                ->references('id_equipo')->on('equipo');
                

            $table->foreign('user_id', 'mante_persona')
                ->references('id')->on('users');
               

            $table->foreign('proveedor', 'mante_proveedor')
                ->references('id_proveedores')->on('proveedores');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
