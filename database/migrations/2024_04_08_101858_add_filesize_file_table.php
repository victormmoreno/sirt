<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilesizeFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archivo_model', function (Blueprint $table) {
            $table->unsignedBigInteger('filesize')->nullable()->default(null)->after('fase_id');
        });
        Schema::table('ruta_model', function (Blueprint $table) {
            $table->unsignedBigInteger('filesize')->nullable()->default(null)->after('model_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archivo_model', function (Blueprint $table) {
            $table->dropColumn(['filesize']);
        });
        Schema::table('ruta_model', function (Blueprint $table) {
            $table->dropColumn(['filesize']);
        });
    }
}
