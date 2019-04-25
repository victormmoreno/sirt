<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetallegrupoinvestigacionproyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'detallegrupoinvestigacionproyecto';

    /**
     * Run the migrations.
     * @table detallegrupoinvestigacionproyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idgrupoinvestigacion')->unsigned();
            $table->integer('idproyecto')->unsigned();

            $table->index(["idgrupoinvestigacion"], 'fk_detallegrupoinvestigacionproyecto_grupoinvestigacion1_idx');

            $table->index(["idproyecto"], 'fk_detallegrupoinvestigacionproyecto_proyecto1_idx');


            $table->foreign('idgrupoinvestigacion', 'detallegrupoinvestigacionproyecto_idgrupoinvestigacion')
                ->references('idgrupoinvestigacion')->on('grupoinvestigacion')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idproyecto', 'fk_detallegrupoinvestigacionproyecto_proyecto1_idx')
                ->references('idproyecto')->on('proyecto')
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
