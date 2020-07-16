<?php

use App\Models\Actividad;
use App\Models\ArticulacionProyecto;
use App\Models\ObjetivoEspecifico;
use App\Models\Proyecto;
use App\Models\Gestor;
use App\Models\Entidad;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ActividadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::has('talento')->get()->random();
        $entEmpresa = Entidad::has('empresa')->get()->random();
        $entGrupoInvestigacion = Entidad::has('grupoinvestigacion')->get()->random();
        $gestor = Gestor::has('user')->get()->first();
        $entidad = Entidad::has('nodo')->whereHas('nodo', function ($query) use ($gestor) {
            return $query->where('id', $gestor->nodo_id);
        })->first();

        //proyectos
        factory(Actividad::class, 20)->create([
            'gestor_id' => $gestor->id,
            'nodo_id' => $entidad->nodo->id,
        ])
            ->each(function ($actividad) use ($user, $entEmpresa, $entGrupoInvestigacion) {
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());

                $actividad->articulacion_proyecto()->save(factory(ArticulacionProyecto::class)->make());
                $actividad->articulacion_proyecto->proyecto()->save(factory(Proyecto::class)->make());
                $actividad->articulacion_proyecto->talentos()->sync($user->talento->id);

                $actividad->articulacion_proyecto->proyecto->users_propietarios()->sync($user->talento->id);
                $actividad->articulacion_proyecto->proyecto->empresas()->sync($entEmpresa->empresa->id);
                $actividad->articulacion_proyecto->proyecto->gruposinvestigacion()->sync($entGrupoInvestigacion->grupoinvestigacion->id);
            });
        factory(Actividad::class, 200)->create()
            ->each(function ($actividad) use ($user, $entEmpresa, $entGrupoInvestigacion) {
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());
                $actividad->objetivos_especificos()->save(factory(ObjetivoEspecifico::class)->make());

                $actividad->articulacion_proyecto()->save(factory(ArticulacionProyecto::class)->make());
                $actividad->articulacion_proyecto->proyecto()->save(factory(Proyecto::class)->make());
                $actividad->articulacion_proyecto->talentos()->sync($user->talento->id);

                $actividad->articulacion_proyecto->proyecto->users_propietarios()->sync($user->talento->id);
                $actividad->articulacion_proyecto->proyecto->empresas()->sync($entEmpresa->empresa->id);
                $actividad->articulacion_proyecto->proyecto->gruposinvestigacion()->sync($entGrupoInvestigacion->grupoinvestigacion->id);
            });

        //articulaciones gi
        // factory(Actividad::class, 50)->create()
        //     ->each(function ($actividad) use ($user, $entEmpresa, $entGrupoInvestigacion) {


        //         $actividad->articulacion_proyecto()->save(factory(ArticulacionProyecto::class)->make());
        //         $actividad->articulacion_proyecto->articulacion()->save(factory(ArticulacionProyecto::class)->make());

        //     });

    }
}
