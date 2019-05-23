<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'talentos';

    /**
     * Run the migrations.
     * @table talentos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tipotalento_id');
            $table->string('empresa', 100)->nullable();
            $table->timestamps();

            $table->index(["user_id"], 'fk_talentos_users1_idx');

            $table->index(["tipotalento_id"], 'fk_talentos_tipostalentos1_idx');

            $table->foreign('user_id', 'fk_talentos_users1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipotalento_id', 'fk_talentos_tipostalentos1_idx')
                ->references('id')->on('tipostalentos')
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
