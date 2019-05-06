<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'contratos';

    /**
     * Run the migrations.
     * @table contratos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('numero_contrato', 45);
            $table->date('fecha_contrato')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->integer('costo')->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->unsignedInteger('mantenimiento_id');
            $table->unsignedInteger('proveedor_id');
            $table->timestamps();

            $table->index(["proveedor_id"], 'fk_contratos_proveedores1_idx');

            $table->index(["mantenimiento_id"], 'fk_contratos_mantenimientos1_idx');

            $table->foreign('mantenimiento_id', 'fk_contratos_mantenimientos1_idx')
                ->references('id')->on('mantenimientos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('proveedor_id', 'fk_contratos_proveedores1_idx')
                ->references('id')->on('proveedores')
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
