<?php

use Illuminate\Database\Seeder;
use App\Models\{Entidad, IngresoVisitante};
use App\User;

class IngresoVisitanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::has('ingreso')->get()->first();
        $entidad = Entidad::has('nodo')->whereHas('nodo', function ($query) use ($user) {
            return $query->where('id', $user->ingreso->nodo_id);
        })->first();
        factory(IngresoVisitante::class, 200)->create([
            'nodo_id'    => $entidad->nodo->id,
        ]);
        factory(IngresoVisitante::class, 400)->create();
    }
}
