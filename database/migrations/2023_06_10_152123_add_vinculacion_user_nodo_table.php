<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVinculacionUserNodoTable extends Migration
{
    public $tableName = 'user_nodo';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            if (!Schema::hasColumn('user_nodo','vinculacion'))
            {
                $table->tinyInteger('vinculacion')->default('0')->after('role');
            }
            DB::statement('ALTER TABLE user_nodo MODIFY COLUMN nodo_id int null');
            DB::statement('ALTER TABLE user_nodo MODIFY COLUMN honorarios DOUBLE(15,2);');
            DB::statement('ALTER TABLE articulations MODIFY COLUMN start_date TIMESTAMP NULL;');
            DB::statement('ALTER TABLE articulation_stages MODIFY COLUMN start_date TIMESTAMP NULL;');
        });


        Schema::table('contratos', function (Blueprint $table) {
            if (Schema::hasColumn('contratos','vinculacion'))
            {
                $table->dropColumn(['vinculacion']);
            }
            DB::statement('ALTER TABLE contratos MODIFY COLUMN valor_contrato DOUBLE(20,2);');
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
            $table->dropColumn(['vinculacion']);
        });
    }
}
