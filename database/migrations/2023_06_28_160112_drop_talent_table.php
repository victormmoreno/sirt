<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTalentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        // Schema::table('talentos', function (Blueprint $table) {
        //     DB::statement('ALTER TABLE talentos DROP INDEX fk_talentos_entidades1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP FOREIGN KEY fk_talentos_entidades1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP FOREIGN KEY fk_talentos_user1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP INDEX fk_talentos_user1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP FOREIGN KEY fk_tipo_estudio_id_talentos_1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP INDEX fk_tipo_estudio_id_talentos_1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP FOREIGN KEY fk_tipo_formacion_id_talentos_1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP INDEX fk_tipo_formacion_id_talentos_1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP FOREIGN KEY fk_tipo_talento_id_talentos_1_idx;');
        //     DB::statement('ALTER TABLE talentos DROP INDEX fk_tipo_talento_id_talentos_1_idx;');
        //     $table->dropColumn(['entidad_id', 'tipo_talento_id', 'tipo_formacion_id', 'tipo_estudio_id']);
        // });
        Schema::dropIfExists('talentos');
        Schema::enableForeignKeyConstraints();


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
