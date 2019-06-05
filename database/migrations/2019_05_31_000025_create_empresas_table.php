<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'empresas';

    /**
     * Run the migrations.
     * @table empresas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('entidad_id');
            $table->unsignedInteger('sector_id');
            $table->unsignedInteger('ciudad_id');
            $table->string('nit', 45);
            $table->string('direccion', 45);
            $table->string('nombre_contacto', 45)->nullable();
            $table->string('telefono_contacto', 45)->nullable();
            $table->timestamps();
            $table->index(["entidad_id"], 'fk_empresa_entidad1_idx');

            $table->index(["sector_id"], 'fk_empresas_sectores1_idx');


            $table->index(["ciudad_id"], 'fk_empresa_ciudad1_idx');

            $table->unique(["nit"], 'nit_UNIQUE');


            $table->foreign('entidad_id', 'fk_empresa_entidad1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sector_id', 'fk_empresas_sectores1_idx')
                ->references('id')->on('sectores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ciudad_id', 'fk_empresa_ciudad1_idx')
                ->references('id')->on('ciudades')
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
       Schema::dropIfExists($this->tableName);
     }
}
