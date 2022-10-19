<?php

namespace App\Providers;

use App\Models\CostoAdministrativo;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Models\EquipoMantenimiento;
use App\Models\Idea;
use App\Models\LineaTecnologica;
use App\Models\Nodo;
use App\Models\Material;
use App\Models\UsoInfraestructura;
use App\Models\ArticulacionPbt;
use App\Models\CharlaInformativa;
use App\Models\Proyecto;
use App\Models\GrupoInvestigacion;
use App\Policies\CostoAdministrativo\CostoAdministrativoPolicy;
use App\Policies\Empresa\EmpresaPolicy;
use App\Policies\Equipo\EquipoPolicy;
use App\Policies\LineaTecnologica\LineaTecnologicaPolicy;
use App\Policies\Mantenimiento\MantenimientoPolicy;
use App\Policies\Nodo\NodoPolicy;
use App\Policies\User\UserPolicy;
use App\Policies\UsoInfraestrucutura\UsoInfraestructuraPolicy;
use App\Policies\Material\MaterialPolicy;
use App\Policies\IdeaPolicy;
use App\Policies\ProyectoPolicy;
use App\Policies\CharlaInformativaPolicy;
use App\Policies\IndicadorPolicy;
use App\Policies\GrupoPolicy;
use App\Policies\ArticulacionPbt\ArticulacionPbtPolicy;
use App\User;
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
        User::class => UserPolicy::class,
        LineaTecnologica::class => LineaTecnologicaPolicy::class,
        Nodo::class => NodoPolicy::class,
        UsoInfraestructura::class => UsoInfraestructuraPolicy::class,
        CostoAdministrativo::class => CostoAdministrativoPolicy::class,
        Equipo::class => EquipoPolicy::class,
        EquipoMantenimiento::class => MantenimientoPolicy::class,
        Material::class => MaterialPolicy::class,
        Idea::class => IdeaPolicy::class,
        Empresa::class => EmpresaPolicy::class,
        ArticulacionPbt::class => ArticulacionPbtPolicy::class,
        Proyecto::class => ProyectoPolicy::class,
        CharlaInformativa::class => CharlaInformativaPolicy::class,
        Model::class => IndicadorPolicy::class,
        GrupoInvestigacion::class => GrupoPolicy::class,
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
