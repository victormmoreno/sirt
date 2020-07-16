<?php

use Illuminate\Database\Seeder;
use App\Models\{Idea, Entidad};
use App\User;

class IdeasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::has('infocenter')->get()->first();
        $entidad = Entidad::has('nodo')->whereHas('nodo', function ($query) use ($user) {
            return $query->where('id', $user->infocenter->nodo_id);
        })->first();
        factory(Idea::class, 70)->create([
            'nodo_id' => $entidad->nodo->id,
        ]);
        factory(Idea::class, 1500)->create();
    }
}
