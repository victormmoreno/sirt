<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosentidadesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'contactosentidades';

    /**
     * Run the migrations.
     * @table contactosentidades
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('entidad_id');
            $table->string('nombres_contacto', 60);
            $table->string('correo_contacto', 100);
            $table->string('telefono_contacto', 11);

            $table->index(["entidad_id"], 'fk_contactoentidad_entidades1_idx');

            $table->index(["nodo_id"], 'fk_contactoentidad_nodos1_idx');
            $table->nullableTimestamps();


            $table->foreign('entidad_id', 'fk_contactoentidad_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('nodo_id', 'fk_contactoentidad_nodos1_idx')
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
