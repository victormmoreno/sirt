<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToTalantosTable extends Migration
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
            $table->unsignedInteger('tipo_formacion_id')->nullable()->after('empresa');
            $table->unsignedInteger('tipo_estudio_id')->nullable()->after('tipo_formacion_id');

            $table->index(["tipo_formacion_id"], 'fk_tipo_formacion_id_talentos_1_idx');
            $table->index(["tipo_estudio_id"], 'fk_tipo_estudio_id_talentos_1_idx');

            $table->foreign('tipo_formacion_id', 'fk_tipo_formacion_id_talentos_1_idx')
                ->references('id')->on('tipo_formacion');

            $table->foreign('tipo_estudio_id', 'fk_tipo_estudio_id_talentos_1_idx')
                ->references('id')->on('tipo_estudio');

            $table->string('dependencia', 50)->after('empresa')->nullable();
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
            $table->dropColumn(['tipo_formacion_id', 'tipo_estudio_id', 'dependencia']);
        });
    }
}
