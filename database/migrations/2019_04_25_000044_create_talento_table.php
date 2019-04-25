<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalentoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'talento';

    /**
     * Run the migrations.
     * @table talento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('idtalento');
            $table->integer('user')->unsigned();
            $table->integer('tipotalento')->unsigned();
            $table->integer('nivelacademico')->unsigned();
            $table->integer('ocupacion')->unsigned();
            $table->integer('ciudad')->unsigned();
            $table->string('des_ocu')->nullable()->default(null);
            $table->tinyInteger('genero');
            $table->string('direccion', 45)->nullable()->default(null);
            $table->tinyInteger('estrato')->nullable()->default(null);
            $table->string('titulobtenido', 120)->nullable()->default(null);
            $table->date('fechaterminado')->nullable()->default('2015-11-27');
            $table->string('institucion', 80)->nullable()->default(null);
            $table->date('fechanacimiento')->nullable()->default(null);

            $table->index(["ciudad"], 'fk_talento_ciudad1_idx');

            $table->index(["user"], 'fk_talento_user1_idx');

            $table->index(["nivelacademico"], 'fk_talento_nivelacademico1_idx');

            $table->index(["ocupacion"], 'fk_talento_ocupacion1_idx');

            $table->index(["tipotalento"], 'fk_talento_tipotalento1_idx');


            $table->foreign('ciudad', 'fk_talento_ciudad1_idx')
                ->references('idciudad')->on('ciudad')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('nivelacademico', 'fk_talento_nivelacademico1_idx')
                ->references('idnivelacademico')->on('nivelacademico')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('ocupacion', 'fk_talento_ocupacion1_idx')
                ->references('idocupacion')->on('ocupacion')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user', 'fk_talento_persona1_idx')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipotalento', 'fk_talento_tipotalento1_idx')
                ->references('idtipotalento')->on('tipotalento')
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
