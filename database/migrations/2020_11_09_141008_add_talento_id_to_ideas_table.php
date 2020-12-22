<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTalentoIdToIdeasTable extends Migration
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
            $table->unsignedInteger('talento_id')->nullable();
            $table->unsignedInteger('empresa_id')->nullable();

            $table->index(["talento_id"], 'fk_talentos_ideas1_idx');
            $table->index(["empresa_id"], 'fk_empresas_ideas1_idx');

            $table->foreign('talento_id', 'fk_talentos_ideas1_idx')
            ->references('id')->on('talentos')
            ->onDelete('no action')
            ->onUpdate('no action');

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
            $table->dropIndex(['fk_talentos_ideas1_idx', 'fk_empresas_ideas1_idx']);
            $table->dropColumn(['talento_id', 'empresa_id']);
        });
    }
}
