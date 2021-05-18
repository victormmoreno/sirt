<?php

use Illuminate\Database\Seeder;
use App\Models\{Empresa, Sede};

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresas = Empresa::all();
        // Manejando la información en la empresa
        foreach ($empresas as $key => $empresa) {
            $empresa->update([
                'nombre' => $empresa->entidad->nombre,
                'email' => $empresa->entidad->email_entidad
            ]);
        }
        // Creando los registros de las sedes
        foreach ($empresas as $key2 => $empresa) {
            Sede::create([
                'empresa_id' => $empresa->id,
                'ciudad_id' => $empresa->entidad->ciudad->id,
                'nombre_sede' => $empresa->nombre,
                'direccion' => $empresa->direccion
            ]);
        }
    }
}
