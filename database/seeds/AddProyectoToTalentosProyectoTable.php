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
        $articulacion_proyecto_talento = DB::table('articulacion_proyecto_talento')->select('*')->get();
        foreach ($articulacion_proyecto_talento as $key => $talento) {
            $proyecto = Proyecto::select('proyectos.id')->join('articulacion_proyecto', 'articulacion_proyecto.id', '=', 'proyectos.articulacion_proyecto_id')->where('articulacion_proyecto_id', $talento->articulacion_proyecto_id)->first();
            if ($proyecto != null) {
                DB::table('proyecto_talento')->insert(
                    [
                        'proyecto_id' => $proyecto->id, 
                        'talento_id' => $talento->talento_id,
                        'talento_lider' => $talento->talento_lider,
                        'created_at' => $talento->created_at,
                        'updated_at' => $talento->updated_at
                    ]
                );
            }
        }
    }
}
