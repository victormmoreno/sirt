<?php

use App\Models\{Actividad, Articulacion,  ArticulacionProyecto, Edt, Equipo, Entidad,  Gestor, Material,  ObjetivoEspecifico, Proyecto, Producto, UsoInfraestructura};
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
        $userGestor = User::has('gestor')->whereHas('gestor', function ($query) use ($gestor) {
            return $query->where('nodo_id', $gestor->nodo_id);
        })->get()->random();
        $entidad = Entidad::has('nodo')->whereHas('nodo', function ($query) use ($gestor) {
            return $query->where('id', $gestor->nodo_id);
        })->first();

        $equipos = Equipo::has('nodo')->whereHas('nodo', function ($query) use ($gestor) {
            return $query->where('id', $gestor->nodo_id);
        })->get()->random();

        $materiales = Material::has('nodo')->whereHas('nodo', function ($query) use ($gestor) {
            return $query->where('id', $gestor->nodo_id);
        })->get()->random();

        //proyectos
        factory(Actividad::class, 20)->create([])
            ->each(function ($actividad) use ($user, $entEmpresa, $entGrupoInvestigacion, $userGestor, $equipos, $materiales) {
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
                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsProyecto(),
                ]));
                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsProyecto(),
                ]));
                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsProyecto(),
                ]));

                $actividad->usoinfraestructuras->each(function ($uso) use ($userGestor) {
                    $uso->usogestores()->sync($userGestor->gestor->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($user) {
                    $uso->usotalentos()->sync($user->talento->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($equipos) {
                    $uso->usoequipos()->sync($equipos->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($materiales) {
                    $uso->usomateriales()->sync($materiales->id);
                });
            });
        factory(Actividad::class, 200)->create()
            ->each(function ($actividad) use ($user, $entEmpresa, $entGrupoInvestigacion, $userGestor, $equipos, $materiales) {
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
                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsProyecto(),
                ]));
                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsProyecto(),
                ]));
                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsProyecto(),
                ]));

                $actividad->usoinfraestructuras->each(function ($uso) use ($userGestor) {
                    $uso->usogestores()->sync($userGestor->gestor->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($user) {
                    $uso->usotalentos()->sync($user->talento->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($equipos) {
                    $uso->usoequipos()->sync($equipos->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($materiales) {
                    $uso->usomateriales()->sync($materiales->id);
                });
            });

        // //articulaciones gi
        $productos = Producto::all()->random();

        factory(Actividad::class, 50)->create([
            'gestor_id' => $gestor->id,
            'nodo_id' => $entidad->nodo->id,
        ])
            ->each(function ($actividad) use ($user, $entGrupoInvestigacion, $productos, $userGestor, $equipos, $materiales) {

                $actividad->articulacion_proyecto()->save(factory(ArticulacionProyecto::class)->make([
                    'entidad_id' => $entGrupoInvestigacion->grupoinvestigacion->id,
                ]));
                $actividad->articulacion_proyecto->articulacion()->save(factory(Articulacion::class)->make());
                $actividad->articulacion_proyecto->talentos()->sync($user->talento->id);
                $actividad->articulacion_proyecto->articulacion->productos()->sync($productos->id);

                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsArticulacion(),
                ]));


                $actividad->usoinfraestructuras->each(function ($uso) use ($userGestor) {
                    $uso->usogestores()->sync($userGestor->gestor->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($user) {
                    $uso->usotalentos()->sync($user->talento->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($equipos) {
                    $uso->usoequipos()->sync($equipos->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($materiales) {
                    $uso->usomateriales()->sync($materiales->id);
                });
            });

        factory(Actividad::class, 50)->create()
            ->each(function ($actividad) use ($user, $entGrupoInvestigacion, $productos, $userGestor, $equipos, $materiales) {

                $actividad->articulacion_proyecto()->save(factory(ArticulacionProyecto::class)->make([
                    'entidad_id' => $entGrupoInvestigacion->grupoinvestigacion->id,
                ]));
                $actividad->articulacion_proyecto->articulacion()->save(factory(Articulacion::class)->make());
                $actividad->articulacion_proyecto->talentos()->sync($user->talento->id);
                $actividad->articulacion_proyecto->articulacion->productos()->sync($productos->id);

                $actividad->usoinfraestructuras()->save(factory(UsoInfraestructura::class)->make([
                    'tipo_usoinfraestructura' => UsoInfraestructura::IsArticulacion(),
                ]));


                $actividad->usoinfraestructuras->each(function ($uso) use ($userGestor) {
                    $uso->usogestores()->sync($userGestor->gestor->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($user) {
                    $uso->usotalentos()->sync($user->talento->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($equipos) {
                    $uso->usoequipos()->sync($equipos->id);
                });

                $actividad->usoinfraestructuras->each(function ($uso) use ($materiales) {
                    $uso->usomateriales()->sync($materiales->id);
                });
            });

        //edts
        factory(Actividad::class, 50)->create([])->each(function ($actividad) use ($entEmpresa) {

            $actividad->edt()->save(factory(Edt::class)->make());
            $actividad->edt->entidades()->sync($entEmpresa->empresa->id);
            $actividad->edt->entidades()->sync($entEmpresa->empresa->id);
        });

        factory(Actividad::class, 50)->create()
            ->each(function ($actividad) use ($entEmpresa) {
                $actividad->edt()->save(factory(Edt::class)->make());
                $actividad->edt->entidades()->sync($entEmpresa->empresa->id);
                $actividad->edt->entidades()->sync($entEmpresa->empresa->id);
            });
    }
}
