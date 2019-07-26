<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosVisitantes extends Migration
{

    /**
    * Cambiar los ingresos con los siguientes id de visitantes
    */
    // 33037 a 33038
    // 33044 a 33045
    // 33072 a 33073
    // 33236 a 33237
    // 33392 a 33393
    // 33505 a 33506
    // 33582 a 33583
    // 33617 a 33618
    // 33638 a 33639
    // 33670 a 33671
    // 33788 a 33789
    // 33858 a 33859
    // 33322 a 33323
    // 33397 a 33398
    // 33478 a 33479
    // 33771 a 33772
    // 33751 a 33752

    //--------------------------------------------------------------------------------------------------------------------------------------//
    //33037 a  33038
    //33044 a  33045
    //33072 a  33073
    //33236 a  33237
    //33322 a  33323
    //33392 a  33393
    //33397 a  33398
    //33478 a  33479
    //33505 a  33506
    //33582 a  33583
    //33670 a  33671
    //33788 a  33789
    //33858 a  33859
    //33617 a  33618
    //33638 a  33639
    //33751 a  33752
    //33771 a  33772


    public $tableName = 'ingresos_visitantes';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visitante_id');
            $table->unsignedInteger('nodo_id');
            $table->unsignedInteger('servicio_id');
            $table->timestamp('fecha_ingreso');
            $table->time('hora_salida');
            $table->string('descripcion',2000)->nullable();
            $table->timestamps();

            $table->index(["visitante_id"], 'fk_ingresos_visitantes_visitantes1_idx');

            $table->index(["nodo_id"], 'fk_ingresos_visitantes_nodos1_idx');
            $table->index(["servicio_id"], 'fk_ingresos_visitantes_servicios1_idx');

            $table->foreign('visitante_id', 'fk_ingresos_visitantes_visitantes1_idx')
            ->references('id')->on('visitantes')
            ->onDelete('no action')
            ->onUpdate('no action');

            $table->foreign('nodo_id', 'fk_ingresos_visitantes_nodos1_idx')
                ->references('id')->on('nodos')
                ->onDelete('no action')
                ->onUpdate('no action');


            $table->foreign('servicio_id', 'fk_ingresos_visitantes_servicios1_idx')
                ->references('id')->on('servicios')
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
