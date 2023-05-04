<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosTable extends Migration
{
    public $tableName = 'contratos';
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
            $table->unsignedBigInteger('user_nodo_id')->nullable();
            $table->unsignedInteger('nodo_id')->nullable();
            $table->string('codigo', 45);
            $table->date('fecha_inicio');
            $table->date('fecha_finalizacion')->nullable();
            $table->double('valor_contrato', 10, 2)->nullable();
            $table->tinyInteger('vinculacion')->default('0');
            $table->double('honorarios', 9, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_nodo_id')
            ->references('id')->on('user_nodo')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('nodo_id')
            ->references('id')->on('nodos')
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
