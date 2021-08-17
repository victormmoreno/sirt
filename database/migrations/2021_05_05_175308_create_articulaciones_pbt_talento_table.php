<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulacionesPbtTalentoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'articulaciones_pbt_talento';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('articulacion_pbt_id');
            $table->unsignedInteger('talento_id');
            $table->tinyInteger('talento_lider')->default('0');
            $table->foreign('articulacion_pbt_id')->references('id')->on('articulacion_pbts')->onDelete('cascade');
            $table->foreign('talento_id')->references('id')->on('talentos')->onDelete('cascade');
            $table->timestamps();
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
