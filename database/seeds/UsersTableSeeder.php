<?php

use App\Models\Ciudad;
use App\Models\Entidad;
use App\Models\GradoEscolaridad;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Perfil;
use App\Models\Rols;
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
            'rol_id'              => Rols::where('nombre', '=', 'Administrador')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Especializacion')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'nombres'             => 'victor',
            'apellidos'           => 'perez',
            'documento'           => '523422321',
            'email'               => 'victor543@misena.edu.co',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1996-09-12',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(10),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userAdmin->assignRole($roleAdministrador);
        $userAdmin->givePermissionTo($registrarIdeaPermission);

        $userDinamizador = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Dinamizador')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Especializacion')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'nombres'             => 'juan',
            'apellidos'           => 'Benitez',
            'documento'           => '53244223',
            'email'               => 'juan543@misena.edu.co',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1996-09-12',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(10),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userDinamizador->dinamizador()->create([
            'user_id' => $userDinamizador->id,
            'nodo_id' => Nodo::where('nombre', '=', 'Medellin')->first()->id,
        ]);

        $userGestorRamiro = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Profesional')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'nombres'             => 'Ramiro Antonio',
            'apellidos'           => 'Isaza Escobar',
            'documento'           => 3414298,
            'email'               => 'risazaes@misena.edu.co',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => null,
            'fechanacimiento'     => '1999-01-19',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(10),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userGestorRamiro->gestor()->create([
            'user_id'             => $userGestorRamiro->id,
            'nodo_id'             => Nodo::where('nombre', '=', 'Medellin')->first()->id,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'honorarios'          => 4000000,
        ]);

        $userGestorJulian = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
            'gradoescolaridad_id' => 4,
            'tipodocumento_id'    => 1,
            'nombres'             => 'Julian Alberto',
            'apellidos'           => 'Patiño',
            'documento'           => 8102363,
            'email'               => 'japatino@sena.edu.co',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => null,
            'fechanacimiento'     => '1999-01-19',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            'password'            => 8102363,
            'estrato'             => rand(1, 6),
        ]);

        $userGestorJulian->gestor()->create([
            'user_id'             => $userGestorJulian->id,
            'nodo_id'             => Nodo::where('nombre', '=', 'Medellin')->first()->id,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'honorarios'          => 4000000,
        ]);

        $userInfocenter = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Infocenter')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnologo')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'nombres'             => 'Nathalia',
            'apellidos'           => 'Lopez',
            'documento'           => '435442232',
            'email'               => 'nataliainfo@misena.edu.co',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(10),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userInfocenter->infocenter()->create([
            'nodo_id' => Nodo::where('nombre', '=', 'Medellin')->first()->id,
            'user_id' => $userInfocenter->id,
        ]);

        $userIngreso = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Ingreso')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnico')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'nombres'             => 'Ana',
            'apellidos'           => 'Fernandez',
            'documento'           => '54224442',
            'email'               => 'anafernadez@misena.edu.co',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(10),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userIngreso->ingreso()->create([
            'nodo_id' => Nodo::where('nombre', '=', 'Medellin')->first()->id,
            'user_id' => $userIngreso->id,
        ]);

        $userTalento = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Talento')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnico')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'nombres'             => 'Luisa',
            'apellidos'           => 'Restrepo',
            'documento'           => '75434533',
            'email'               => 'luisa@misena.edu.co',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(10),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userTalento->talento()->create([
            'user_id'   => $userTalento->id,
            'perfil_id' => Perfil::where('nombre', '=', 'Egresado SENA')->first()->id,
            'entidad_id' => Entidad::all()->random()->id,
            'ciudad_id' => Ciudad::all()->random()->id,
            'programa' => 'Analsis y desarrollo de sistemas de información',
        ]);

        // User::create([
        //     'id'                  => 3,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Catherine',
        //     'apellidos'           => 'Gomez',
        //     'password'            => 34001081,
        //     'documento'           => 34001081,
        //     'email'               => 'katherinegom@misena.edu.co',
        //     'telefono'            => null,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 4,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Jorge',
        //     'apellidos'           => 'Bolaños',
        //     'password'            => 72164827,
        //     'documento'           => 72164827,
        //     'email'               => 'jybolanos@sena.edu.co',
        //     'telefono'            => null,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 5,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Laura',
        //     'apellidos'           => 'Rojas Bedoya',
        //     'password'            => 1037604426,
        //     'documento'           => 1037604426,
        //     'email'               => 'lcrojasb@sena.edu.co',
        //     'telefono'            => null,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 6,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Nathalia',
        //     'apellidos'           => 'Marín Pareja',
        //     'password'            => 43255643,
        //     'documento'           => 43255643,
        //     'email'               => 'nmarinp@sena.edu.co',
        //     'telefono'            => null,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 7,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Ruth Zorayda',
        //     'apellidos'           => 'Osorio Gutierrez',
        //     'password'            => 43270192,
        //     'documento'           => 43270192,
        //     'email'               => 'rzosorio@misena.edu.co',
        //     'telefono'            => null,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 8,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Dily Alexandra',
        //     'apellidos'           => 'Castillo Carvajal',
        //     'password'            => 60379425,
        //     'documento'           => 60379425,
        //     'email'               => 'dilycastilloc@misena.edu.co',
        //     'telefono'            => null,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 9,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Camilo Andrés',
        //     'apellidos'           => 'Páramo Velásquez',
        //     'password'            => 71378444,
        //     'documento'           => 71378444,
        //     'email'               => 'cparamov@sena.edu.co',
        //     'telefono'            => 3002154480,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 10,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'Alexander',
        //     'apellidos'           => 'Florian',
        //     'password'            => 71795328,
        //     'documento'           => 71795328,
        //     'email'               => 'aflorian@sena.edu.co',
        //     'telefono'            => null,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);

        // User::create([
        //     'id'                  => 671,
        //     'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
        //     'gradoescolaridad_id' => 4,
        //     'tipodocumento_id'    => 1,
        //     'nombres'             => 'GUSTAVO ADOLFO',
        //     'apellidos'           => 'SERNA LÓPEZ',
        //     'password'            => 1128052442,
        //     'documento'           => 1128052442,
        //     'email'               => 'gsst400@gmail.com',
        //     'telefono'            => 3006441372,
        //     'fechanacimiento'     => '1999-01-19',
        //     'genero'              => 0,
        //     'estado'              => 1,
        //     'estrato'             => 3,
        // ]);
        // 
        factory(User::class, 20)->create();

    }

}
