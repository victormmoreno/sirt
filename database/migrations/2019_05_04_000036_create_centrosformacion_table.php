<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentrosformacionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'centrosformacion';

    /**
     * Run the migrations.
     * @table centrosformacion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 45);
            $table->text('direccion')->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedInteger('ciudad_id');
            $table->unsignedInteger('regional_id');

            $table->index(["regional_id"], 'fk_centrosformacion_regionales1_idx');

            $table->index(["ciudad_id"], 'fk_centrosformacion_ciudades1_idx');

            $table->foreign('ciudad_id', 'fk_centrosformacion_ciudades1_idx')
                ->references('id')->on('ciudades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('regional_id', 'fk_centrosformacion_regionales1_idx')
                ->references('id')->on('regionales')
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
