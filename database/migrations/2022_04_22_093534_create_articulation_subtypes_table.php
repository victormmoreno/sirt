<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ArticulationSubtype;

class CreateArticulationSubtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulation_subtypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 600)->unique();
            $table->string('description',5000)->nullable();
            $table->json('entity')->nullable();
            $table->enum('state', [ArticulationSubtype::mostrar(),ArticulationSubtype::ocultar()])->default(ArticulationSubtype::mostrar());
            $table->unsignedBigInteger('articulation_type_id')->nullable();
            $table->foreign('articulation_type_id')->references('id')->on('articulation_types');
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
        Schema::dropIfExists('articulation_subtypes');
    }
}
