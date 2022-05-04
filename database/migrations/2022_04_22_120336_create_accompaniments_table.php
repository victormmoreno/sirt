<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Accompaniment;

class CreateAccompanimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accompaniments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('accompaniment_type'); //tipo acompañamiento
            $table->string('code', 50)->unique(); //codigo
            $table->string('name', 100); //nombre
            $table->text('description')->nullable(); //descripcion
            $table->text('scope'); //alcance
            $table->boolean('status')->default(Accompaniment::STATUS_OPEN); //Estado
            $table->timestamp('start_date'); //fecha inicio
            $table->timestamp('end_date')->nullable(); //fecha fin
            $table->boolean('confidentiality_format')->default(Accompaniment::CONFIDENCIALITY_FORMAT_NO); //formato de confidencialidad
            $table->timestamp('terms_verified_at')->nullable()->default(null); //terminos y condiciones
            $table->unsignedInteger('node_id')->nullable(); //nodo
            $table->unsignedInteger('interlocutor_talent_id')->nullable(); //talento_interlocutor
            $table->foreign('node_id')->references('id')->on('nodos')->onDelete('set null');
            $table->foreign('interlocutor_talent_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('accompaniments');
    }
}
