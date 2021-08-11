<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipoUsoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'equipo_uso';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('equipo_id');
            $table->unsignedBigInteger('usoinfraestructura_id');
            $table->decimal('tiempo',10,1)->default(0,0);
            $table->timestamps();

            $table->index(["equipo_id"], 'fk_equipo_uso_equipo1_idx');
            $table->index(["usoinfraestructura_id"], 'fk_equipo_uso_usoinfraestructura1_idx');

            $table->foreign('equipo_id', 'fk_equipo_uso_equipo1_idx')
                ->references('id')->on('equipos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('usoinfraestructura_id', 'fk_equipo_uso_usoinfraestructura1_idx')
                ->references('id')->on('usoinfraestructuras')
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
