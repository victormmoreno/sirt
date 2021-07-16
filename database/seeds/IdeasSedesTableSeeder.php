<?php

use Illuminate\Database\Seeder;
use App\Models\{Idea, Empresa};

class IdeasSedesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ideas = Idea::where('empresa_id', '!=', 'null')->get();
        foreach ($ideas as $key => $idea) {
            if ($idea->empresa_id != null) {
                $empresa = Empresa::find($idea->empresa_id);
                $idea->update([
                    'sede_id' => $empresa->sedes->first()->id
                ]);
                $empresa->update([
                    'user_id' => $idea->talento->user->id
                ]);
            }
        }
    }
}
