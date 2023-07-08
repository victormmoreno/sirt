<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CostoAdministrativo;
use App\Models\Nodo;
use Carbon\Carbon;

class CreateCostoAdministrativoForYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'costoadministrativo:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create costo administrativo for year';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $costos = CostoAdministrativo::all();
        $nodos = Nodo::all();

        if (!$costos->isEmpty() && !$nodos->isEmpty()) {
            $syncData = [];
            foreach ($costos as $id => $value) {
                $syncData[$id] = ['costo_administrativo_id' => $value->id,  'anho' => Carbon::now()->year, 'valor' => 0];
            }

            foreach ($nodos as $key => $nodo) {
                $nodo->costoadministrativonodo()->attach($syncData);
            }
        }
    }
}
