<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEmpresasTable extends Migration
{
    public $tableName = 'empresas';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            // Nuevos campos
            $table->unsignedInteger('tipoempresa_id')->nullable()->after('sector_id');
            $table->unsignedInteger('tamanhoempresa_id')->nullable()->after('tipoempresa_id');
            $table->date('fecha_creacion')->nullable()->after('direccion');
            $table->string('codigo_ciiu', 20)->nullable()->after('fecha_creacion');

            // Nuevas llaves
            $table->index(["tipoempresa_id"], 'fk_empresas_tipos_empresas1_idx');

            $table->index(["tamanhoempresa_id"], 'fk_empresas_tamanhos_empresas1_idx');

            $table->foreign('tipoempresa_id', 'fk_empresas_tipos_empresas1_idx')
                ->references('id')->on('tipos_empresas')
                ->onDelete('no action')
                ->onUpdate('no action');


            $table->foreign('tamanhoempresa_id', 'fk_empresas_tamanhos_empresas1_idx')
                ->references('id')->on('tamanhos_empresas')
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
            $table->dropColumn(['tipoempresa_id', 'tamanhoempresa_id', 'fecha_creacion', 'codigo_ciiu']);
        });
    }
}
