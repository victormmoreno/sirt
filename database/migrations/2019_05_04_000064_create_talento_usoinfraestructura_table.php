<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalentoUsoinfraestructuraTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'talento_usoinfraestructura';

    /**
     * Run the migrations.
     * @table talento_usoinfraestructura
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('talento_id');
            $table->unsignedInteger('usoinfraestructura_id');
            $table->timestamps();

            $table->index(["talento_id"], 'fk_talento_usoinfraestructura_talentos1_idx');

            $table->index(["usoinfraestructura_id"], 'fk_talento_usoinfraestructura_usosinfraestructuras1_idx');

            $table->foreign('talento_id', 'fk_talento_usoinfraestructura_talentos1_idx')
                ->references('id')->on('talentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('usoinfraestructura_id', 'fk_talento_usoinfraestructura_usosinfraestructuras1_idx')
                ->references('id')->on('usosinfraestructuras')
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
