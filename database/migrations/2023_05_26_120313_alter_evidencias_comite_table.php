<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterEvidenciasComiteTable extends Migration
{
    public $tableName = 'comites';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $output = new ConsoleOutput();
        $output->writeln('<info>Cambiando campos de comites</info>');
        DB::beginTransaction();
        try {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->tinyInteger('acta')->default(0)->after('listado_asistencia');
                $table->tinyInteger('formato_evaluacion')->default(0)->after('acta');
                $table->dropColumn(['correos']);
            });
            $output->writeln('<info>Se actualizó la estructura de la tabla de comites</info>');
            DB::commit();
        } catch (\Exception $ex) {
            $output->writeln('<info>Error: '.$ex->getMessage().'</info>');
            DB::rollback();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->dropColumn(['acta']);
            $table->dropColumn(['formato_evaluacion']);
            $table->tinyInteger('correos')->default(0)->after('observaciones');
        });
    }
}
