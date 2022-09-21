@can('showTituloForTalento', App\Models\Empresa::class)
    <div class="col s12 m5 l5">
        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
            <span class="card-title center-align">Empresas registradas por tí</span>
        </div>
    </div>
    <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
        <a  href="{{route('empresa.create')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva Empresa</a>
    </div>
    <div class="col s12 m3 l3 show-on-large hide-on-med-and-down right">
        <a  href="{{route('empresa.search')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Buscar Empresa</a>
    </div>
@elsecan('showTituloForAdmins', App\Models\Empresa::class)
    <div class="col s12 m5 l5">
        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
            <span class="card-title center-align">Empresas de tecnoparque</span>
        </div>
    </div>
    <div class="col s12 m4 l4 show-on-large hide-on-med-and-down">
        <a  href="{{route('empresa.create')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva Empresa</a>
    </div>
    <div class="col s12 m3 l3 show-on-large hide-on-med-and-down right">
        <a  href="{{route('empresa.search')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Buscar Empresa</a>
    </div>
@elsecan('showTitulo', App\Models\Empresa::class)
    <div class="col s12 m9 l9">
        <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
            <span class="card-title center-align">Empresas de tecnoparque</span>
        </div>
    </div>
    <div class="col s12 m3 l3 show-on-large hide-on-med-and-down right">
        <a  href="{{route('empresa.search')}}" class="waves-effect waves-grey light-green btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Buscar Empresa</a>
    </div>
@endcan