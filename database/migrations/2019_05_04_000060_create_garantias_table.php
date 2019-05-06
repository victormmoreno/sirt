<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarantiasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'garantias';

    /**
     * Run the migrations.
     * @table garantias
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 200)->nullable();
            $table->text('descripcion')->nullable();
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->integer('mantenimientos_id')->unsigned();
            $table->timestamps();

            $table->index(["mantenimientos_id"], 'fk_garantias_mantenimientos1_idx');

            $table->foreign('mantenimientos_id', 'fk_garantias_mantenimientos1_idx')
                ->references('id')->on('mantenimientos')
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
