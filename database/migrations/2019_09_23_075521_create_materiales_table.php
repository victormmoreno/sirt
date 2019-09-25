<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialesTable extends Migration
{

    public $tableName = 'materiales';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('tipomaterial_id');
            $table->unsignedBigInteger('laboratorio_id');
            $table->string('cantidad',10);
            $table->string('item',600);
            $table->string('anho_compra',600);
            $table->string('horas_uso',45);
            $table->string('precio_unitario',45);
            $table->tinyInteger('estado')->default('1');
            $table->timestamps();

            $table->index(["tipomaterial_id"], 'fk_material_tipomaterial1_idx');
            $table->index(["laboratorio_id"], 'fk_material_laboratorio1_idx');

            $table->foreign('tipomaterial_id', 'fk_material_tipomaterial1_idx')
                ->references('id')->on('tipos_materiales')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('laboratorio_id', 'fk_material_laboratorio1_idx')
                ->references('id')->on('laboratorios')
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
