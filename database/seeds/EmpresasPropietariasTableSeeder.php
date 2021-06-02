<?php

use Illuminate\Database\Seeder;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class EmpresasPropietariasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propietarios = DB::table('propietarios')->where('propietario_type', 'App\Models\Empresa')->get();
        foreach ($propietarios as $propietario) {
            $empresa = Empresa::find($propietario->propietario_id);
            $sede = $empresa->sedes->first()->id;
            DB::table('propietarios')->where('id', $propietario->id)->update([
                'propietario_type' => 'App\Models\Sede',
                'propietario_id' => $sede
            ]);
        }
    }
}
