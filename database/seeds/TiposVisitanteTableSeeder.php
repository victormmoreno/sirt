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
            'nombre'          => 'Aprendiz SENA'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Gestor T1'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Infocenter'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Instructor SENA'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Media Técnica'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Talento'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Universitario'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Visitante/Otro'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Gestor T2'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Empresario'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Soporte Sistemas- Enlace'
        ]);

        Tipovisitante::create([
            'nombre'          => 'SIN CARGO'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Semillero Investigador'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Empleado'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Instructor/Otra'
        ]);

        Tipovisitante::create([
            'nombre'          => 'SENNOVA'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Dinamizador'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Facilitador TecnoA'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Gestor Emp. SBDC'
        ]);

        Tipovisitante::create([
            'nombre'          => 'Estudiantes MediaT'
        ]);
    }
}
