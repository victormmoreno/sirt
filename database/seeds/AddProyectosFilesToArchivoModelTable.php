<?php

use Illuminate\Database\Seeder;
use App\Models\Proyecto;
use App\Models\ArchivoArticulacionProyecto;

class AddProyectosFilesToArchivoModelTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $class = Proyecto::class;
            $proyectos = Proyecto::all();
            foreach ($proyectos as $key => $proyecto) {
                $archivos = ArchivoArticulacionProyecto::where('articulacion_proyecto_id', $proyecto->articulacion_proyecto_id)->get();
                foreach ($archivos as $key => $archivo) {
                    DB::table('archivo_model')->insert(
                        [
                            'model_id' => $proyecto->id, 
                            'model_type' => $class,
                            'ruta' => $archivo->ruta,
                            'fase_id' => $archivo->fase_id,
                            'created_at' => $archivo->created_at,
                            'updated_at' => $archivo->updated_at
                        ]
                    );
                }
                // DB::table('archivos_articulacion_proyecto')->where('articulacion_proyecto_id', $proyecto->articulacion_proyecto->id)->delete();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
