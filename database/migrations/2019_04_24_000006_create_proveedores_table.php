<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proveedores';

    /**
     * Run the migrations.
     * @table proveedores
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id_proveedores');
            $table->string('nombre_proveedor', 45)->nullable()->default(null);
            $table->string('nit_empresa', 45)->nullable()->default(null);
            $table->text('direccion')->nullable()->default(null);
            $table->string('telefono_proveedor', 45)->nullable()->default(null);
            $table->string('correo_proveedor', 50)->nullable()->default(null);
            $table->integer('estado_proveedor')->nullable()->default(null);
            $table->text('objeto_empresa')->nullable()->default(null);
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
