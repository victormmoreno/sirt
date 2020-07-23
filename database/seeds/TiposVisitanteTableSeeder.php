<?php

use App\Models\TipoVisitante;
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
        TipoVisitante::create([
            'nombre'          => 'Aprendiz SENA'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Gestor T1'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Infocenter'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Instructor SENA'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Media Técnica'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Talento'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Universitario'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Visitante/Otro'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Gestor T2'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Empresario'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Soporte Sistemas- Enlace'
        ]);

        TipoVisitante::create([
            'nombre'          => 'SIN CARGO'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Semillero Investigador'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Empleado'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Instructor/Otra'
        ]);

        TipoVisitante::create([
            'nombre'          => 'SENNOVA'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Dinamizador'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Facilitador TecnoA'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Gestor Emp. SBDC'
        ]);

        TipoVisitante::create([
            'nombre'          => 'Estudiantes MediaT'
        ]);
    }
}
