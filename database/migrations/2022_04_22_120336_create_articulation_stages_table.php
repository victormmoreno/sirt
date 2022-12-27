<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ArticulationStage;

class CreateArticulationStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulation_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique(); //codigo
            $table->string('name', 600); //nombre
            $table->text('description')->nullable(); //descripcion
            $table->text('scope'); //alcance
            $table->boolean('status')->default(ArticulationStage::STATUS_OPEN); //Estado
            $table->boolean('endorsement')->default(0); //aval
            $table->timestamp('start_date'); //fecha inicio
            $table->timestamp('end_date')->nullable(); //fecha fin
            $table->boolean('confidentiality_format')->default(ArticulationStage::CONFIDENCIALITY_FORMAT_NO); //formato de confidencialidad
            $table->timestamp('terms_verified_at')->nullable()->default(null); //terminos y condiciones
            $table->unsignedInteger('node_id')->nullable(); //nodo
            $table->unsignedInteger('interlocutor_talent_id')->nullable(); //talento_interlocutor
            $table->unsignedInteger('created_by')->nullable(); //creado por
            $table->foreign('node_id')->references('id')->on('nodos')->onDelete('set null');
            $table->foreign('interlocutor_talent_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('articulation-stages');
    }
}
