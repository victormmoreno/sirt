<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'contacts';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ticket', 20)->unique();
            $table->string('name', 45);
            $table->string('lastname', 45);
            $table->string('document', 11);
            $table->string('email', 100);
            $table->string('phone', 11)->nullable()->default(null);
            $table->string('subject');
            $table->text('description');
            $table->enum('difficulty', ['Incidencia', 'Requerimiento']);
            $table->enum('status', ['Pendiente', 'En Espera', 'Solucionado']);
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
        Schema::dropIfExists($this->tableName);
    }
}
