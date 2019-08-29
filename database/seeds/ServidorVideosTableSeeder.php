<?php

use App\Models\ServidorVideo;
use Illuminate\Database\Seeder;

class ServidorVideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServidorVideo::create([
            'nombre'      => 'YouTube',
            'dominio' => 'youtube.com',
        ]);

        ServidorVideo::create([
            'nombre'      => 'Vimeo',
            'dominio' => 'vimeo.com',
        ]);
    }
}
