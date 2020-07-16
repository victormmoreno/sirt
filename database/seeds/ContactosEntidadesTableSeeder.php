<?php

use App\Models\{ContactoEntidad, Entidad};
use App\User;
use Illuminate\Database\Seeder;

class ContactosEntidadesTableSeeder extends Seeder
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
        factory(ContactoEntidad::class, 300)->create([
            'nodo_id'         => $entidad->nodo->id,
        ]);
        factory(ContactoEntidad::class, 400)->create();
    }
}
