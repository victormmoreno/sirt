<?php

use Illuminate\Database\Seeder;
use App\Models\{Entidad, Material};
use App\User;

class MaterialesTableSeeder extends Seeder
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

        factory(Material::class, 100)->create([
            'nodo_id'             => $entidad->nodo->id,
            'lineatecnologica_id' => $entidad->nodo->lineas->random()->id,
        ]);
        
        factory(Material::class, 600)->create();
    }
}
