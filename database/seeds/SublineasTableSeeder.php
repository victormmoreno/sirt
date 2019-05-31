<?php


use App\Models\LineaTecnologica;
use App\Models\Sublinea;
use Illuminate\Database\Seeder;

class SublineasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sublinea::create([
            'id'                  => 1,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Biotecnología Industrial',
        ]);

        Sublinea::create([
            'id'                  => 2,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Microbiología agrícola y pecuaria',
        ]);

        Sublinea::create([
            'id'                  => 3,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Biotecnología Animal',
        ]);

        Sublinea::create([
            'id'                  => 4,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Biotecnología Vegetal',
        ]);

        Sublinea::create([
            'id'                  => 5,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Bioinformática',
        ]);

        Sublinea::create([
            'id'                  => 6,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Medio ambiente',
        ]);

        Sublinea::create([
            'id'                  => 7,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Nuevos materiales',
        ]);

        Sublinea::create([
            'id'                  => 8,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Energías verdes y biocombustibles',
        ]);

        Sublinea::create([
            'id'                  => 9,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Agroindustria alimentaria',
        ]);

        Sublinea::create([
            'id'                  => 10,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Agroindustria no alimentaria',
        ]);

        Sublinea::create([
            'id'                  => 11,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'BIO')->first()->id,
            'nombre'              => 'Nanotecnología',
        ]);

        Sublinea::create([
            'id'                  => 12,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Automatización e instrumentación',
        ]);

        Sublinea::create([
            'id'                  => 13,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Redes inteligente',
        ]);

        Sublinea::create([
            'id'                  => 14,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Robótica',
        ]);

        Sublinea::create([
            'id'                  => 15,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Sistemas embebidos',
        ]);

        Sublinea::create([
            'id'                  => 16,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Agroelectrónica',
        ]);

        Sublinea::create([
            'id'                  => 17,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Análisis de señales y protocolos',
        ]);

        Sublinea::create([
            'id'                  => 18,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Infraestructura, redes y antenas',
        ]);

        Sublinea::create([
            'id'                  => 19,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Diseño electrónico',
        ]);

        Sublinea::create([
            'id'                  => 20,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Telemática',
        ]);

        Sublinea::create([
            'id'                  => 21,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'nombre'              => 'Internet de las cosas (IoT)',
        ]);

        Sublinea::create([
            'id'                  => 22,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Productos y procesos',
        ]);

        Sublinea::create([
            'id'                  => 23,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Diseño de concepto y detalles',
        ]);

        Sublinea::create([
            'id'                  => 24,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Análisis y simulación',
        ]);

        Sublinea::create([
            'id'                  => 25,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Ingeniería inversa',
        ]);

        Sublinea::create([
            'id'                  => 26,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Mecanizado',
        ]);

        Sublinea::create([
            'id'                  => 27,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Diseño Estratégico',
        ]);

        Sublinea::create([
            'id'                  => 28,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Biomecánica',
        ]);

        Sublinea::create([
            'id'                  => 29,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Materiales',
        ]);

        Sublinea::create([
            'id'                  => 30,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Tecnificación de procesos agrícolas',
        ]);

        Sublinea::create([
            'id'                  => 31,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Aplicación de energías renovables',
        ]);

        Sublinea::create([
            'id'                  => 32,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'nombre'              => 'Sistemas para el aprovechamiento de recursos hídricos',
        ]);

        Sublinea::create([
            'id'                  => 33,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Aplicaciones Móviles',
        ]);

        Sublinea::create([
            'id'                  => 34,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Inteligencia Artificial y Big-Data',
        ]);

        Sublinea::create([
            'id'                  => 35,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Realidad Virtual y Simulación',
        ]);

        Sublinea::create([
            'id'                  => 36,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Realidad Aumentada',
        ]);

        Sublinea::create([
            'id'                  => 37,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Animación Digital',
        ]);

        Sublinea::create([
            'id'                  => 38,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Diseño y Desarrollo de Videojuegos',
        ]);

        Sublinea::create([
            'id'                  => 39,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Ingeniería de software',
        ]);

        Sublinea::create([
            'id'                  => 40,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Desarrollo de contenidos',
        ]);

        Sublinea::create([
            'id'                  => 41,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Multimediales',
        ]);

        Sublinea::create([
            'id'                  => 42,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'TV')->first()->id,
            'nombre'              => 'Geotecnología',
        ]);

    }
}
