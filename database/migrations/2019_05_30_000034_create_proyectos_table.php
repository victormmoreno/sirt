<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('sectorproyecto_id')->unsigned();
            $table->integer('sublinea_id')->unsigned();
            $table->integer('areaconocimiento_id')->unsigned();
            $table->integer('tipoarticulacion_id')->unsigned();
            $table->integer('estadoproyecto_id')->unsigned();
            $table->integer('gestor_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('entidad_id')->unsigned();
            $table->integer('nodo_id')->unsigned();
            $table->string('codigo_proyecto', 20);
            $table->string('nombre', 200);
            $table->text('impacto_proyecto')->nullable();
            $table->tinyInteger('economia_naranja')->default('0');
            $table->text('resultado_proyecto')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->string('estado_prototipo', 35)->nullable();
            $table->double('aporte_sena')->nullable();
            $table->double('aporte_talento')->nullable();
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
            $table->tinyInteger('acc')->nullable()->default('0');
            $table->string('dir_acc')->nullable();
            $table->tinyInteger('manual_uso_inf')->nullable()->default('0');
            $table->string('dir_manual_uso_inf')->nullable();
            $table->tinyInteger('ava_empresa_grupo')->nullable()->default('0');
            $table->string('dir_ava_empresa_grupo')->nullable();
            $table->tinyInteger('acta_inicio')->nullable()->default('0');
            $table->string('dir_acta_inicio')->nullable();
            $table->tinyInteger('estado_arte')->nullable()->default('0');
            $table->string('dir_estado_arte')->nullable();
            $table->tinyInteger('actas_seguimiento')->nullable()->default('0');
            $table->string('dir_actas_seguimiento')->nullable();
            $table->tinyInteger('video_tutorial')->nullable()->default('0');
            $table->tinyInteger('fecha_caracterizacion')->nullable()->default('0');
            $table->string('dir_fecha_caracterizacion')->nullable();
            $table->tinyInteger('acta_cierre')->nullable()->default('0');
            $table->string('dir_acta_cierre')->nullable();
            $table->tinyInteger('lecciones_aprendidas')->nullable()->default('0');
            $table->string('dir_lecciones_aprendidas')->nullable();
            $table->tinyInteger('encuesta')->nullable()->default('0');
            $table->string('dir_encuesta')->nullable();
            $table->timestamps();

            $table->unique(["codigo_proyecto"], 'codigo_proyecto_UNIQUE');

            $table->index(["entidad_id"], 'fk_proyectos_entidades1_idx');

            $table->index(["gestor_id"], 'fk_proyectos_gestores1_idx');

            $table->index(["sublinea_id"], 'fk_proyectos_sublineas1_idx');

            $table->index(["areaconocimiento_id"], 'fk_proyectos_areasconocimiento1_idx');

            $table->index(["nodo_id"], 'fk_proyectos_nodos1_idx');

            $table->index(["producto_id"], 'fk_proyectos_productos1_idx');

            $table->index(["sectorproyecto_id"], 'fk_proyectos_sectoresproyectos1_idx');

            $table->index(["tipoarticulacion_id"], 'fk_proyectos_tiposarticulacion1_idx');

            $table->index(["estadoproyecto_id"], 'fk_proyectos_estadosproyecto1_idx');


            $table->foreign('sublinea_id', 'fk_proyectos_sublineas1_idx')
                ->references('id')->on('sublineas')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('areaconocimiento_id', 'fk_proyectos_areasconocimiento1_idx')
                ->references('id')->on('areasconocimiento')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipoarticulacion_id', 'fk_proyectos_tiposarticulacion1_idx')
                ->references('id')->on('tiposarticulacion')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('estadoproyecto_id', 'fk_proyectos_estadosproyecto1_idx')
                ->references('id')->on('estadosproyecto')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('nodo_id', 'fk_proyectos_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gestor_id', 'fk_proyectos_gestores1_idx')
                ->references('id')->on('gestores')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('producto_id', 'fk_proyectos_productos1_idx')
                ->references('id')->on('productos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('entidad_id', 'fk_proyectos_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('sectorproyecto_id', 'fk_proyectos_sectoresproyectos1_idx')
                ->references('id')->on('sectoresproyectos')
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
