<?php

use App\Models\TipoArticulacion;
use Illuminate\Database\Seeder;

class TiposArticulacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoArticulacion::create([
            'id'     => 1,
            'nombre' => 'Proyecto I+D+I formulados',
        ]);

        TipoArticulacion::create([
            'id'     => 2,
            'nombre' => 'Publicaciones',
        ]);

        TipoArticulacion::create([
            'id'     => 3,
            'nombre' => 'Articulos A',
        ]);

        TipoArticulacion::create([
            'id'     => 4,
            'nombre' => 'Articulos B',
        ]);

        TipoArticulacion::create([
            'id'     => 5,
            'nombre' => 'Articulos C',
        ]);

        TipoArticulacion::create([
            'id'     => 6,
            'nombre' => 'Articulos Divulgación',
        ]);

        TipoArticulacion::create([
            'id'     => 7,
            'nombre' => 'Solicitudes de patentes',
        ]);

        TipoArticulacion::create([
            'id'     => 8,
            'nombre' => 'Vigilancias Tecnológicas',
        ]);

        TipoArticulacion::create([
            'id'     => 9,
            'nombre' => 'Prototipos',
        ]);

        TipoArticulacion::create([
            'id'     => 10,
            'nombre' => 'Eventos científicos y afines',
        ]);

    }
}
