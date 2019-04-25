<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitanteTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'visitante';

    /**
     * Run the migrations.
     * @table visitante
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idvisitante');
            $table->integer('tipodocumento')->unsigned();
            $table->integer('tipovisitante')->unsigned();
            $table->integer('idnodo')->default('1')->unsigned();
            $table->string('numeroidentificacion', 45)->nullable()->default(null);
            $table->string('nombres', 45)->nullable()->default(null);
            $table->string('apellidos', 45)->nullable()->default(null);
            $table->string('contacto', 45)->nullable()->default(null);
            $table->string('correo', 50)->nullable()->default(null);
            $table->tinyInteger('estado')->nullable()->default('1');

            $table->index(["tipodocumento"], 'fk_persona_tipodocumento2_idx');

            $table->index(["idnodo"], 'fk_visitante_nodo1_idx');

            $table->index(["tipovisitante"], 'fk_visitante_tipovisitante1_idx');


            $table->foreign('tipodocumento', 'fk_persona_tipodocumento2_idx')
                ->references('idtipodocumento')->on('tipodocumento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idnodo', 'fk_visitante_nodo1_idx')
                ->references('idnodo')->on('nodo')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipovisitante', 'fk_visitante_tipovisitante1_idx')
                ->references('idtipovisitante')->on('tipovisitante')
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
