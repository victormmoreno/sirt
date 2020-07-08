<?php

use Illuminate\Database\Seeder;
use App\Models\CharlaInformativa;

class CharlasInformativasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CharlaInformativa::class, 100)->create();
    }
}
