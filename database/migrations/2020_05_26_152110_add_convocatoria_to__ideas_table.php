<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConvocatoriaToIdeasTable extends Migration
{
    public $tableName = 'ideas';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->tinyInteger('viene_convocatoria')->default(0)->after('alcance');
            $table->string('convocatoria', 100)->nullable()->default(null)->after('viene_convocatoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['viene_convocatoria']);
            $table->dropColumn(['convocatoria']);
        });
    }
}
