<?php

use App\Models\TIpoVisitante;
use Illuminate\Database\Seeder;

class TiposVisitanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipovisitante::create([
            'idtipovisitante' => 1,
            'nombre'          => 'Aprendiz SENA',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 2,
            'nombre'          => 'Gestor T1',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 3,
            'nombre'          => 'Infocenter',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 4,
            'nombre'          => 'Instructor SENA',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 5,
            'nombre'          => 'Media Técnica',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 6,
            'nombre'          => 'Talento',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 7,
            'nombre'          => 'Universitario',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 8,
            'nombre'          => 'Visitante/Otro',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 9,
            'nombre'          => 'Gestor T2',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 10,
            'nombre'          => 'Empresario',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 11,
            'nombre'          => 'Soporte Sistemas- Enlace',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 12,
            'nombre'          => 'SIN CARGO',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 13,
            'nombre'          => 'Semillero Investigador',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 14,
            'nombre'          => 'Empleado',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 15,
            'nombre'          => 'Instructor/Otra',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 16,
            'nombre'          => 'SENNOVA',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 17,
            'nombre'          => 'Dinamizador',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 18,
            'nombre'          => 'Facilitador TecnoA',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 19,
            'nombre'          => 'Gestor Emp. SBDC',
        ]);

        Tipovisitante::create([
            'idtipovisitante' => 20,
            'nombre'          => 'Estudiantes MediaT',
        ]);
    }
}
