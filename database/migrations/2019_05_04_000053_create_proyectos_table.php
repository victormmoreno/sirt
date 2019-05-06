<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proyectos';

    /**
     * Run the migrations.
     * @table proyectos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('codigoproyecto', 45);
            $table->string('cedulalider', 45)->nullable();
            $table->tinyInteger('ideaproyecto')->nullable()->default('0');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('fechacreacion');
            $table->tinyInteger('pro_art_tecnoaca')->nullable()->default('0');
            $table->tinyInteger('apre_apoyo')->nullable()->default('0');
            $table->tinyInteger('apre_sinapoyo')->nullable()->default('0');
            $table->tinyInteger('art_cti')->nullable()->default('0');
            $table->tinyInteger('nom_act_ctil')->nullable()->default('0');
            $table->tinyInteger('diri_ar_emp')->nullable()->default('0');
            $table->tinyInteger('reci_ar_emp')->nullable()->default('0');
            $table->tinyInteger('dine_reg')->nullable()->default('0');
            $table->tinyInteger('aco_pro_pate')->nullable()->default('0');
            $table->tinyInteger('pata_publi')->nullable()->default('0');
            $table->string('id_patente', 20)->nullable();
            $table->date('fechacierre')->nullable();
            $table->tinyInteger('actainicio')->nullable()->default('0');
            $table->tinyInteger('propuesta')->nullable()->default('0');
            $table->tinyInteger('bookplaneacion')->nullable()->default('0');
            $table->tinyInteger('lecciones')->nullable()->default('0');
            $table->tinyInteger('ficha')->nullable()->default('0');
            $table->tinyInteger('video')->nullable()->default('0');
            $table->tinyInteger('actacierre')->nullable()->default('0');
            $table->tinyInteger('revisadofinal')->nullable()->default('0');
            $table->tinyInteger('manualuso')->nullable()->default('0');
            $table->tinyInteger('avalgrupo')->nullable()->default('0');
            $table->tinyInteger('cartainicio')->nullable()->default('0');
            $table->tinyInteger('cartafactorcritico')->nullable()->default('0');
            $table->tinyInteger('informefinal')->nullable()->default('0');
            $table->date('fechaejecucion')->nullable();
            $table->integer('foco_id')->unsigned();
            $table->integer('sector_id')->unsigned();
            $table->integer('estadoproyecto_id')->unsigned();
            $table->integer('tipoproyecto_id')->unsigned();
            $table->integer('gestor_id')->unsigned();
            $table->integer('linkdrive_id')->unsigned();
            $table->integer('areaconocimiento_id')->unsigned();
            $table->timestamps();

            $table->index(["sector_id"], 'fk_proyectos_sectores1_idx');

            $table->index(["linkdrive_id"], 'fk_proyectos_linksdrive1_idx');

            $table->index(["gestor_id"], 'fk_proyectos_gestores1_idx');

            $table->index(["tipoproyecto_id"], 'fk_proyectos_tiposproyectos1_idx');

            $table->index(["areaconocimiento_id"], 'fk_proyectos_areasconocimiento1_idx');

            $table->index(["estadoproyecto_id"], 'fk_proyectos_estadosproyectos1_idx');

            $table->index(["foco_id"], 'fk_proyectos_focos1_idx');

            $table->unique(["codigoproyecto"], 'codigoproyecto_UNIQUE');

            $table->foreign('gestor_id', 'fk_proyectos_gestores1_idx')
                ->references('id')->on('gestores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('foco_id', 'fk_proyectos_focos1_idx')
                ->references('id')->on('focos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sector_id', 'fk_proyectos_sectores1_idx')
                ->references('id')->on('sectores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('estadoproyecto_id', 'fk_proyectos_estadosproyectos1_idx')
                ->references('id')->on('estadosproyectos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipoproyecto_id', 'fk_proyectos_tiposproyectos1_idx')
                ->references('id')->on('tiposproyectos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('linkdrive_id', 'fk_proyectos_linksdrive1_idx')
                ->references('id')->on('linksdrive')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('areaconocimiento_id', 'fk_proyectos_areasconocimiento1_idx')
                ->references('id')->on('areasconocimiento')
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
