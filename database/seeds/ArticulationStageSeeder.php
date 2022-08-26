<?php

use Illuminate\Database\Seeder;
use App\Models\ArticulationStage;
use App\Models\Articulation;
use App\Models\ArticulationType;
use App\Models\ArticulationSubtype;
use App\Models\AlcanceArticulacion;
use App\Models\Proyecto;
Use App\User;

class ArticulationStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(AlcanceArticulacion::class, 4)->create();
        factory(ArticulationType::class, 10)->create()
            ->each(function($articulationType){
                factory(ArticulationSubtype::class, 10)->create([
                    'articulation_type_id' => $articulationType->id
                ]);
            });
        factory(ArticulationStage::class, 40)->create()
            ->each(function($articulationStage){
                factory(Articulation::class, 3)->create([
                    'articulation_stage_id' => $articulationStage->id,
                ])
                ->each(function($articulation){
                    $articulation->users()->sync([
                        'user_id' => User::has('talento')->get()->random()->id
                    ]);
                });
                $articulationStage->projects()->sync([
                    'articulationable_id' => Proyecto::whereHas('fase', function ($query) use($articulationStage) {
                            return $query->whereIn('nombre', [
                                    Proyecto::IS_EJECUCION,
                                    Proyecto::IS_CIERRE,
                                    Proyecto::IS_FINALIZADO
                                ]);
                        })->get()->random()->id
                ]);
            });

    }


}
