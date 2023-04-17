<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTablesUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('contratistas');
        Schema::dropIfExists('articulacion_pbts');
        Schema::dropIfExists('nodo_tipoarticulacion');
        Schema::dropIfExists('articulaciones_pbt_talento');
        Schema::dropIfExists('tipo_articulaciones');
        Schema::dropIfExists('infocenter');
        Schema::dropIfExists('dinamizador');
        Schema::dropIfExists('publicaciones');
        Schema::dropIfExists('contactosentidades');
        Schema::dropIfExists('noticias');
        Schema::dropIfExists('servidor_videos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
