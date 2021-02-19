<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIdeasTable extends Migration
{
    public $tableName = 'ideas';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('empresa_id')->nullable();

            $table->index(["empresa_id"], 'fk_empresas_ideas1_idx');

            $table->foreign('empresa_id', 'fk_empresas_ideas1_idx')
            ->references('id')->on('empresas')
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
            $table->dropIndex(['fk_empresas_ideas1_idx']);
            $table->dropColumn(['empresa_id']);
        });
    }
}
