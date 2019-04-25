<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proyecto';

    /**
     * Run the migrations.
     * @table proyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idproyecto');
            $table->integer('foco')->unsigned();
            $table->integer('estadoproyecto')->unsigned();
            $table->integer('sector')->unsigned();
            $table->integer('tipoproyecto')->unsigned();
            $table->integer('idgestor')->unsigned();
            $table->integer('idnodo')->unsigned();
            $table->integer('idlinkdrive')->unsigned();
            $table->string('codigoproyecto', 45);
            $table->string('cedulalider', 45)->nullable()->default(null);
            $table->tinyInteger('ideaproyecto')->nullable()->default('0');
            $table->string('nombre', 200)->nullable()->default(null);
            $table->string('descripcion');
            $table->date('fechacreacion');
            $table->string('nit', 45)->nullable()->default(null);
            $table->string('razonsocial', 45)->nullable()->default(null);
            $table->string('observaciones', 200)->nullable()->default(null);
            $table->tinyInteger('pro_art_tecnoaca')->nullable()->default('0');
            $table->tinyInteger('apre_apoyo')->nullable()->default('0');
            $table->tinyInteger('apre_sinapoyo')->nullable()->default('0');
            $table->tinyInteger('art_cti')->nullable()->default('0');
            $table->tinyInteger('nom_act_cti')->nullable()->default('0');
            $table->tinyInteger('diri_ar_emp')->nullable()->default('0');
            $table->tinyInteger('reci_ar_emp')->nullable()->default('0');
            $table->tinyInteger('dine_reg')->nullable()->default('0');
            $table->tinyInteger('aco_pro_pate')->nullable()->default('0');
            $table->tinyInteger('pata_publi')->nullable()->default('0');
            $table->string('id_pate', 20)->nullable()->default(null);
            $table->date('fechacierre')->nullable()->default(null);
            $table->tinyInteger('actainicio')->nullable()->default('0');
            $table->tinyInteger('propuesta')->nullable()->default('0');
            $table->tinyInteger('bookplaneacion')->nullable()->default('0');
            $table->tinyInteger('cronograma')->nullable()->default('0');
            $table->tinyInteger('bookejecucion')->nullable()->default('0');
            $table->tinyInteger('lecciones')->nullable()->default('0');
            $table->tinyInteger('ficha')->nullable()->default('0');
            $table->tinyInteger('video')->nullable()->default('0');
            $table->tinyInteger('actacierre')->nullable()->default('0');
            $table->tinyInteger('revisadofinal')->nullable()->default('0');
            $table->tinyInteger('manualuso')->nullable()->default('0');
            $table->tinyInteger('avalgrupo')->nullable()->default('0');
            $table->tinyInteger('cartainicio')->default('0');
            $table->tinyInteger('cartafactorcritico')->default('0');
            $table->tinyInteger('informefinal')->default('0');
            $table->date('fechaejecucion')->nullable()->default(null);

            $table->index(["idlinkdrive"], 'fk_proyecto_linkdrive1_idx');

            $table->index(["idgestor"], 'fk_proyecto_gestor1_idx');

            $table->index(["foco"], 'fk_proyecto_foco1_idx');

            $table->index(["sector"], 'fk_proyecto_sector1_idx');

            $table->index(["estadoproyecto"], 'fk_proyecto_estadoproyecto1_idx');

            $table->index(["idnodo"], 'fk_proyecto_nodo1_idx');

            $table->index(["tipoproyecto"], 'fk_proyecto_tipoproyecto1_idx');


            $table->foreign('estadoproyecto', 'fk_proyecto_estadoproyecto1_idx')
                ->references('idestadoproyecto')->on('estadoproyecto')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('foco', 'fk_proyecto_foco1_idx')
                ->references('idfoco')->on('foco')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idgestor', 'fk_proyecto_gestor1_idx')
                ->references('idgestor')->on('gestor')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idlinkdrive', 'fk_proyecto_linkdrive1_idx')
                ->references('idlinkdrive')->on('linkdrive')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('idnodo', 'fk_proyecto_nodo1_idx')
                ->references('idnodo')->on('nodo')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sector', 'fk_proyecto_sector1_idx')
                ->references('idsector')->on('sector')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipoproyecto', 'fk_proyecto_tipoproyecto1_idx')
                ->references('idtipoproyecto')->on('tipoproyecto')
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
