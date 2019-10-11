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
            $table->increments('id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('lineatecnologica_id');
            $table->unsignedInteger('categoria_material_id');
            $table->unsignedInteger('presentacion_id');
            $table->unsignedInteger('medida_id');
            $table->string('codigo_material', 20)->unique();
            $table->string('nombre', 200);
            $table->float('cantidad');
            $table->float('valor_compra');
            $table->string('proveedor',100);
            $table->string('marca',45);
            $table->timestamps();


            $table->index(["nodo_id"], 'fk_nodo_materiales1_idx');
            $table->index(["lineatecnologica_id"], 'fk_lineatecnologica_materiales1_idx');
            $table->index(["categoria_material_id"], 'fk_categoria_material_materiales1_idx');
            $table->index(["presentacion_id"], 'fk_presentacion_materiales1_idx');
            $table->index(["medida_id"], 'fk_medida_materiales1_idx');

            $table->foreign('nodo_id', 'fk_nodo_materiales1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('lineatecnologica_id', 'fk_lineatecnologica_materiales1_idx')
                ->references('id')->on('lineastecnologicas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('categoria_material_id', 'fk_categoria_material_materiales1_idx')
                ->references('id')->on('categoria_material')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('presentacion_id', 'fk_presentacion_materiales1_idx')
                ->references('id')->on('presentaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('medida_id', 'fk_medida_materiales1_idx')
                ->references('id')->on('medidas')
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
