<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichastecnicasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'fichastecnicas';

    /**
     * Run the migrations.
     * @table fichastecnicas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 100)->nullable();
            $table->string('nro_inventario', 45)->nullable();
            $table->string('voltaje', 100)->nullable();
            $table->string('potencia', 100)->nullable();
            $table->date('fecha_adquision')->nullable();
            $table->date('fecha_instalacion')->nullable();
            $table->string('costo', 100)->nullable();
            $table->string('garantia', 100)->nullable();
            $table->string('monitor', 100)->nullable();
            $table->string('ram', 100)->nullable();
            $table->string('disco_duro', 100)->nullable();
            $table->string('impresora', 100)->nullable();
            $table->string('mouse', 100)->nullable();
            $table->string('teclado', 100)->nullable();
            $table->string('sis_operativo', 100)->nullable();
            $table->string('fichastecnicascol', 100)->nullable();
            $table->string('alto', 100)->nullable();
            $table->string('ancho', 100)->nullable();
            $table->string('largo', 100)->nullable();
            $table->string('sede', 100)->nullable();
            $table->string('edificio', 100)->nullable();
            $table->string('usuario', 100)->nullable();
            $table->string('fichastecnicascol1', 45)->nullable();
            $table->integer('telefono')->nullable();
            $table->integer('extension')->nullable();
            $table->text('programas_instalados')->nullable();
            $table->timestamps();
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
