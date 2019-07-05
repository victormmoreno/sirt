<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosentidadesTable extends Migration
{

    public $tableName = 'contactosentidades';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('entidad_id');
            $table->string('nombres_contacto',60)->nullable();
            $table->string('correo_contacto',100)->nullable();
            $table->string('telefono_contacto', 11)->nullable();
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_contactoentidad_nodos1_idx');

            $table->index(["entidad_id"], 'fk_contactoentidad_entidades1_idx');


            $table->foreign('nodo_id', 'fk_contactoentidad_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('entidad_id', 'fk_contactoentidad_entidades1_idx')
                ->references('id')->on('entidades')
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
        Schema::dropIfExists('contactosentidades');
    }
}
