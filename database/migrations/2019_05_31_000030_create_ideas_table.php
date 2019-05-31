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
            $table->string('nombres_contacto', 45)->nullable();
            $table->string('apellidos_contacto', 45)->nullable();
            $table->string('correo_contacto',100)->nullable();
            $table->string('nombre_proyecto', 100)->nullable();
            $table->tinyInteger('aprendiz_sena')->nullable();
            $table->tinyInteger('pregunta1')->nullable();
            $table->tinyInteger('pregunta2')->nullable();
            $table->tinyInteger('pregunta3')->nullable();
            $table->string('descripcion',1000)->nullable();
            $table->string('objetivo',1000)->nullable();
            $table->string('alcance',1000)->nullable();
            $table->tinyInteger('tipo_idea')->nullable();
            $table->timestamps();

            $table->index(["nodo_id"], 'fk_ideas_nodo1_idx');


            $table->foreign('nodo_id', 'fk_ideas_nodo1_idx')
                ->references('id')->on('nodos');
    
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
