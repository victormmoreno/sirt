<?php

namespace App\Providers;

use App\User;
use App\Models\ArticulationSubtype;
use App\Models\ArticulationType;
use App\Models\CostoAdministrativo;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Models\EquipoMantenimiento;
use App\Models\Idea;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Material;
use App\Models\ArticulationStage;
use App\Models\Articulation;
use App\Models\UsoInfraestructura;
use App\Policies\Articulation\ArticulationSubtypePolicy;
use App\Policies\CostoAdministrativo\CostoAdministrativoPolicy;
use App\Policies\Empresa\EmpresaPolicy;
use App\Policies\Equipo\EquipoPolicy;
use App\Policies\LineaTecnologica\LineaTecnologicaPolicy;
use App\Policies\Mantenimiento\MantenimientoPolicy;
use App\Policies\Nodo\NodoPolicy;
use App\Policies\User\UserPolicy;
use App\Policies\UsoInfraestrucutura\UsoInfraestructuraPolicy;
use App\Policies\Material\MaterialPolicy;
use App\Policies\Idea\IdeaPolicy;
use App\Policies\ModelPolicy;
use App\Policies\Articulation\ArticulationStagePolicy;
use App\Policies\Articulation\ArticulationTypePolicy;
use App\Policies\Articulation\ArticulationPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class                => UserPolicy::class,
        LineaTecnologica::class    => LineaTecnologicaPolicy::class,
        Nodo::class                => NodoPolicy::class,
        CostoAdministrativo::class => CostoAdministrativoPolicy::class,
        Equipo::class              => EquipoPolicy::class,
        EquipoMantenimiento::class => MantenimientoPolicy::class,
        Material::class => MaterialPolicy::class,
        Idea::class => IdeaPolicy::class,
        Empresa::class => EmpresaPolicy::class,
        ArticulationStage::class => ArticulationStagePolicy::class,
        ArticulationType::class => ArticulationTypePolicy::class,
        ArticulationSubtype::class => ArticulationSubtypePolicy::class,
        Articulation::class => ArticulationPolicy::class,
        UsoInfraestructura::class  => UsoInfraestructuraPolicy::class,
        Model::class => ModelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
