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
    protected $tableName = 'visitantes';

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
            $table->unsignedInteger('tipodocumento_id');
            $table->unsignedInteger('tipovisitante_id');
            $table->string('documento', 15);
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('contacto', 15)->nullable()->default(null);
            $table->tinyInteger('estado')->default('1');

            $table->index(["tipodocumento_id"], 'fk_visitantes_tiposdocumentos1_idx');

            $table->index(["tipovisitante_id"], 'fk_visitantes_tiposvisitante1_idx');

            $table->unique(["documento"], 'documento_UNIQUE');
            $table->nullableTimestamps();

            $table->foreign('tipodocumento_id', 'fk_visitantes_tiposdocumentos1_idx')
                ->references('id')->on('tiposdocumentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipovisitante_id', 'fk_visitantes_tiposvisitante1_idx')
                ->references('id')->on('tiposvisitante')
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
