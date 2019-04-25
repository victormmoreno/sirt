<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
   

    /**
     * Run the migrations.
     * @table persona
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('rol')->unsigned();
            $table->integer('nodo')->unsigned();
            $table->integer('tipodocumento')->unsigned();
            $table->integer('proveedor')->unsigned();
            $table->string('documento', 45);
            $table->string('nombres', 45);
            $table->string('apellidos', 45);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('estado')->nullable()->default('1');
            $table->string('contacto', 45)->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();

            
            $table->index(["proveedor"], 'fk_persona_proveedores1_idx');

            $table->index(["rol"], 'fk_persona_rol_idx');

            $table->index(["nodo"], 'fk_persona_nodo1_idx');

            $table->index(["tipodocumento"], 'fk_persona_tipodocumento1_idx');


            $table->foreign('nodo', 'fk_persona_nodo1_idx')
                ->references('idnodo')->on('nodo');
                

            $table->foreign('proveedor', 'fk_persona_proveedores1_idx')
                ->references('id_proveedores')->on('proveedores');
                

            $table->foreign('rol', 'fk_persona_rol_idx')
                ->references('idrol')->on('rol');
                
            $table->foreign('tipodocumento', 'fk_persona_tipodocumento1_idx')
                ->references('idtipodocumento')->on('tipodocumento');
               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('users');
     }
}
