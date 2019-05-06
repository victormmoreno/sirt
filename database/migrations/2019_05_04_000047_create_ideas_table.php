<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('nombrec', 45)->nullable();
            $table->string('apellidoc', 45)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->string('nombreproyecto', 100)->nullable();
            $table->tinyInteger('aprendizsena')->nullable();
            $table->string('pregunta1', 45)->nullable();
            $table->string('pregunta2', 45)->nullable();
            $table->string('pregunta3', 45)->nullable();
            $table->text('descripcion')->nullable();
            $table->text('objetivo')->nullable();
            $table->text('alcance')->nullable();
            $table->date('fecha')->nullable();
            $table->tinyInteger('estado')->nullable();
            $table->integer('nodo_id')->unsigned();
            $table->integer('tipoidea_id')->unsigned();
            $table->integer('estadoidea_id')->unsigned();
            $table->timestamps();

            $table->index(["tipoidea_id"], 'fk_ideas_tiposideas1_idx');

            $table->index(["nodo_id"], 'fk_ideas_nodos1_idx');

            $table->index(["estadoidea_id"], 'fk_ideas_estadosideas1_idx');

            $table->foreign('nodo_id', 'fk_ideas_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipoidea_id', 'fk_ideas_tiposideas1_idx')
                ->references('id')->on('tiposideas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('estadoidea_id', 'fk_ideas_estadosideas1_idx')
                ->references('id')->on('estadosideas')
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
