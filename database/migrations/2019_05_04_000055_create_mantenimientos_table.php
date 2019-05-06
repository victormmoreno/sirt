<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'mantenimientos';

    /**
     * Run the migrations.
     * @table mantenimientos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item');
            $table->string('precio', 45)->nullable();
            $table->string('vidautil', 45)->nullable();
            $table->string('anioum', 45)->nullable();
            $table->string('horasuso', 45)->nullable();
            $table->unsignedInteger('laboratorio_id');
            $table->timestamps();

            $table->index(["laboratorio_id"], 'fk_mantenimientos_laboratorios1_idx');

            $table->foreign('laboratorio_id', 'fk_mantenimientos_laboratorios1_idx')
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
