<div class="row">
    <div class="col s12 m12 l12">
        <div class="row">
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tipo Convocatoria
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNameTipoVinculacion()}}
                        </p>
                    </li>
                    @if($actividad->articulacionpbt->present()->articulacionPbtTipoVinculacion(App\Models\ArticulacionPbt::IsPbt()))
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Idea
                            </span>
                            <p>
                                <a class="orange-text text-darken-1" onclick="detallesIdeaPorId({{$actividad->articulacionpbt->present()->articulacionPbtIdIdeaProyecto()}})">{{$actividad->articulacionpbt->present()->articulacionPbtCodeIdeaProyecto()}} - {{$actividad->articulacionpbt->present()->articulacionPbtNameIdeaProyecto()}}</a>
                            </p>
                        </li>
                        <li class="collection-item">
                            <span class="title black-text text-darken-3">
                                Proyecto
                            </span>
                            <p>
                                <a class="orange-text text-darken-1" target="_blank" href="{{route('proyecto.detalle', $actividad->articulacionpbt->present()->articulacionPbtIdProyecto())}}">{{$actividad->articulacionpbt->present()->articulacionPbtCodeProyecto()}} - {{$actividad->articulacionpbt->present()->articulacionPbtNameProyecto()}}</a>
                            </p>
                        </li>
                    @else
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Sede de la empresa
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtSedeEmpresa()}}
                        </p>
                    </li>
                    @endif
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Articulación
                        </span>
                        <p>
                           {{$actividad->present()->actividadCode()}} - {{$actividad->present()->actividadName()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha Incio de la Articulación
                        </span>
                        <p>
                            {{$actividad->present()->startDate()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Fecha esperada de finalización de la Articulación
                        </span>
                        <p>
                           {{$actividad->articulacionpbt->present()->articulacionPbtFechaFinalizacion()}}
                        </p>
                    </li>
                    
                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Tipo Articulación
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreTipoArticulacion()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Alcance Articulación
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreAlcanceArticulacion()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre de convocatoria 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreConvocatoria()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Objetivo de la articulación 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtObjetivo()}}
                        </p>
                    </li>
                    
                </ul>
            </div>
            <div class="col s12 m4 l4">
                <ul class="collection">
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Entidad con la que se realiza la articulación
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtEntidad()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Nombre de contacto 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtNombreContacto()}}
                        </p>
                    </li>
                    <li class="collection-item">
                        <span class="title black-text text-darken-3">
                            Mail institucional de contacto de la organización 
                        </span>
                        <p>
                            {{$actividad->articulacionpbt->present()->articulacionPbtEmail()}}
                        </p>
                    </li>
                    
                </ul>
            </div>  
        </div>
    </div>
</div>
<div class="center">
    <span class="mailbox-title orange-text">
        <i class="material-icons">group</i>
        Talentos que participan en la articulación.
    </span>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card card-transparent">
            <div class="row card-talent">
            @forelse ($actividad->articulacionpbt->talentos as $talento)
                <div class="col s12 m12 l4">
                    <div class="card bs-dark ">
                        <div class="card-content">
                            <span class="card-title p-h-lg"> {{$talento->user->present()->userDocumento()}} - {{$talento->user->present()->userFullName()}}</span>@if($talento->pivot->talento_lider == 1) <p class="orange-text p-h-lg">Talento Interlocutor</p>  @endif
                            <div class=" p-h-lg mail-date hide-on-med-and-down">  Acceso al sistema: {{$talento->user->present()->userAcceso()}}</div>
                        
                            <p class="hide-on-med-and-down p-h-lg"> Miembro desde {{$talento->user->present()->userCreatedAtFormat()}}</p>
                        </div>
                        <div class="card-action">
                            <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href="{{route('usuario.usuarios.show',$talento->user->documento)}}"><i class="material-icons left"> link</i>Ver más</a>
                            
                        </div>
                    </div>   
                </div>
            @empty
                <div class="row talent-empty">
                    <div class="col s12 m12 l12">
                        <div class="card card-transparent">
                            <div class="card-content">
                                <div class="search-result">
                                    <p class="search-result-description">Aún no se han agregado talentos</p>
                                </div>
                            </div>
                        </div>
                        <small id="talentos-error" class="error red-text"></small>
                    </div>
                </div>
            @endforelse
            </div>
        </div>
    </div> 
</div> 
<div class="center">
    <span class="mailbox-title orange-text">
        <i class="material-icons">attach_file</i>
        Evidencias de la fase de inicio.
    </span>
</div>
<div class="divider mailbox-divider"></div> 
<div class="row">
    @include('articulacionespbt.table-archive-fase', ['fase' => 'inicio'])
</div>