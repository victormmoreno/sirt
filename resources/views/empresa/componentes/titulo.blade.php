@if(session()->get('login_role') == App\User::IsTalento())
    <div class="col s12 {{auth()->user()->can('create', App\Models\Empresa::class) ? 'm8 l8' : 'm12 l12'}}">
        <div class="center-align primary-text">
            <span class="card-title center-align">Empresas registradas por tí</span>
        </div>
    </div>
@else
    <div class="col s12 {{auth()->user()->can('create', App\Models\GrupoInvestigacion::class) ? 'm8 l8' : 'm12 l12'}}">
        <div class="center-align primary-text">
            <span class="card-title center-align">Empresas de tecnoparque</span>
        </div>
    </div>
@endif