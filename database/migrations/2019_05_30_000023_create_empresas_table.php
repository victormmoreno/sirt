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
            $table->integer('entidad_id')->unsigned();
            $table->integer('sectorempresa_id')->unsigned();
            $table->string('nombre_contacto', 45)->nullable();
            $table->string('telefono_contacto', 45)->nullable();
            $table->string('nit', 45)->nullable();
            $table->unique(["nit"], 'nit_UNIQUE');
            $table->timestamps();

            $table->index(["sectorempresa_id"], 'fk_empresas_sectoresempresas1_idx');

            $table->index(["entidad_id"], 'fk_empresa_entidad1_idx');


            $table->foreign('entidad_id', 'fk_empresa_entidad1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sectorempresa_id', 'fk_empresas_sectoresempresas1_idx')
                ->references('id')->on('sectoresempresas')
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
