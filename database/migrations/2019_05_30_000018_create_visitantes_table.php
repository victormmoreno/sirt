<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitantesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'visitantes';

    /**
     * Run the migrations.
     * @table visitantes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('persona_id')->unsigned();
            $table->string('correo', 100)->nullable();
            $table->string('contacto', 45)->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->timestamps();

            $table->index(["persona_id"], 'fk_visitantes_personas1_idx');


            $table->foreign('persona_id', 'fk_visitantes_personas1_idx')
                ->references('id')->on('personas')
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
