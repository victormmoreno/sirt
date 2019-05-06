<?php

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServiciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servicio::create([
            'id'          => 1,
            'nombre'      => 'Acompañamiento de proyecto',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 2,
            'nombre'      => 'Charla informativa',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 3,
            'nombre'      => 'EDT',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 4,
            'nombre'      => 'Entrenamiento',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 5,
            'nombre'      => 'Inducción',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 6,
            'nombre'      => 'CSIBT',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 7,
            'nombre'      => 'Reuniones TPC',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 8,
            'nombre'      => 'APROPIATEC',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 9,
            'nombre'      => 'Visitas a Tecnoparque',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 10,
            'nombre'      => 'Acompañamiento Empresa',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 11,
            'nombre'      => 'Semillero SENA',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 12,
            'nombre'      => 'Semillero Otra Institución',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 13,
            'nombre'      => 'Emprendimiento',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 14,
            'nombre'      => 'Visita Internacional',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 15,
            'nombre'      => 'Video Conferencia',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 16,
            'nombre'      => 'Charla Contrato de Aprendizaje',
            'descripcion' => '',
        ]);

        Servicio::create([
            'id'          => 17,
            'nombre'      => 'Trabajo en Proyecto',
            'descripcion' => '',
        ]);

        // factory(Servicio::class, 20)->create();

    }
}
