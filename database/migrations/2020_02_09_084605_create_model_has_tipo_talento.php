<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelHasTipoTalento extends Migration
{

    public $tableName = 'model_has_tipo_talento';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('tipo_talento_id');
            $table->string('model_type');
            $table->integer('model_id')->unsigned();
            $table->string('dependencia', 100)->nullable();
            $table->string('univeridad', 100)->nullable();
            $table->string('carrera', 100)->nullable();

            $table->foreign('tipo_talento_id')
                ->references('id')
                ->on('tipo_talentos')
                ->onDelete('cascade');

            $table->primary(
                ['tipo_talento_id', 'model_type', 'model_id'],
                'model_has_tipo_talento_model_type_primary'
            );
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
