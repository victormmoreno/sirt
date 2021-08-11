<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGestorIdToIdeasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'ideas';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('gestor_id')->nullable();

            $table->index(["gestor_id"], 'fk_ideas_gestores1_idx');

            $table->foreign('gestor_id', 'fk_ideas_gestores1_idx')
            ->references('id')->on('gestores')
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
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['gestor_id']);
        });
    }
}
