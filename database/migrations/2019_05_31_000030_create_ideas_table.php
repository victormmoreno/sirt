<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ideas';

    /**
     * Run the migrations.
     * @table ideas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('estadoidea_id');
            $table->string('nombres_contacto', 45);
            $table->string('apellidos_contacto', 45);
            $table->string('correo_contacto',100)->nullable();
            $table->string('telefono_contacto',11)->nullable();
            $table->string('nombre_proyecto', 200);
            $table->string('codigo_idea', 20);
            $table->tinyInteger('aprendiz_sena')->default(1);
            $table->tinyInteger('pregunta1')->default(1);
            $table->tinyInteger('pregunta2')->default(1);
            $table->tinyInteger('pregunta3')->default(1);
            $table->string('descripcion',2000)->nullable();
            $table->string('objetivo',2000)->nullable();
            $table->string('alcance',2000)->nullable();
            $table->tinyInteger('tipo_idea')->default(1); //1- emprendedor - 2- empresa - 3- grupo de investigacion
             //1- emprendedor - 2- empresa - 3- grupo de investigacion
            $table->timestamps();

            $table->unique(["codigo_idea"], 'codigo_idea_UNIQUE');

            $table->index(["nodo_id"], 'fk_ideas_nodo1_idx');
            $table->index(["estadoidea_id"], 'fk_ideas_estadosidea1_idx');


            $table->foreign('nodo_id', 'fk_ideas_nodo1_idx')
                ->references('id')->on('nodos');

            $table->foreign('estadoidea_id', 'fk_ideas_estadosidea1_idx')
                ->references('id')->on('estadosidea');


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
