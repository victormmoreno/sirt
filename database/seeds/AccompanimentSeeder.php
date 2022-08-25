<?php

use Illuminate\Database\Seeder;
use App\Models\ArticulationStage;
use App\Models\Articulation;
use App\Models\Proyecto;

class AccompanimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ArticulationStage::class, 40)->create([
            'created_by' => 6176
        ])->each(function($accompaniment){
            factory(Articulation::class, 3)->create([
                'accompaniment_id' => $accompaniment->id,
                'created_by' => 6176
            ])->each(function($articulation){
                $articulation->users()->sync([
                    'user_id' => 6176
                ]);
            });
            $accompaniment->projects()->sync([
                'accompanimentable_id' => 8842,
            ]);
        });
    }
}
