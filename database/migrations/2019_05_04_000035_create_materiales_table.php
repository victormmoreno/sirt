<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'materiales';

    /**
     * Run the migrations.
     * @table materiales
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cantidad');
            $table->string('item');
            $table->smallInteger('anio_compra');
            $table->integer('horasuso')->nullable();
            $table->string('precio_unitario', 45)->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->integer('tipomaterial_id')->unsigned();
            $table->timestamps();

            $table->index(["tipomaterial_id"], 'fk_materiales_tiposmateriales1_idx');

            $table->foreign('tipomaterial_id', 'fk_materiales_tiposmateriales1_idx')
                ->references('id')->on('tiposmateriales')
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
