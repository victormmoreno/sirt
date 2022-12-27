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
            $table->string('name', 600); //nombre
            $table->text('description'); //descripcion
            $table->timestamp('start_date'); //fecha inicio
            $table->timestamp('end_date')->nullable(); //fecha inicio
            $table->timestamp('expected_end_date')->nullable(); //fecha esperada
            $table->string('entity')->nullable();  //fecha esperada
            $table->string('contact_name')->nullable(); //nombre_contacto
            $table->string('email_entity')->nullable(); //email_entidad
            $table->string('summon_name')->nullable(); //nombre_convocatoria
            $table->text('objective')->nullable(); //objetivo
            $table->tinyInteger('tracing')->default('0'); //seguimiento
            $table->tinyInteger('postulation')->default('0'); //postulacion
            $table->tinyInteger('approval')->default('0'); //aprobacion
            $table->text('justification')->nullable(); //justificacion
            $table->tinyInteger('justified_report')->default('0'); //informe_justificado
            $table->text('report')->nullable(); //informe
            $table->string('receive')->nullable(); //recibira
            $table->timestamp('received_date')->nullable(); //cuando
            $table->tinyInteger('approval_document')->default('0'); //pdf_aprobacion
            $table->tinyInteger('non_approval_document')->default('0'); //pdf_no_aprobacion
            $table->tinyInteger('postulation_document')->default('0'); //documento_postulacion
            $table->tinyInteger('announcement_document')->default('0'); //documento_convocatoria
            $table->text('learned_lessons')->nullable(); //lecciones aprendidas
            $table->unsignedBigInteger('articulation_stage_id')->nullable();
            $table->unsignedBigInteger('scope_id')->nullable(); //alcance
            $table->unsignedInteger('phase_id')->nullable(); //fase
            $table->unsignedBigInteger('articulation_subtype_id')->nullable(); //tipo articulacion
            $table->unsignedInteger('created_by')->nullable(); //creado por

            $table->foreign('articulation_stage_id')->references('id')->on('articulation_stages');
            $table->foreign('scope_id')->references('id')->on('articulation_scopes');
            $table->foreign('phase_id')->references('id')->on('fases');
            $table->foreign('articulation_subtype_id')->references('id')->on('articulation_subtypes');
            $table->foreign('created_by')->references('id')->on('users');

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
