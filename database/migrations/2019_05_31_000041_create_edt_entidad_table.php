<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdtEntidadTable extends Migration
{

    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'edt_entidad';
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
            $table->unsignedInteger('entidad_id');
            $table->unsignedInteger('edt_id');
            $table->timestamps();

            $table->index(["entidad_id"], 'fk_edt_entidad_entidades1_idx');

            $table->index(["edt_id"], 'fk_edt_entidad_edts1_idx');

            $table->foreign('entidad_id', 'fk_edt_entidad_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('edt_id', 'fk_edt_entidad_edts1_idx')
                ->references('id')->on('edts')
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
        Schema::dropIfExists('edt_entidad');
    }
}
