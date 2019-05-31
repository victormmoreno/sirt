<?php

use App\Models\GradoEscolaridad;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\User;
use Illuminate\Database\Seeder;
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
        $roleAdministrador = Role::create(['name' => 'Administrador']);
        $roleDinamizador   = Role::create(['name' => 'Dinamizador']);
        $roleGestor        = Role::create(['name' => 'Gestor']);
        $roleInfocenter    = Role::create(['name' => 'Infocenter']);
        $roleTalento       = Role::create(['name' => 'Talento']);
        $roleIngreso       = Role::create(['name' => 'Ingreso']);
        $roleProveedor     = Role::create(['name' => 'Proveedor']);

        $registrarIdeaPermission = Permission::create(['name' => 'registrar idea']);
        $consultarIdeaPermission = Permission::create(['name' => 'consultar idea']);
        $editarIdeaPermission    = Permission::create(['name' => 'editar idea']);
        $eliminarIdeaPermission  = Permission::create(['name' => 'eliminar idea']);

        $registrarLineaPermission = Permission::create(['name' => 'registrar linea']);
        $consultarLineaPermission = Permission::create(['name' => 'consultar linea']);
        $editarLineaPermission    = Permission::create(['name' => 'editar linea']);
        $eliminarLineaPermission  = Permission::create(['name' => 'eliminar linea']);

        $roleAdministrador->givePermissionTo($consultarIdeaPermission);
        $roleAdministrador->givePermissionTo($consultarLineaPermission);

        $userAdmin = User::create([
            'rol_id'               => Rol::where('nombre', '=', 'Administrador')->first()->id,
            'gradosescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnologo')->first()->id,
            'tipodocumento_id'     => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'nombres'              => 'julian',
            'apellidos'            => 'londoño',
            'documento'            => '1027890334',
            'email'                => 'jlondono433@misena.edu.co',
            'direccion'            => 'calle 40 #45 65',
            'telefono'             => '413324',
            'celular'              => '342452323',
            'fechanacimiento'      => '1996-09-12',
            'genero'               => User::IsMasculino(),
            'estado'               => User::IsActive(),
            'remember_token'       => Str::random(10),
            'password'             => '123456789',
            'estrato'              => 1,
        ]);

        $userAdmin->assignRole($roleAdministrador);
        $userAdmin->givePermissionTo($registrarIdeaPermission);

        // $userDinamizador = User::create([
        //     'documento'             => '1026890332',
        //     'nombres'               => 'Victor ',
        //     'apellidos'             => 'Moreno',
        //     'email'                 => 'vicmo@gmail.com',
        //     'direccion'             => 'calle 40 #45 65',
        //     'telefono'              => '413324',
        //     'celular'               => '342452323',
        //     'fechanacimiento'       => '1996-09-12',
        //     'descripcion_ocupacion' => 'desarrollador web',
        //     'estado'                => true,
        //     'remember_token'        => Str::random(10),
        //     'password'              => '123456789',
        //     'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
        //     'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
        //     // 'ciudad_id'             => Ciudad::all()->random()->id,
        //     'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
        //     // 'nodo_id'               => Nodo::all()->random()->id,
        // ]);

        // $userDinamizador->assignRole($roleAdministrador);

        // $userInfocenter = User::create([
        //     'documento'             => '1234567890',
        //     'nombres'               => 'Luisa ',
        //     'apellidos'             => 'Perez',
        //     'email'                 => 'luisa@gmail.com',
        //     'direccion'             => 'calle 40 #45 65',
        //     'telefono'              => '413324',
        //     'celular'               => '342452323',
        //     'fechanacimiento'       => '1996-09-12',
        //     'descripcion_ocupacion' => 'desarrollador web',
        //     'estado'                => true,
        //     'remember_token'        => Str::random(10),
        //     'password'              => '123456789',
        //     'genero_id'             => Genero::where('nombre', '=', 'Masculino')->first()->id,
        //     'tipodocumento_id'      => TipoDocumento::where('abreviatura', '=', 'CC')->first()->id,
        //     'ciudad_id'             => Ciudad::all()->random()->id,
        //     'rol_id'                => Rol::where('nombre', '=', 'Administrador')->first()->id,
        //     'ocupacion_id'          => Ocupacion::where('nombre', '=', 'Empleado')->first()->id,
        //     'estrato_id'            => Estrato::where('estrato', '=', 1)->first()->id,
        //     // 'nodo_id'               => Nodo::all()->random()->id,
        //     'nodo_id'               => Nodo::where('nombre', '=', 'Medellin')->first()->id,
        // ]);

        // $dinamizadorInfocenter = DinamizadorInfocenter::create([
        //     'honorario'          => '2280000',
        //     'profesion'          => 'Especialista talento humano',
        //     'tipovinculacion_id' => TipoVinculacion::where('nombre', '=', 'contratista')->first()->id,
        //     'user_id'            => $userInfocenter->id,
        // ]);

        // $userInfocenter->assignRole($roleInfocenter);

        // $userInfocenter->givePermissionTo($consultarIdeaPermission);
        // $userInfocenter->givePermissionTo($consultarLineaPermission);

        factory(User::class, 20)->create();

    }
}
