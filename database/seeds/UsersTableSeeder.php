<?php

use App\Models\Ocupacion;
use App\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = Role::all();
        $ocupaciones = Ocupacion::all()->random();

        //user-prueba
        factory(App\User::class, 1)->create([
            'nombres' => 'usuario',
            'apellidos' => 'de prueba',
            'email' => 'usuario@prueba.com',
            'password' => 'tecnoparque',
            'estado' => User::IsActive(),
            'deleted_at' => null,
        ])
            ->each(function ($user) use ($ocupaciones) {
                $user->assignRole([Role::findByName(config('laravelpermission.roles.roleAdministrador'))]);

                $dinamizador = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleDinamizador'))]);
                if ($dinamizador !== null) {
                    $user->dinamizador()->save(factory(App\Models\Dinamizador::class)->make());
                }
                $gestor = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleGestor'))]);
                if ($gestor !== null) {
                    $user->gestor()->save(factory(App\Models\Gestor::class)->make());
                }

                $infocenter = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleInfocenter'))]);
                if ($infocenter !== null) {
                    $user->infocenter()->save(factory(App\Models\Infocenter::class)->make());
                }

                $talento = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleTalento'))]);
                if ($talento !== null) {
                    $user->talento()->save(factory(App\Models\Talento::class)->make());
                }

                $ingreso = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleIngreso'))]);
                if ($ingreso !== null) {
                    $user->ingreso()->save(factory(App\Models\Ingreso::class)->make());
                }

                $user->assignRole([Role::findByName(config('laravelpermission.roles.roleDesarrollador'))]);

                $user->ocupaciones()->sync($ocupaciones);
            });

        //administradores
        factory(App\User::class, 20)->create()
            ->each(function ($user) use ($ocupaciones) {
                $user->assignRole([Role::findByName(config('laravelpermission.roles.roleAdministrador'))]);
                $user->ocupaciones()->sync($ocupaciones);
            });
        //dinamzadores
        factory(App\User::class, 20)->create()
            ->each(function ($user) use ($ocupaciones) {
                $dinamizador = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleDinamizador'))]);
                if ($dinamizador !== null) {
                    $user->dinamizador()->save(factory(App\Models\Dinamizador::class)->make());
                }
                $user->ocupaciones()->sync($ocupaciones);
            });


        //gestores
        factory(App\User::class, 300)->create()
            ->each(function ($user) use ($ocupaciones) {
                $gestor = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleGestor'))]);
                if ($gestor !== null) {
                    $user->gestor()->save(factory(App\Models\Gestor::class)->make());
                }
                $user->ocupaciones()->sync($ocupaciones);
            });

        //infocenters
        factory(App\User::class, 40)->create()
            ->each(function ($user) use ($ocupaciones) {
                $infocenter = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleInfocenter'))]);
                if ($infocenter !== null) {
                    $user->infocenter()->save(factory(App\Models\Infocenter::class)->make());
                }
                $user->ocupaciones()->sync($ocupaciones);
            });

        //talentos
        factory(App\User::class, 600)->create()
            ->each(function ($user) use ($ocupaciones) {
                $talento = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleTalento'))]);
                if ($talento !== null) {
                    $user->talento()->save(factory(App\Models\Talento::class)->make());
                }
                $user->ocupaciones()->sync($ocupaciones);
            });

        factory(App\User::class, 15)->create()
            ->each(function ($user) use ($ocupaciones) {
                $ingreso = $user->assignRole([Role::findByName(config('laravelpermission.roles.roleIngreso'))]);
                if ($ingreso !== null) {
                    $user->ingreso()->save(factory(App\Models\Ingreso::class)->make());
                }
                $user->ocupaciones()->sync($ocupaciones);
            });

        factory(App\User::class, 5)->create()
            ->each(function ($user) use ($ocupaciones) {
                $user->assignRole([Role::findByName(config('laravelpermission.roles.roleDesarrollador'))]);
                $user->ocupaciones()->sync($ocupaciones);
            });
    }
}
