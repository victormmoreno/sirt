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
            $table->unsignedInteger('rol_id');
            $table->unsignedInteger('gradosescolaridad_id');
            $table->unsignedInteger('persona_id');
            $table->string('email', 100);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('direccion', 200)->nullable();
            $table->string('telefono', 11)->nullable();
            $table->date('fechanacimiento');
            $table->tinyInteger('genero');
            $table->tinyInteger('estado')->default('1');
            $table->rememberToken();
            $table->string('password', 255)->nullable();
            $table->tinyInteger('estrato')->nullable();

            $table->index(["persona_id"], 'fk_users_personas1_idx');

            $table->index(["rol_id"], 'fk_users_rols1_idx');

            $table->index(["gradosescolaridad_id"], 'fk_users_gradosescolaridad1_idx');

            $table->unique(["email"], 'email_UNIQUE');
            $table->nullableTimestamps();


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
