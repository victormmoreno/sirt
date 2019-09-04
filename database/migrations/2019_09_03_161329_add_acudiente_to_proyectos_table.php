<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcudienteToProyectosTable extends Migration
{
  public $tableName = 'proyectos';
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table($this->tableName, function (Blueprint $table) {
      $table->string('cedula_acudiente', 20)->nullable()->default('')->after('aporte_talento');
      $table->string('nombre_acudiente', 60)->nullable()->default('')->after('cedula_acudiente');
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
      $this->dropColumn(['cedula_acudiente', 'nombre_acudiente']);
    });
  }
}
