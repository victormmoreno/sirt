<?php

use App\Models\AreaConocimiento;
use App\Models\Ciudad;
use App\Models\Entidad;
use App\Models\Eps;
use App\Models\EstadoPrototipo;
use App\Models\EstadoProyecto;
use App\Models\Gestor;
use App\Models\GradoEscolaridad;
use App\Models\GrupoSanguineo;
use App\Models\Idea;
use App\Models\Infocenter;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Ocupacion;
use App\Models\Perfil;
use App\Models\Proyecto;
use App\Models\Sector;
use App\Models\Sublinea;
use App\Models\Talento;
use App\Models\TipoArticulacion;
use App\Models\TipoDocumento;
use App\User;
use Carbon\Carbon;
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

        $role = Role::findByName(Role::findByName(config('laravelpermission.roles.roleAdministrador'))->first()->name);
        $role->givePermissionTo([
            Permission::findByName('ver administrador'),
            Permission::findByName('registrar idea'),
        ]);

        $userAdmin = User::create([
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Especializacion')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'victor',
            'apellidos'           => 'perez',
            'documento'           => '523422321',
            'email'               => 'victor543@misena.edu.co',
            'barrio'              => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1996-09-12',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            //ultimo estudio
            'institucion'         => 'Universidad de Antiquia',
            'titulo_obtenido'     => 'Ingeniero Quimico',
            'fecha_terminacion'   => Carbon::now()->subYears(10)->subMonth(60),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

    

        $userAdmin->dinamizador()->create([
            'user_id' => $userAdmin->id,
            'nodo_id' => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
        ]);

        $userAdmin->gestor()->create([
            'user_id'             => $userAdmin->id,
            'nodo_id'             => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'honorarios'          => 4000000,
        ]);

        $userAdmin->infocenter()->create([
            'nodo_id'   => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
            'user_id'   => $userAdmin->id,
            'extension' => 413342,
        ]);

        $userAdmin->ingreso()->create([
            'nodo_id' => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
            'user_id' => $userAdmin->id,
        ]);

        $userAdmin->talento()->create([
            'user_id'    => $userAdmin->id,
            'perfil_id'  => Perfil::where('nombre', '=', 'Egresado SENA')->first()->id,
            'entidad_id' => Entidad::all()->random()->id,

        ]);

        $userAdmin->assignRole([
            Role::findByName(config('laravelpermission.roles.roleAdministrador')),
            Role::findByName(config('laravelpermission.roles.roleDinamizador')),
            Role::findByName(config('laravelpermission.roles.roleGestor')),
            Role::findByName(config('laravelpermission.roles.roleInfocenter')),
            Role::findByName(config('laravelpermission.roles.roleIngreso')),
            Role::findByName(config('laravelpermission.roles.roleTalento')),
        ]);
        // $userAdmin->givePermissionTo($registrarIdeaPermission);

        $ocupacion = Ocupacion::all()->random()->id;

        $userAdmin->ocupaciones()->attach($ocupacion);

        $userDinamizador = User::create([
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Especializacion')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'juan',
            'apellidos'           => 'Benitez',
            'documento'           => '53244223',
            'email'               => 'juan543@misena.edu.co',
            'barrio'              => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1996-09-12',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            //ultimo estudio
            'institucion'         => 'Universidad de Antiquia',
            'titulo_obtenido'     => 'Ingeniero Quimico',
            'fecha_terminacion'   => Carbon::now()->subYears(10)->subMonth(60),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userDinamizador->dinamizador()->create([
            'user_id' => $userDinamizador->id,
            'nodo_id' => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
        ]);

        $userDinamizador->assignRole([Role::findByName(config('laravelpermission.roles.roleDinamizador'))]);
        $userDinamizador->givePermissionTo(Permission::findByName('registrar idea'));

        $userGestorRamiro = User::create([
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Profesional')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Ramiro Antonio',
            'apellidos'           => 'Isaza Escobar',
            'documento'           => 3414298,
            'email'               => 'risazaes@misena.edu.co',
            'barrio'              => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => null,
            'fechanacimiento'     => '1999-01-19',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            //ultimo estudio
            'institucion'         => 'Universidad de Antiquia',
            'titulo_obtenido'     => 'Ingeniero Quimico',
            'fecha_terminacion'   => Carbon::now()->subYears(10)->subMonth(60),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userGestorRamiro->gestor()->create([
            'user_id'             => $userGestorRamiro->id,
            'nodo_id'             => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'IND')->first()->id,
            'honorarios'          => 4000000,
        ]);
        $userGestorRamiro->assignRole(Role::findByName(config('laravelpermission.roles.roleGestor')));

        $userGestorJulian = User::create([
            'gradoescolaridad_id' => 4,
            'tipodocumento_id'    => 1,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Julian Alberto',
            'apellidos'           => 'Patiño',
            'documento'           => 8102363,
            'email'               => 'japatino@sena.edu.co',
            'barrio'              => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => null,
            'fechanacimiento'     => '1999-01-19',
            'genero'              => User::IsMasculino(),
            'estado'              => User::IsActive(),
            //ultimo estudio
            'institucion'         => 'Universidad de Antiquia',
            'titulo_obtenido'     => 'Ingeniero Quimico',
            'fecha_terminacion'   => Carbon::now()->subYears(10)->subMonth(60),
            'password'            => 8102363,
            'estrato'             => rand(1, 6),
        ]);

        $userGestorJulian->gestor()->create([
            'user_id'             => $userGestorJulian->id,
            'nodo_id'             => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
            'lineatecnologica_id' => LineaTecnologica::where('abreviatura', '=', 'ETC')->first()->id,
            'honorarios'          => 4000000,
        ]);

        $userGestorJulian->assignRole(Role::findByName(config('laravelpermission.roles.roleGestor')));

        $userInfocenter = User::create([
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnologo')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Nathalia',
            'apellidos'           => 'Lopez',
            'documento'           => '435442232',
            'email'               => 'nataliainfo@misena.edu.co',
            'barrio'              => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            //ultimo estudio
            'institucion'         => 'Universidad de Antiquia',
            'titulo_obtenido'     => 'Ingeniero Quimico',
            'fecha_terminacion'   => Carbon::now()->subYears(10)->subMonth(60),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userInfocenter->infocenter()->create([
            'nodo_id'   => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
            'user_id'   => $userInfocenter->id,
            'extension' => 413342,
        ]);

        $userInfocenter->assignRole(Role::findByName(config('laravelpermission.roles.roleInfocenter')));

        $userIngreso = User::create([
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnico')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Ana',
            'apellidos'           => 'Fernandez',
            'documento'           => '54224442',
            'email'               => 'anafernadez@misena.edu.co',
            'barrio'              => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            //ultimo estudio
            'institucion'         => 'Universidad de Antiquia',
            'titulo_obtenido'     => 'Ingeniero Quimico',
            'fecha_terminacion'   => Carbon::now()->subYears(10)->subMonth(60),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userIngreso->ingreso()->create([
            'nodo_id' => Nodo::join('entidades', 'entidades.id', 'nodos.entidad_id')->where('entidades.nombre', '=', 'Medellin')->first()->id,
            'user_id' => $userIngreso->id,
        ]);

        $userIngreso->assignRole(Role::findByName(config('laravelpermission.roles.roleIngreso')));

        $userTalento = User::create([
            'gradoescolaridad_id' => GradoEscolaridad::where('nombre', '=', 'Tecnico')->first()->id,
            'tipodocumento_id'    => TipoDocumento::where('nombre', '=', 'Cédula de Ciudadanía')->first()->id,
            'gruposanguineo_id'   => GrupoSanguineo::all()->random()->id,
            'eps_id'              => Eps::all()->random()->id,
            'ciudad_id'           => Ciudad::all()->random()->id,
            'nombres'             => 'Luisa',
            'apellidos'           => 'Restrepo',
            'documento'           => '75434533',
            'email'               => 'luisa@misena.edu.co',
            'barrio'              => 'El Poblado',
            'direccion'           => 'calle 40 #45 65',
            'telefono'            => '413324',
            'celular'             => '342452323',
            'fechanacimiento'     => '1980-09-12',
            'genero'              => User::IsFemenino(),
            'estado'              => User::IsActive(),
            //ultimo estudio
            'institucion'         => 'Universidad de Antiquia',
            'titulo_obtenido'     => 'Ingeniero Quimico',
            'fecha_terminacion'   => Carbon::now()->subYears(10)->subMonth(60),
            'remember_token'      => Str::random(60),
            'password'            => '123456789',
            'estrato'             => rand(1, 6),
        ]);

        $userTalento->talento()->create([
            'user_id'    => $userTalento->id,
            'perfil_id'  => Perfil::where('nombre', '=', 'Egresado SENA')->first()->id,
            'entidad_id' => Entidad::all()->random()->id,

        ]);

        $userTalento->assignRole(Role::findByName(config('laravelpermission.roles.roleTalento')));

        // // //
        // factory(User::class, 2)->create();

        // // $user = User::whereBetween('id', [8, 27])->get();
    
        // $user = User::latest()->take(2)->get()->each(function ($item) {

        //     $item->assignRole(Role::findByName(config('laravelpermission.roles.roleTalento')));

        //     $talento = Talento::create([
        //         "user_id"               => $item->id,
        //         "perfil_id"             => Perfil::all()->random()->id,
        //         "entidad_id"            => Entidad::all()->random()->id,
        //         "universidad"           => null,
        //         "programa_formacion"    => 'Administración de empresas',
        //         "carrera_universitaria" => 'No Aplica',
        //         "empresa"               => null,
        //         "otro_tipo_talento"     => null,
        //     ]);
        //     $proyecto = Proyecto::create([
        //         'idea_id'                     => Idea::all()->random()->id,
        //         'sector_id'                   => Sector::all()->random()->id,
        //         'sublinea_id'                 => Sublinea::all()->random()->id,
        //         'areaconocimiento_id'         => AreaConocimiento::all()->random()->id,
        //         'estadoproyecto_id'           => EstadoProyecto::all()->random()->id,
        //         'gestor_id'                   => Gestor::all()->random()->id,
        //         'entidad_id'                  => Entidad::all()->random()->id,
        //         'nodo_id'                     => Nodo::all()->random()->id,
        //         'tipoarticulacionproyecto_id' => TipoArticulacion::all()->random()->id,
        //         'estadoprototipo_id'          => EstadoPrototipo::all()->random()->id,
        //         'tipo_ideaproyecto'           => 1,
        //         'otro_tipoarticulacion'       => 1,
        //         'universidad_proyecto'        => 'Universidad de antiquia',
        //         'codigo_proyecto'             => Str::random(10),
        //         'nombre'                      => 'Andres Lopez',
        //         'observaciones_proyecto'      => 'asdasdas',
        //         'impacto_proyecto'            => 'asdsadasd',
        //         'economia_naranja'            => 1,
        //         'fecha_inicio'                => '2019-07-12',
        //         'art_cti'                     => 1,
        //         'nom_act_cti'                 => 1,
        //         'diri_ar_emp'                 => 1,
        //         'reci_ar_emp'                 => 1,
        //         'dine_reg'                    => 1,
        //     ]);

        //     $talento->proyectos()->attach($proyecto->id, ['talento_lider' => 0]);
        // });

        // factory(Gestor::class, 5)->create();
        // factory(Infocenter::class, 2)->create();

    }

}
