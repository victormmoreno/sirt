<?php

namespace App\Repositories\Repository;

use Illuminate\Support\Facades\DB;

abstract class Repository
{
    /**
     * Método para traducir los meses que genera algunos querys
     *
     * @return void
     * @author dum
     */
    public function traducirMeses()
    {
        DB::statement("SET lc_time_names = 'es_ES'");
    }
}
