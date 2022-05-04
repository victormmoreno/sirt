<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique(); //codigo
            $table->string('name', 100); //nombre
            $table->text('description'); //descripcion
            $table->timestamp('start_date'); //fecha inicio
            $table->timestamp('end_date')->nullable(); //fecha inicio
            $table->timestamp('expected_end_date')->nullable(); //fecha esperada
            $table->string('entity')->nullable();  //fecha esperada
            $table->string('contact_name')->nullable(); //nombre_contacto
            $table->string('email_entity')->nullable(); //email_entidad
            $table->string('summon_name')->nullable(); //nombre_convocatoria
            $table->text('objective')->nullable(); //objetivo

            $table->unsignedBigInteger('accompaniment_id');
            $table->unsignedBigInteger('scope_id')->nullable(); //alcance
            $table->unsignedInteger('phase_id')->nullable(); //fase
            $table->unsignedBigInteger('articulation_type_id')->nullable(); //tipo articulacion

            $table->foreign('accompaniment_id')->references('id')->on('accompaniments')->onDelete('cascade');
            $table->foreign('scope_id')->references('id')->on('alcance_articulaciones')->onDelete('set null');
            $table->foreign('phase_id')->references('id')->on('fases')->onDelete('set null');
            $table->foreign('articulation_type_id')->references('id')->on('tipo_articulaciones')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulations');
    }
}
