<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * the attribute that names the table.
     *
     * @var string
     */
    protected $tableName = 'password_resets';

    /**
     * Run the migrations.
     * @table password_resets
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('email', 191);
            $table->string('token', 191);
            $table->timestamp('created_at')->nullable()->default(null);

            $table->index(["email"], 'password_resets_email_index');
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
