<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'talentos';

    /**
     * Run the migrations.
     * @table talentos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('universidad', 200)->nullable()->default(null);
            $table->string('programa_formacion', 100)->default('No Aplica');
            $table->string('carrera_universitaria', 100)->default('No Aplica');
            $table->string('empresa', 200)->nullable()->default(null);

            $table->index(["user_id"], 'fk_talentos_user1_idx');
            $table->nullableTimestamps();

            $table->foreign('user_id', 'fk_talentos_user1_idx')
                ->references('id')->on('users')
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
       Schema::dropIfExists($this->tableName);
     }
}
