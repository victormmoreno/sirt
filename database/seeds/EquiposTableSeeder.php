<?php

use App\Models\{Entidad, Equipo, EquipoMantenimiento};
use App\User;
use Illuminate\Database\Seeder;

class EquiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::has('gestor')->get()->first();
        $entidad = Entidad::has('nodo')->whereHas('nodo', function ($query) use ($user) {
            return $query->where('id', $user->gestor->nodo_id);
        })->first();

        factory(Equipo::class, 100)->create([
            'nodo_id'             => $entidad->nodo->id,
            'lineatecnologica_id' => $entidad->nodo->lineas->random()->id,
        ])->each(function ($equipo) {
            $equipo->equiposmantenimientos()->saveMany([factory(EquipoMantenimiento::class)->make()]);
        });

        factory(Equipo::class, 400)->create()
            ->each(function ($equipo) {
                $equipo->equiposmantenimientos()->saveMany([factory(EquipoMantenimiento::class)->make()]);
            });
    }
}
