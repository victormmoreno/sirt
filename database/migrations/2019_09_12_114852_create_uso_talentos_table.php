<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsoTalentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'uso_talentos';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('usoinfraestructura_id');
            $table->unsignedInteger('talento_id');
            $table->timestamps();

            $table->index(["usoinfraestructura_id"], 'fk_uso_talentos_usoinfraestructura1_idx');
            $table->index(["talento_id"], 'fk_uso_talentos_talentos1_idx');

            $table->foreign('usoinfraestructura_id', 'fk_uso_talentos_usoinfraestructura1_idx')
                ->references('id')->on('usoinfraestructuras')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('talento_id', 'fk_uso_talentos_talentos1_idx')
                ->references('id')->on('talentos')
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
