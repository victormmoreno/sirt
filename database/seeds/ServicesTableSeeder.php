<?php

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'idservicio'  => 1,
            'nombre'      => 'Acompañamiento de proyecto',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 2,
            'nombre'      => 'Charla informativa',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 3,
            'nombre'      => 'EDT',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 4,
            'nombre'      => 'Entrenamiento',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 5,
            'nombre'      => 'Inducción',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 6,
            'nombre'      => 'CSIBT',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 7,
            'nombre'      => 'Reuniones TPC',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 8,
            'nombre'      => 'APROPIATEC',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 9,
            'nombre'      => 'Visitas a Tecnoparque',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 10,
            'nombre'      => 'Acompañamiento Empresa',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 11,
            'nombre'      => 'Semillero SENA',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 12,
            'nombre'      => 'Semillero Otra Institución',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 13,
            'nombre'      => 'Emprendimiento',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 14,
            'nombre'      => 'Visita Internacional',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 15,
            'nombre'      => 'Video Conferencia',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 16,
            'nombre'      => 'Charla Contrato de Aprendizaje',
            'descripcion' => '',
        ]);

        Service::create([
            'idservicio'  => 17,
            'nombre'      => 'Trabajo en Proyecto',
            'descripcion' => '',
        ]);
    }
}
