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
            $table->integer('rol_id')->unsigned();
            $table->integer('gradosescolaridad_id')->unsigned();
            $table->integer('persona_id')->unsigned();
            $table->string('email', 100);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('direccion', 200)->nullable();
            $table->integer('telefono')->nullable();
            $table->integer('celular')->nullable();
            $table->date('fechanacimiento');
            $table->tinyInteger('genero');
            $table->string('password')->nullable();
            $table->boolean('estado')->default(true);
            $table->rememberToken();
            $table->tinyInteger('estrato')->nullable();
            $table->timestamps();

            $table->unique(["email"], 'email_UNIQUE');

            $table->index(["persona_id"], 'fk_users_personas1_idx');

            $table->index(["rol_id"], 'fk_users_rols1_idx');

            $table->index(["gradosescolaridad_id"], 'fk_users_gradosescolaridad1_idx');
            // $table->nullableTimestamps();


            $table->foreign('rol_id', 'fk_users_rols1_idx')
                ->references('id')->on('rols')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gradosescolaridad_id', 'fk_users_gradosescolaridad1_idx')
                ->references('id')->on('gradosescolaridad')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('persona_id', 'fk_users_personas1_idx')
                ->references('id')->on('personas')
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
