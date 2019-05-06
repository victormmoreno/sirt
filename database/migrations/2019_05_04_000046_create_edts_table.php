<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdtsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'edts';

    /**
     * Run the migrations.
     * @table edts
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('fecha')->nullable();
            $table->string('nombre', 100)->nullable();
            $table->string('empresa', 100)->nullable();
            $table->string('contacto', 45)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->string('observaciones', 45)->nullable()->default('0');
            $table->string('empleados', 45)->nullable()->default('0');
            $table->string('instructores', 45)->nullable()->default('0');
            $table->string('aprendices', 45)->nullable()->default('0');
            $table->string('publico', 45)->nullable()->default('0');
            $table->integer('gestor_id')->unsigned();
            $table->timestamps();

            $table->index(["gestor_id"], 'fk_edts_gestores1_idx');

            $table->foreign('gestor_id', 'fk_edts_gestores1_idx')
                ->references('id')->on('gestores')
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
