<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('tipodocumento_id');
            $table->unsignedInteger('gradoescolaridad_id');
            $table->unsignedInteger('gruposanguineo_id');
            $table->unsignedInteger('eps_id');
            $table->unsignedInteger('ciudad_id');
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('documento', 11);
            $table->string('email', 100);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('barrio', 100)->nullable()->default(null);
            $table->string('direccion', 200)->nullable()->default(null);
            $table->string('celular', 11)->nullable()->default(null);
            $table->string('telefono', 11)->nullable()->default(null);
            $table->date('fechanacimiento')->nullable()->default(null);
            $table->tinyInteger('genero')->default('1');
            $table->string('otra_eps', 60)->nullable()->default(null);
            $table->tinyInteger('estado')->default('1');
            $table->string('institucion', 100)->nullable()->default(null);
            $table->string('titulo_obtenido', 200)->nullable()->default(null);
            $table->date('fecha_terminacion')->nullable()->default(null);
            $table->rememberToken();
            $table->dateTime('ultimo_login')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);
            $table->tinyInteger('estrato')->nullable()->default(null);
            $table->string('otra_ocupacion', 100)->nullable()->default(null);

            $table->index(["ciudad_id"], 'fk_users_ciudad1_idx');

            $table->index(["gruposanguineo_id"], 'fk_users_gruposanquineo1_idx');

            $table->index(["tipodocumento_id"], 'users_tipodocumento_id_foreign');

            $table->index(["gradoescolaridad_id"], 'fk_users_gradoescolaridad1_idx');

            $table->index(["eps_id"], 'fk_users_eps1_idx');

            $table->unique(["documento"], 'users_documento_unique');

            $table->unique(["email"], 'email_UNIQUE');
            $table->nullableTimestamps();


            $table->foreign('ciudad_id', 'fk_users_ciudad1_idx')
                ->references('id')->on('ciudades')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('eps_id', 'fk_users_eps1_idx')
                ->references('id')->on('eps')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gradoescolaridad_id', 'fk_users_gradoescolaridad1_idx')
                ->references('id')->on('gradosescolaridad')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gruposanguineo_id', 'fk_users_gruposanquineo1_idx')
                ->references('id')->on('gruposanguineos')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('tipodocumento_id', 'users_tipodocumento_id_foreign')
                ->references('id')->on('tiposdocumentos')
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
