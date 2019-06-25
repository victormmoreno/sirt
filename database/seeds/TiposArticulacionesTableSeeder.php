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
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 2,
            'nombre' => 'Publicaciones',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 3,
            'nombre' => 'Articulos A',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 4,
            'nombre' => 'Articulos B',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 5,
            'nombre' => 'Articulos C',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 6,
            'nombre' => 'Articulos Divulgación',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 7,
            'nombre' => 'Solicitudes de patentes',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 8,
            'nombre' => 'Vigilancias Tecnológicas',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 9,
            'nombre' => 'Prototipos',
            'articulado_con' => 1,
        ]);

        TipoArticulacion::create([
            'id'     => 10,
            'nombre' => 'Eventos científicos y afines',
            'articulado_con' => 1,
        ]);

    }
}
