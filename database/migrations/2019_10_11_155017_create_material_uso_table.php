<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialUsoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'material_uso';
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
            $table->unsignedBigInteger('usoinfraestructura_id');
            $table->unsignedInteger('material_id');
            $table->float('costo_material', 30, 2)->default(0);
            $table->float('unidad')->default(0);
            $table->timestamps();

            $table->index(["usoinfraestructura_id"], 'fk_usoinfraestructura_material_uso1_idx');
            $table->index(["material_id"], 'fk_material_material_uso1_idx');

            $table->foreign('usoinfraestructura_id', 'fk_usoinfraestructura_material_uso1_idx')
                ->references('id')->on('usoinfraestructuras')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('material_id', 'fk_material_material_uso1_idx')
                ->references('id')->on('materiales')
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
