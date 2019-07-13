<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'talentos';

    /**
     * Run the migrations.
     * @table talentos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('perfil_id');
            $table->unsignedInteger('entidad_id');
            $table->string('univesidad', 200)->nullable();
            $table->string('programa_formacion', 100)->default('No Aplica');
            $table->string('carrera_universitaria', 100)->default('No Aplica');
            $table->string('empresa', 200)->nullable();
            $table->string('otro_tipo_talento', 45)->nullable();
            $table->timestamps();

            $table->index(["entidad_id"], 'fk_talentos_entidades1_idx');

            $table->index(["user_id"], 'fk_talentos_user1_idx');

            $table->index(["perfil_id"], 'fk_talento_perfil1_idx');


            $table->foreign('perfil_id', 'fk_talento_perfil1_idx')
                ->references('id')->on('perfiles')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('entidad_id', 'fk_talentos_entidades1_idx')
                ->references('id')->on('entidades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_talentos_user1_idx')
                ->references('id')->on('users')
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
