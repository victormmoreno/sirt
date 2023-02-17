<?php

use Illuminate\Database\Seeder;
use App\Models\ArticulationType;

class ArticulationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ArticulationType::class)->create([
            'name' => 'Propiedad Intelectual'
        ]);

        factory(ArticulationType::class)->create([
            'name' => 'Formalización de empresa o producto'
        ]);

        factory(ArticulationType::class)->create([
            'name' => 'Fortalecimiento a PBT'
        ]);

        factory(ArticulationType::class)->create([
            'name' => 'Articulacion con empresas'
        ]);
    }
}
