<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->increments('id');
            $table->integer('documento');
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('direccion', 200)->nullable();
            $table->integer('telefono')->nullable();
            $table->integer('celular')->nullable();
            $table->date('fechanacimiento')->nullable();
            $table->text('descripcion_ocupacion')->nullable();
            $table->string('password');
            $table->boolean('estado')->default(true);
            $table->rememberToken();
            $table->integer('genero_id')->unsigned();
            $table->integer('tipodocumento_id')->unsigned();
            $table->integer('ciudad_id')->unsigned();
            $table->integer('rol_id')->unsigned();
            $table->integer('ocupacion_id')->unsigned();
            $table->integer('estrato_id')->unsigned();
            $table->integer('nodo_id')->unsigned();
            $table->timestamps();

            $table->foreign('genero_id')->references('id')->on('generos');
            $table->foreign('tipodocumento_id')->references('id')->on('tiposdocumentos');
            $table->foreign('ciudad_id')->references('id')->on('ciudades');
            $table->foreign('rol_id')->references('id')->on('rol');
            $table->foreign('ocupacion_id')->references('id')->on('ocupaciones');
            $table->foreign('estrato_id')->references('id')->on('estratos');
            $table->foreign('nodo_id')->references('id')->on('nodos');

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
