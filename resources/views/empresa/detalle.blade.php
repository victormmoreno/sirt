<div class="row">
    <div class="col s12 m12 l12">
        <div class="card mailbox-content">
            <div class="card-content">
                <div class="row no-m-t no-m-b">
                    <div class="col s12 m12 l12">
                        <div class="mailbox-view">
                            <div class="mailbox-text">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <div class="center">
                                            <span class="mailbox-title">
                                                Empresa {{$empresa->nombre}}
                                            </span>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="row">
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Talento que registró la empresa</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m12 l12">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <div class="row">
                                                                    <div class="col s12 m6 l6">
                                                                        <span class="title cyan-text text-darken-3">
                                                                            Nombres y apellidos del talento
                                                                        </span>
                                                                        <p>
                                                                            @if (isset($empresa->user))
                                                                                {{$empresa->user->nombres}} {{$empresa->user->apellidos}}
                                                                            @else
                                                                                No hay información disponible                                                                                
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                    <div class="col s12 m6 l6">
                                                                        <span class="title cyan-text text-darken-3">
                                                                            Correo de contacto
                                                                        </span>
                                                                        <p>
                                                                            @if (isset($empresa->user))
                                                                                {{$empresa->user->email}}
                                                                            @else
                                                                                No hay información disponible                                                                                
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Información de la empresa</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Nit y nombre de la empresa de proyecto
                                                                </span>
                                                                <p>
                                                                    {{$empresa->nit}} - {{$empresa->nombre}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Correo general de la empresa
                                                                </span>
                                                                <p>
                                                                @if ($empresa->email == null)
                                                                    No hay información disponible
                                                                @else
                                                                    {{$empresa->email}}
                                                                @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Sector al que pertenece
                                                                </span>
                                                                <p>
                                                                @if ($empresa->sector == null)
                                                                    No hay información disponible
                                                                @else
                                                                    {{$empresa->sector->nombre}}
                                                                @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col s12 m6 l6">
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Código CIIU de la actividad de la empresa
                                                                </span>
                                                                <p>
                                                                    {{$empresa->codigo_ciiu}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Fecha de creación de la empresa
                                                                </span>
                                                                <p>
                                                                    {{$empresa->fecha_creacion}}
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Tamaño de la empresa
                                                                </span>
                                                                <p>
                                                                @if ($empresa->tamanhoempresa == null)
                                                                    No hay información disponible
                                                                @else
                                                                    {{$empresa->tamanhoempresa->nombre}}
                                                                @endif
                                                                </p>
                                                            </li>
                                                            <li class="collection-item">
                                                                <span class="title cyan-text text-darken-3">
                                                                    Tipo de empresa
                                                                </span>
                                                                <p>
                                                                @if ($empresa->tipoempresa == null)
                                                                    No hay información disponible
                                                                @else
                                                                    {{$empresa->tipoempresa->nombre}}
                                                                @endif
                                                                </p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Sedes de la empresa</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m12 l12">
                                                        @foreach ($empresa->sedes as $sede)
                                                        <ul class="collection">
                                                            <li class="collection-item">
                                                                <div class="row">
                                                                    <div class="col s12 m5 l5">
                                                                        <span class="title cyan-text text-darken-3">
                                                                            Nombre de la sede
                                                                        </span>
                                                                        <p>
                                                                            {{$sede->nombre_sede}}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col s12 m5 l5">
                                                                        <span class="title cyan-text text-darken-3">
                                                                            Ciudad y dirección
                                                                        </span>
                                                                        <p>
                                                                            {{$sede->direccion}} - <b>{{$sede->ciudad->nombre}} ({{$sede->ciudad->departamento->nombre}})</b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="col s12 m2 l2">
                                                                        <a class="waves-effect waves-light btn-large" href="{{ route('empresa.edit.sedes', [$empresa->id, $sede->id]) }}">
                                                                            <i class="material-icons left">edit</i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        @endforeach
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h5>Ideas de proyecto asociadas a la empresa</h5></li>
                                                <li class="collection-item">
                                                    <div class="col s12 m12 l12">
                                                        @foreach ($empresa->sedes as $sede)
                                                            @foreach ($sede->ideas as $idea)
                                                            <ul class="collection">
                                                                <li class="collection-item">
                                                                    <div class="row">
                                                                        <div class="col s12 m6 l6">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Idea de proyecto
                                                                            </span>
                                                                            <p>
                                                                                {{$idea->codigo_idea}} - {{$idea->nombre_proyecto}}
                                                                            </p>
                                                                        </div>
                                                                        <div class="col s12 m6 l6">
                                                                            <span class="title cyan-text text-darken-3">
                                                                                Nodo de registro de la idea
                                                                            </span>
                                                                            <p>
                                                                                {{$idea->nodo->entidad->nombre}}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider mailbox-divider"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>