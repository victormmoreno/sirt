<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosedtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivosedt', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('edt_id');
            $table->string('ruta',1000);
            $table->timestamps();

            $table->index(["edt_id"], 'fk_archivosedt_edts1_idx');

            $table->unique(["ruta"], 'ruta_UNIQUE');

            $table->foreign('edt_id', 'fk_archivosedt_edts1_idx')
            ->references('id')->on('edts')
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
        Schema::dropIfExists('archivosedt');
    }
}
