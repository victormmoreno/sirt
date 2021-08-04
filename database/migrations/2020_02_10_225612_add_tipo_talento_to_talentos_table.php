<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoTalentoToTalentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'talentos';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->unsignedInteger('tipo_talento_id')->nullable()->after('user_id');
            $table->index(["tipo_talento_id"], 'fk_tipo_talento_id_talentos_1_idx');

            $table->foreign('tipo_talento_id', 'fk_tipo_talento_id_talentos_1_idx')
                ->references('id')->on('tipo_talentos');
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
            $table->dropColumn(['tipo_talento_id']);
        });
    }
}
