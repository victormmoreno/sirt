<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitantesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'visitantes';
//33236 a  33237
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

    /**
     * Run the migrations.
     * @table visitantes
     *
     * @return void
     */
    public function up()
    {1035441149
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tipodocumento_id')->unsigned();
            $table->integer('tipovisitante_id')->unsigned();
            $table->string('documento', 15);
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('email', 100)->nullable();
            $table->string('contacto', 45)->nullable();
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
            $table->index(["tipodocumento_id"], 'fk_visitantes_tiposdocumentos1_idx');

            $table->index(["tipovisitante_id"], 'fk_visitantes_tiposvisitante1_idx');

            $table->unique(["documento"], 'documento_UNIQUE');

            $table->foreign('tipodocumento_id', 'fk_visitantes_tiposdocumentos1_idx')
                ->references('id')->on('tiposdocumentos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipovisitante_id', 'fk_visitantes_tiposvisitante1_idx')
                ->references('id')->on('tiposvisitante')
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
