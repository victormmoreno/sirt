<?php

use Illuminate\Database\Seeder;
use App\Models\Proyecto;

class AddProyectoToTalentosProyectoTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proyectos = Proyecto::all();
        foreach ($proyectos as $key1 => $proyecto) {
            $id = $proyecto->id;
            foreach ($proyecto->articulacion_proyecto->talentos as $key => $talento) {
                DB::table('proyecto_talento')->insert(
                    [
                        'proyecto_id' => $id, 
                        'talento_id' => $talento->id,
                        'talento_lider' => $talento->pivot->talento_lider,
                        'created_at' => $talento->pivot->created_at,
                        'updated_at' => $talento->pivot->updated_at
                    ]
                );
            }
        }
    }
}
