<?php

use Illuminate\Database\Seeder;
use App\Models\Publicacion;

class PublicacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Publicacion::class, 50)->create();
    }
}
