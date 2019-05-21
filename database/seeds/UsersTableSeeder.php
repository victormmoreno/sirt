<?php

use App\Models\Ciudad;
use App\Models\DinamizadorInfocenter;
use App\Models\Estrato;
use App\Models\Genero;
use App\Models\Ocupacion;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\Models\TipoVinculacion;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
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
        // Role::truncate();

        $roleAdministrador = Role::create(['name' => 'Administrador']);
        $roleDinamizador   = Role::create(['name' => 'Dinamizador']);
        $roleGestor        = Role::create(['name' => 'Gestor']);
        $roleInfocenter    = Role::create(['name' => 'Infocenter']);
        $roleTalento       = Role::create(['name' => 'Talento']);
        $roleIngreso       = Role::create(['name' => 'Ingreso']);
        $roleProveedor     = Role::create(['name' => 'Proveedor']);

        $registrarIdeaPermission = Permission::create(['name' => 'registrar idea']);
        $consultarIdeaPermission = Permission::create(['name' => 'consultar idea']);
        $editarIdeaPermission= Permission::create(['name' => 'editar idea']);
        $eliminarIdeaPermission = Permission::create(['name' => 'eliminar idea']);

        $roleAdministrador->givePermissionTo($consultarIdeaPermission);

        $userAdmin = User::create([
            'documento'             => '1027890334',
            'nombres'               => 'julian',
            'apellidos'             => 'londoño',
            'email'                 => 'jlondono433@misena.edu.co',
            'direccion'             => 'calle 40 #45 65',
            'telefono'              => '413324',
            'celular'               => '342452323',
            'fechanacimiento'       => '1996-09-12',
            'descripcion_ocupacion' => 'desarrollador web',
            'password'              => Hash::make('123456789'),
            'estado'                => true,
            'remember_token'        => Str::random(10),
            'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
            'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
            'ciudad_id'             => Ciudad::all()->random()->id,
            'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
            'ocupacion_id'          => Ocupacion::where('nombre', '=', 'Empleado')->first()->id,
            'estrato_id'            => Estrato::where('estrato', '=', 1)->first()->id,
        ]);

        $userAdmin->assignRole($roleAdministrador);
        $userAdmin->givePermissionTo($registrarIdeaPermission);

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
            'estado'                => true,
            'remember_token'        => Str::random(10),
            'password'              => Hash::make('123456789'),
            'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
            'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
            'ciudad_id'             => Ciudad::all()->random()->id,
            'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
            'ocupacion_id'          => Ocupacion::where('nombre', '=', 'Empleado')->first()->id,
            'estrato_id'            => Estrato::where('estrato', '=', 1)->first()->id,
        ]);

        $userInfocenter = User::create([
            'documento'             => '1234567890',
            'nombres'               => 'Luisa ',
            'apellidos'             => 'Perez',
            'email'                 => 'luisa@gmail.com',
            'direccion'             => 'calle 40 #45 65',
            'telefono'              => '413324',
            'celular'               => '342452323',
            'fechanacimiento'       => '1996-09-12',
            'descripcion_ocupacion' => 'desarrollador web',
            'estado'                => true,
            'remember_token'        => Str::random(10),
            'password'              => Hash::make('123456789'),
            'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
            'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
            'ciudad_id'             => Ciudad::all()->random()->id,
            'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
            'ocupacion_id'          => Ocupacion::where('nombre', '=', 'Empleado')->first()->id,
            'estrato_id'            => Estrato::where('estrato', '=', 1)->first()->id,
        ]);

        $dinamizadorInfocenter = DinamizadorInfocenter::create([
            'honorario'             => '2280000',
            'profesion'             => 'Especialista talento humano',
            'tipovinculacion_id'             => TipoVinculacion::where('nombre', '=', 'contratista')->first()->id,
            'user_id'             => $userInfocenter->id,
        ]);

        $userInfocenter->assignRole($roleInfocenter);
        
        $userInfocenter->givePermissionTo($consultarIdeaPermission);

        factory(User::class, 20)->create();

    }
}
