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
        ]);

        Servicio::create([
            'id'          => 2,
            'nombre'      => 'Charla informativa',
        ]);

        Servicio::create([
            'id'          => 3,
            'nombre'      => 'EDT',
        ]);

        Servicio::create([
            'id'          => 4,
            'nombre'      => 'Entrenamiento',
        ]);

        Servicio::create([
            'id'          => 5,
            'nombre'      => 'Inducción',
        ]);

        Servicio::create([
            'id'          => 6,
            'nombre'      => 'CSIBT',
        ]);

        Servicio::create([
            'id'          => 7,
            'nombre'      => 'Reuniones TPC',
        ]);

        Servicio::create([
            'id'          => 8,
            'nombre'      => 'APROPIATEC',
        ]);

        Servicio::create([
            'id'          => 9,
            'nombre'      => 'Visitas a Tecnoparque',
        ]);

        Servicio::create([
            'id'          => 10,
            'nombre'      => 'Acompañamiento Empresa',
        ]);

        Servicio::create([
            'id'          => 11,
            'nombre'      => 'Semillero SENA',
        ]);

        Servicio::create([
            'id'          => 12,
            'nombre'      => 'Semillero Otra Institución',
        ]);

        Servicio::create([
            'id'          => 13,
            'nombre'      => 'Emprendimiento',
        ]);

        Servicio::create([
            'id'          => 14,
            'nombre'      => 'Visita Internacional',
        ]);

        Servicio::create([
            'id'          => 15,
            'nombre'      => 'Video Conferencia',
        ]);

        Servicio::create([
            'id'          => 16,
            'nombre'      => 'Charla Contrato de Aprendizaje',
        ]);

        Servicio::create([
            'id'          => 17,
            'nombre'      => 'Trabajo en Proyecto',
        ]);


    }
}
