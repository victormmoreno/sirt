<?php

use App\Models\Ciudad;
use App\Models\Estrato;
use App\Models\Genero;
use App\Models\Ocupacion;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roleAdministrador = Role::create(['name' => 'Administrador']);
        $roleDinamizador   = Role::create(['name' => 'Dinamizador']);
        $roleGestor        = Role::create(['name' => 'Gestor']);
        $roleInfocenter    = Role::create(['name' => 'Infocenter']);
        $roleTalento       = Role::create(['name' => 'Talento']);
        $roleIngreso       = Role::create(['name' => 'Ingreso']);
        $roleProveedor     = Role::create(['name' => 'Proveedor']);

        $userAdmin = User::create([
            'documento'             => '1027890334',
            'nombres'               => 'julian',
            'apellidos'             => 'londoño',
            'email'                 => 'jlondono433@gmail.com',
            'direccion'             => 'calle 40 #45 65',
            'telefono'              => '413324',
            'celular'               => '342452323',
            'fechanacimiento'       => '1996-09-12',
            'descripcion_ocupacion' => 'desarrollador web',
            'password'              => Hash::make('12345678'),
            'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
            'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
            'ciudad_id'             => Ciudad::all()->random()->id,
            'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
            'ocupacion_id'          => Ocupacion::where('nombre', '=', 'Empleado')->first()->id,
            'estrato_id'            => Estrato::where('estrato', '=', 1)->first()->id,
        ]);

        $userAdmin->assignRole($roleAdministrador);

        $userDinamizador = User::create([
            'documento'             => '1026890332',
            'nombres'               => 'Victor ',
            'apellidos'             => 'Moreno',
            'email'                 => 'vicmo@gmail.com',
            'direccion'             => 'calle 40 #45 65',
            'telefono'              => '413324',
            'celular'               => '342452323',
            'fechanacimiento'       => '1996-09-12',
            'descripcion_ocupacion' => 'desarrollador web',
            'password'              => Hash::make('12345678'),
            'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
            'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
            'ciudad_id'             => Ciudad::all()->random()->id,
            'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
            'ocupacion_id'          => Ocupacion::where('nombre', '=', 'Empleado')->first()->id,
            'estrato_id'            => Estrato::where('estrato', '=', 1)->first()->id,
        ]);

        $userDinamizador->assignRole($roleDinamizador);
    }
}
