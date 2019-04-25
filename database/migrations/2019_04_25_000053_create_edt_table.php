<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdtTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'edt';

    /**
     * Run the migrations.
     * @table edt
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idedt');
            $table->integer('gestor')->unsigned();
            $table->date('fecha')->nullable()->default(null);
            $table->string('nombre', 45)->nullable()->default(null);
            $table->string('empresa', 45)->nullable()->default(null);
            $table->string('contacto', 45)->nullable()->default(null);
            $table->string('correo', 45)->nullable()->default(null);
            $table->string('telefono', 45)->nullable()->default(null);
            $table->string('observaciones', 200)->nullable()->default(null);
            $table->string('empleados', 45)->nullable()->default('0');
            $table->string('instructores', 45)->nullable()->default('0');
            $table->string('aprendices', 45)->nullable()->default('0');
            $table->string('publico', 45)->nullable()->default('0');

            $table->index(["gestor"], 'fk_edt_gestor1_idx');


            $table->foreign('gestor', 'fk_edt_gestor1_idx')
                ->references('idgestor')->on('gestor')
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
