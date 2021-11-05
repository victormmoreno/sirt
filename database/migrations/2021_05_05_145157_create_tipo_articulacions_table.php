<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\TipoArticulacion;

class CreateTipoArticulacionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $tableName = 'tipo_articulaciones';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('nombre', 100)->unique();
            $table->string('descripcion',5000)->nullable();
            $table->string('entidad', 100)->nullable();
            $table->enum('estado', [TipoArticulacion::mostrar(),TipoArticulacion::ocultar()])->default(TipoArticulacion::mostrar());
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
