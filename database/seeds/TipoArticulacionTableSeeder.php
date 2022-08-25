<?php

use App\Models\ArticulationType;
use App\Models\Nodo;
use Illuminate\Database\Seeder;

class TipoArticulacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nodes = Nodo::first();
        factory(ArticulationType::class, 10)->create()
        ->each(function ($type) use ($nodes) {
            $type->nodos()->sync($nodes->id);
        });
    }
}
