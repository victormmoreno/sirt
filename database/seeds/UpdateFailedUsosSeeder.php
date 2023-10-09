<?php

use App\Models\{Proyecto, Articulation, Idea};
use Illuminate\Database\Seeder;
use App\Models\UsoInfraestructura;
use App\Repositories\Repository\Articulation\ArticulationRepository;
use App\Repositories\Repository\AsesorieRepository;
use App\Repositories\Repository\ProyectoRepository;
use Illuminate\Http\Request;

class UpdateFailedUsosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $art = new ArticulationRepository;
        $desde = '2023-06-01';
        $hasta = '2023-09-10';
        $pro = new ProyectoRepository();
        $proyectos = Proyecto::class;
        $articulations = Articulation::class;
        $ideas = Idea::class;
        $asesorieRepository = new AsesorieRepository($pro, $art);


        $asesorias_proyecto = UsoInfraestructura::select('usoinfraestructuras.id')
        ->join('proyectos as p', function($q) use ($proyectos) {$q->on('p.id', '=', 'usoinfraestructuras.asesorable_id')->where('asesorable_type', "$proyectos");})
        ->join('fases as f', 'f.id', '=', 'p.fase_id')
        ->whereNotIn('f.nombre', ['Finalizado', 'Cancelado'])
        ->whereBetween('usoinfraestructuras.created_at', [$desde, $hasta])
        ->get();
        foreach ($asesorias_proyecto as $key => $asesoria) {
            $this->ejecutar($asesoria, $asesorieRepository);
        }
        echo '--------------------------------------------------------------------------------\n';
        echo 'Articulaciones';
        $asesorias_articulaciones = UsoInfraestructura::select('usoinfraestructuras.id')
        ->join('articulations as p', function($q) use ($articulations) {$q->on('p.id', '=', 'usoinfraestructuras.asesorable_id')->where('asesorable_type', "$articulations");})
        ->whereBetween('usoinfraestructuras.created_at', [$desde, $hasta])
        ->get();
        foreach ($asesorias_articulaciones as $key => $asesoria) {
            $this->ejecutar($asesoria, $asesorieRepository);
        }
        echo '--------------------------------------------------------------------------------';
        echo 'Ideas';
        $asesorias_ideas = UsoInfraestructura::select('usoinfraestructuras.id')
        ->join('ideas as p', function($q) use ($ideas) {$q->on('p.id', '=', 'usoinfraestructuras.asesorable_id')->where('asesorable_type', "$ideas");})
        ->whereBetween('usoinfraestructuras.created_at', [$desde, $hasta])
        ->get();
        foreach ($asesorias_ideas as $key => $asesoria) {
            $this->ejecutar($asesoria, $asesorieRepository);
        }
        // echo $asesorias_proyecto->count() . " \n" . $asesorias_articulaciones->count() . " \n" . $asesorias_ideas->count();
    }

    public function ejecutar($asesoria, $asesorieRepository)
    {
        $id = $asesoria->id;
        $usoinfraestructura = UsoInfraestructura::findOrFail($id);
        $talentos = array();
        $asesores = array();
        $asesorias_directas = array();
        $asesorias_indirectas = array();
        $materiales = array();
        $cantidades = array();
        $equipos = array();
        $tiempos = array();
        $request = new Request;
        foreach ($usoinfraestructura->participantes as $key => $talento) {
            $talentos[$key] = $talento->id;
        }
        $request->merge(['talento' => $talentos]);

        foreach ($usoinfraestructura->asesores as $key2 => $asesor) {
            $asesores[$key2] = $asesor->id;
            $asesorias_directas[$key2] = $asesor->pivot->asesoria_directa;
            $asesorias_indirectas[$key2] = $asesor->pivot->asesoria_indirecta;
        }
        $request->merge(['gestor' => $asesores]);
        $request->merge(['asesoriadirecta' => $asesorias_directas]);
        $request->merge(['asesoriaindirecta' => $asesorias_indirectas]);
        
        foreach ($usoinfraestructura->usomateriales as $key3 => $material) {
            $materiales[$key3] = $material->id;
            $cantidades[$key3] = $material->pivot->unidad;
        }
        $request->merge(['material' => $materiales]);
        $request->merge(['cantidad' => $cantidades]);

        foreach ($usoinfraestructura->usoequipos as $key4 => $equipo) {
            $equipos[$key4] = $equipo->id;
            $tiempos[$key4] = $equipo->pivot->tiempo;
        }
        $request->merge(['equipo' => $equipos]);
        $request->merge(['tiempouso' => $tiempos]);

        $request->merge([
            'txtfecha' => $usoinfraestructura->fecha,
            'txtdescripcion' => $usoinfraestructura->descripcion,
            'txtcompromisos' => $usoinfraestructura->compromisos,
            'asesoria_directa' => 0,
            'asesoria_indirecta' => 0,
        ]);
    
        $result = $asesorieRepository->update($request, $id);

        if (!$result) {
            echo "Fallado: " . $usoinfraestructura->codigo . "\n";
        }   
    }
}
