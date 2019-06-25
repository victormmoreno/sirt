<?php

use App\Models\Ciudad;
use App\Models\Entidad;
use App\Models\Eps;
use App\Models\Gestor;
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\Infocenter;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Ocupacion;
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

        $roleAdministrador = Role::create(['name' => config('laravelpermission.roles.roleAdministrador')]);
        $roleDinamizador   = Role::create(['name' => config('laravelpermission.roles.roleDinamizador')]);
        $roleGestor        = Role::create(['name' => config('laravelpermission.roles.roleGestor')]);
        $roleInfocenter    = Role::create(['name' => config('laravelpermission.roles.roleInfocenter')]);
        $roleTalento       = Role::create(['name' => config('laravelpermission.roles.roleTalento')]);
        $roleIngreso       = Role::create(['name' => config('laravelpermission.roles.roleIngreso')]);
        $roleProveedor     = Role::create(['name' => config('laravelpermission.roles.roleProveedor')]);

        $consultarIdeaPermission = Permission::create(['name' => config('laravelpermission.permissions.idea.index')]);
        $registrarIdeaPermission = Permission::create(['name' => config('laravelpermission.permissions.idea.create')]);
        $editarIdeaPermission    = Permission::create(['name' => config('laravelpermission.permissions.idea.edit')]);
        $eliminarIdeaPermission  = Permission::create(['name' => config('laravelpermission.permissions.idea.delete')]);

        $consultarLineaPermission = Permission::create(['name' => config('laravelpermission.permissions.linea.index')]);
        $registrarLineaPermission = Permission::create(['name' => config('laravelpermission.permissions.linea.create')]);
        $editarLineaPermission    = Permission::create(['name' => config('laravelpermission.permissions.linea.edit')]);
        $eliminarLineaPermission  = Permission::create(['name' => config('laravelpermission.permissions.linea.delete')]);

        $roleAdministrador->givePermissionTo($consultarIdeaPermission);
        $roleAdministrador->givePermissionTo($consultarLineaPermission);

        $userAdmin = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Administrador')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Especializacion')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'victor',
            'apellidos'           => 'perez',
            'documento'           => '523422321',
            'email'               => 'victor543@misena.edu.co',
            'barrio'           => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1996-09-12',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userAdmin->assignRole($roleAdministrador);
        $userAdmin->givePermissionTo($registrarIdeaPermission);

        $ocupacion = Ocupacion::all()->random()->id;

        $userAdmin->ocupaciones()->attach($ocupacion);


        $userDinamizador = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Dinamizador')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Especializacion')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'juan',
            'apellidos'           => 'Benitez',
            'documento'           => '53244223',
            'email'               => 'juan543@misena.edu.co',
            'barrio'           => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1996-09-12',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        


        $userDinamizador->dinamizador()->create([
            'user_id' => $userDinamizador->id,
            'nodo_id' => Nodo::where('nombre', '=', 'Medellin')->first()->id,
        ]);

        $userDinamizador->assignRole($roleDinamizador);
        $userDinamizador->givePermissionTo($consultarLineaPermission);

        $userGestorRamiro = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Gestor')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Profesional')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Ramiro Antonio',
            'apellidos'           => 'Isaza Escobar',
            'documento'           => 3414298,
            'email'               => 'risazaes@misena.edu.co',
            'barrio'           => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => null,
            'fechanacimiento'     => '1999-01-19',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(60),
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
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Julian Alberto',
            'apellidos'           => 'Patiño',
            'documento'           => 8102363,
            'email'               => 'japatino@sena.edu.co',
            'barrio'           => 'El Poblado',
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
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Nathalia',
            'apellidos'           => 'Lopez',
            'documento'           => '435442232',
            'email'               => 'nataliainfo@misena.edu.co',
            'barrio'           => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userInfocenter->infocenter()->create([
            'nodo_id' => Nodo::where('nombre', '=', 'Medellin')->first()->id,
            'user_id' => $userInfocenter->id,
            'extension' => 413342,
        ]);

        $userIngreso = User::create([
            'rol_id'              => Rols::where('nombre', '=', 'Ingreso')->first()->id,
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnico')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Ana',
            'apellidos'           => 'Fernandez',
            'documento'           => '54224442',
            'email'               => 'anafernadez@misena.edu.co',
            'barrio'           => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(60),
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
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Luisa',
            'apellidos'           => 'Restrepo',
            'documento'           => '75434533',
            'email'               => 'luisa@misena.edu.co',
            'barrio'           => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userTalento->talento()->create([
            'user_id'    => $userTalento->id,
            'perfil_id'  => Perfil::where('nombre', '=', 'Egresado SENA')->first()->id,
            'entidad_id' => Entidad::all()->random()->id,
            'programa'   => 'Analsis y desarrollo de sistemas de información',
        ]);

        //
        factory(User::class, 20)->create();
        factory(Gestor::class, 5)->create();
        factory(Infocenter::class, 2)->create();

    }

}
