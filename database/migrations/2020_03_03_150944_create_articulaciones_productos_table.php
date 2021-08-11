<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionesProductosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'articulaciones_productos';
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
            $table->unsignedInteger('articulacion_id');
            $table->unsignedInteger('producto_id');
            $table->tinyInteger('logrado')->default('0');

            $table->index(["articulacion_id"], 'fk_articulacion_producto_articulacion1_idx');

            $table->index(["producto_id"], 'fk_articulacion_producto_producto1_idx');
            $table->nullableTimestamps();


            $table->foreign('articulacion_id', 'fk_articulacion_producto_articulacion1_idx')
                ->references('id')->on('articulaciones')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('producto_id', 'fk_articulacion_producto_producto1_idx')
                ->references('id')->on('productos')
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
