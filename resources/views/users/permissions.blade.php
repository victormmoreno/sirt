@extends('layouts.app')

@section('meta-title', 'Usuario | ' . $user->present()->userFullName())

@section('content')

    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align">
                    <h5 class="left-align primary-text">
                        <a class="footer-text left-align"
                            href="{{ route('usuario.show', $user->present()->userDocumento()) }}">
                            <i class="material-icons left">arrow_back</i>
                        </a>Usuarios
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('usuario.index') }}">Usuarios</a></li>
                        <li><a href="{{ route('usuario.show', $user->documento) }}">{{ $user->documento }}</a></li>
                        <li class="active">Cambiar permisos</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card mailbox-content">
                        <div class="card-content">
                            <div class="row no-m-t no-m-b">
                                <div class="col s12 m12 l12">
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="left mailbox-buttons">
                                                {!! $user->present()->userProfileUserImage() !!}
                                            </div>
                                            <div class="left">
                                                <p class="m-t-lg flow-text">{{ $user->present()->userFullName() }}</p>
                                                <span class="mailbox-title">{{ $user->present()->userYearOld() }}</span>
                                                @foreach ($user->getRoleNames() as $value)
                                                    <div class="chip m-t-sm blue-grey white-text"> {{ $value }}</div>
                                                @endforeach
                                                <div
                                                    class="position-top-right p f-12 mail-date show-on-large hide-on-med-and-down">
                                                    Miembro desde {{ $user->present()->userCreatedAtFormat() }}</div>
                                            </div>
                                        </div>
                                        <div class="divider mailbox-divider"></div>
                                        <div class="mailbox-text">
                                            <form id="form-update-role-nodo"
                                                action="{{ route('usuario.update-role-node', $user->documento) }}" method="POST"
                                                onsubmit="return checkSubmit()">
                                                {!! csrf_field() !!}
                                                {!! method_field('PUT') !!}
                                                <div class="row">
                                                    <div class="col s12 m3 l3">
                                                        @include('users.forms.role-input-checkbox')
                                                        <small id="role-error" class="error red-text"></small>
                                                    </div>
                                                    <div class="col s12 m9 l9">
                                                        @if (session()->has('status') || session()->has('error'))
                                                            <div class="center">
                                                                <div class="card  {{ session('status') ? 'bg-success' : '' }} {{ session('error') ? 'bg-danger' : '' }} white-text">
                                                                    <div class="row">
                                                                        <div class="col s12 m10">
                                                                            <div class="card-content white-text">
                                                                                <p>
                                                                                    <i
                                                                                        class="material-icons left">info_outline</i>
                                                                                    {{ session('status') ?: session('error') }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="row">
                                                            <section class="col s12 m12 l12">
                                                                <div class="card blue lighten-2 white-text p ">
                                                                    <div class="card-content">
                                                                        <p>Nota importante: si un funcionario tiene 2 o más roles en {{config('app.name')}} pero tiene solo un contrato firmado con la entidad SENA, se debe ingresar la misma información contractual para los roles asignados.</p>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-activator" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsActivador() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="activator_type_relationship"
                                                                                    name="activator_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="0" {{ isset($user->activador) && $user->activador->vinculacion == 0 && collect($user->roles)->contains('name', App\User::IsActivador()) ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ isset($user->activador) && $user->activador->vinculacion == 1 && collect($user->roles)->contains('name', App\User::IsActivador()) ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="activator_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 activator-field">
                                                                                <input id="activator_code_contract" name="activator_code_contract" type="text" value="{{ isset($user->activadorContratoLatest) &&  collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activadorContratoLatest->codigo : old('activator_code_contract') }}">
                                                                                <label for="activator_code_contract">Número de contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row ">
                                                                            <div class="input-field col s12 m6 l6 activator-field">
                                                                                <input id="activator_start_date_contract" name="activator_start_date_contract" type="text" value="{{ isset($user->activadorContratoLatest)  && collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activadorContratoLatest->fecha_inicio : old('activator_start_date_contract') }}">
                                                                                <label for="activator_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 activator-field">
                                                                                <input id="activator_end_date_contract" name="activator_end_date_contract" type="text" value="{{ isset($user->activadorContratoLatest)  && collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activadorContratoLatest->fecha_finalizacion : old('activator_end_date_contract') }}">
                                                                                <label for="activator_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_end_date_contract-error" class="error red-text"></small>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6 activator-field">
                                                                                <input id="activator_contract_value_contract" name="activator_contract_value_contract" type="text" value="{{ isset($user->activadorContratoLatest)  &&  collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activadorContratoLatest->valor_contrato : old('activator_contract_value_contract') }}">
                                                                                <label for="activator_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 activator-planta">
                                                                                <input id="activator_fees_contract" name="activator_fees_contract" type="text" value="{{ isset($user->activador->honorarios) && collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activador->honorarios : old('activator_fees_contract') }}">
                                                                                <label for="activator_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-dynamizer" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsDinamizador() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="dynamizer_node"
                                                                                    name="dynamizer_node"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    @if (session()->has('login_role') && (
                                                                                        session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsActivador()
                                                                                        )
                                                                                    )
                                                                                        <option value="">Seleccione Nodo</option>
                                                                                        @foreach ($nodos as $id => $nodo)
                                                                                            @if (isset($user->dinamizador->nodo->id) && collect($user->roles)->contains('name', App\User::IsDinamizador()))
                                                                                                <option
                                                                                                    value="{{ $id }}"
                                                                                                    {{ old('dynamizer_node', $user->dinamizador->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                    {{ $nodo }}
                                                                                                </option>
                                                                                            @else
                                                                                                <option
                                                                                                    value="{{ $id }}"
                                                                                                    {{ old('dynamizer_node') == $id ? 'selected' : '' }}>
                                                                                                    {{ $nodo }}
                                                                                                </option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @else
                                                                                        @if (isset($user->dinamizador->nodo->id) && collect($user->roles)->contains('name', App\User::IsDinamizador()))
                                                                                            <option
                                                                                                value="{{ $user->dinamizador->nodo->id }}"
                                                                                                selected>Tecnoparque Nodo
                                                                                                {{ $user->dinamizador->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endif
                                                                                </select>
                                                                                <label for="dynamizer_node" class="active">Nodo
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_node-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="dynamizer_type_relationship"
                                                                                    name="dynamizer_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    <option value="0" {{ isset($user->dinamizador) && $user->dinamizador->vinculacion == 0 && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? 'selected' : '' }}>Contratista</option>
                                                                                    <option value="1" {{ isset($user->dinamizador) && $user->dinamizador->vinculacion == 1 && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="dynamizer_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4 dynamizer-field">
                                                                                <input id="dynamizer_code_contract" name="dynamizer_code_contract" type="text" value="{{ isset($user->dinamizadorContrato) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->dinamizadorContratoLatest->codigo : old('dynamizer_code_contract') }}"
                                                                                {{ (isset($user->dinamizadorContrato) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_code_contract">Número de contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 dynamizer-field">
                                                                                <input id="dynamizer_start_date_contract" name="dynamizer_start_date_contract" type="text" value="{{ isset($user->dinamizadorContrato) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->dinamizadorContratoLatest->fecha_inicio : old('dynamizer_start_date_contract') }}"
                                                                                {{ (isset($user->dinamizadorContrato) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 dynamizer-field">
                                                                                <input id="dynamizer_end_date_contract"  name="dynamizer_end_date_contract" type="text" value="{{ isset($user->dinamizadorContrato)  && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->dinamizadorContratoLatest->fecha_finalizacion : old('dynamizer_end_date_contract') }}"
                                                                                {{ (isset($user->dinamizadorContrato) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6 dynamizer-field">
                                                                                <input id="dynamizer_contract_value_contract" name="dynamizer_contract_value_contract" type="text" value="{{ isset($user->dinamizadorContrato) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->dinamizadorContratoLatest->valor_contrato : old('dynamizer_contract_value_contract') }}"
                                                                                {{ (isset($user->dinamizadorContrato) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 dynamizer-planta">
                                                                                <input id="dynamizer_fees_contract" name="dynamizer_fees_contract" type="text" value="{{ isset($user->dinamizador) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->dinamizador->honorarios : old('dynamizer_fees_contract') }}"
                                                                                {{ (isset($user->dinamizador) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-expert" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsExperto() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="expert_node"
                                                                                    name="expert_node"
                                                                                    onchange="linea.getSelectLineForNodeExpert()"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    @if (session()->has('login_role') &&
                                                                                    (session()->get('login_role') == App\User::IsAdministrador() ||
                                                                                        session()->get('login_role') == App\User::IsActivador()))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            @foreach ($nodos as $id => $nodo)
                                                                                                @if (isset($user->experto->nodo->id) && collect($user->roles)->contains('name', App\User::IsExperto()))
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('expert_node', $user->experto->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('expert_node') == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                        @if (isset($user->experto->nodo->id) &&
                                                                                                session()->has('login_role') &&
                                                                                                collect($user->roles)->contains('name', App\User::IsExperto()))
                                                                                            <option
                                                                                                value="{{ $user->experto->nodo->id }}"
                                                                                                selected="">Tecnoparque Nodo
                                                                                                {{ $user->experto->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @elseif(session()->has('login_role') &&
                                                                                                session()->get('login_role') == App\User::IsDinamizador() &&
                                                                                                isset(auth()->user()->dinamizador->nodo->id))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            <option
                                                                                                value="{{ auth()->user()->dinamizador->nodo->id }}">
                                                                                                Tecnoparque Nodo {{ auth()->user()->dinamizador->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @endif
                                                                                </select>
                                                                                <label for="expert_node" class="active">Nodo
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_node-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2"
                                                                                    id="expert_line" name="expert_line"
                                                                                    style="width: 100%" tabindex="-1">
                                                                                    @if(isset($user->experto->linea->id) && session()->get('login_role') == App\User::IsExperto() && collect($user->roles)->contains('name',App\User::IsExperto()))
                                                                                    <option value="{{$user->experto->linea->id}}" selected>{{$user->experto->linea->nombre}}</option>
                                                                                    @else
                                                                                        @foreach($lineas as $id => $linea)
                                                                                            @if(isset($user->experto->linea->id) && collect($user->roles)->contains('name',App\User::IsExperto()))
                                                                                                <option value="{{$id}}" {{old('expert_line',$user->experto->linea->id) ==  $id ? 'selected':''}} >{{$linea}}</option>
                                                                                            @else
                                                                                                <option value="{{$id}}" {{old('expert_line') ==  $id ? 'selected':''}}>{{$linea}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif

                                                                                </select>
                                                                                <label for="expert_line" class="active">Línea <span class="red-text">*</span></label>
                                                                                <small id="expert_line-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="expert_type_relationship"
                                                                                    name="expert_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="0" {{ isset($user->experto) && $user->experto->vinculacion == 0 && collect($user->roles)->contains('name', App\User::IsExperto()) ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ isset($user->experto) && $user->experto->vinculacion == 1 && collect($user->roles)->contains('name', App\User::IsExperto()) ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="expert_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4 expert-field">
                                                                                <input id="expert_code_contract" name="expert_code_contract" type="text" value="{{ isset($user->expertoContratoLatest) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->expertoContratoLatest->codigo : old('expert_code_contract') }}"
                                                                                {{ (isset($user->expertoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_code_contract">Número de contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 expert-field">
                                                                                <input id="expert_start_date_contract" name="expert_start_date_contract" type="text" value="{{ isset($user->expertoContratoLatest) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->expertoContratoLatest->fecha_inicio : old('expert_start_date_contract') }}"
                                                                                {{ (isset($user->expertoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 expert-field">
                                                                                <input id="expert_end_date_contract" name="expert_end_date_contract" type="text" value="{{ isset($user->expertoContratoLatest) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->expertoContratoLatest->fecha_finalizacion : old('expert_end_date_contract') }}"
                                                                                {{ (isset($user->expertoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6 expert-field">
                                                                                <input id="expert_contract_value_contract" name="expert_contract_value_contract" type="text" value="{{ isset($user->expertoContratoLatest)  && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->expertoContratoLatest->valor_contrato : old('expert_contract_value_contract') }}"
                                                                                {{ (isset($user->expertoContratoLatest)  && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 expert-planta">
                                                                                <input id="expert_fees_contract" name="expert_fees_contract" type="text" value="{{ isset($user->experto) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->honorarios : old('expert_fees_contract') }}"
                                                                                {{ (isset($user->experto) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-articulator" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsArticulador() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="articulator_node"
                                                                                    name="articulator_node"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    @if (session()->has('login_role') &&
                                                                                    (session()->get('login_role') == App\User::IsAdministrador() ||
                                                                                        session()->get('login_role') == App\User::IsActivador()))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            @foreach ($nodos as $id => $nodo)
                                                                                                @if (isset($user->articulador->nodo->id) && collect($user->roles)->contains('name', App\User::IsExperto()))
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('articulator_node', $user->articulador->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('articulator_node') == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                        @if (isset($user->articulador->nodo->id) &&
                                                                                                session()->has('login_role') &&
                                                                                                collect($user->roles)->contains('name', App\User::IsArticulador()))
                                                                                            <option
                                                                                                value="{{ $user->articulador->nodo->id }}"
                                                                                                selected="">Tecnoparque Nodo
                                                                                                {{ $user->articulador->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @elseif(session()->has('login_role') &&
                                                                                                session()->get('login_role') == App\User::IsDinamizador() &&
                                                                                                isset(auth()->user()->dinamizador->nodo->id))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            <option
                                                                                                value="{{ auth()->user()->dinamizador->nodo->id }}">
                                                                                                Tecnoparque Nodo {{ auth()->user()->dinamizador->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @endif
                                                                                </select>
                                                                                <label for="articulator_node" class="active">Nodo
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_node-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="articulator_type_relationship"
                                                                                    name="articulator_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="0" {{ isset($user->articulador) && $user->articulador->vinculacion == 0 && collect($user->roles)->contains('name', App\User::IsArticulador()) ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ isset($user->articulador) && $user->articulador->vinculacion == 1 && collect($user->roles)->contains('name', App\User::IsArticulador()) ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="articulator_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4 articulator-field">
                                                                                <input id="articulator_code_contract" name="articulator_code_contract" type="text" value="{{ isset($user->articuladorContratoLatest) && collect($user->roles)->contains('name', App\User::IsArticulador()) ? $user->articuladorContratoLatest->codigo : old('articulator_code_contract') }}"
                                                                                {{ (isset($user->articuladorContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_code_contract">Número de contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 articulator-field">
                                                                                <input id="articulator_start_date_contract" name="articulator_start_date_contract" type="text" value="{{ isset($user->articuladorContratoLatest) && collect($user->roles)->contains('name', App\User::IsArticulador()) ? $user->articuladorContratoLatest->fecha_inicio : old('articulator_start_date_contract') }}"
                                                                                {{ (isset($user->articuladorContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 articulator-field">
                                                                                <input id="articulator_end_date_contract" name="articulator_end_date_contract" type="text" value="{{ isset($user->articuladorContratoLatest) && collect($user->roles)->contains('name', App\User::IsArticulador()) ? $user->articuladorContratoLatest->fecha_finalizacion : old('articulator_end_date_contract') }}"
                                                                                {{ (isset($user->articuladorContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6 articulator-field">
                                                                                <input id="articulator_contract_value_contract" name="articulator_contract_value_contract" type="text" value="{{ isset($user->articuladorContratoLatest) && collect($user->roles)->contains('name', App\User::IsArticulador()) ? $user->articuladorContratoLatest->valor_contrato : old('articulator_contract_value_contract') }}"
                                                                                {{ (isset($user->articuladorContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 articulator-planta">
                                                                                <input id="articulator_fees_contract" name="articulator_fees_contract" type="text" value="{{ isset($user->articulador) && collect($user->roles)->contains('name', App\User::IsArticulador()) ? $user->articulador->honorarios : old('articulator_fees_contract') }}"
                                                                                {{ (isset($user->articulador) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-infocenter" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsInfocenter() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="infocenter_node"
                                                                                    name="infocenter_node"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    @if (session()->has('login_role') &&
                                                                                    (session()->get('login_role') == App\User::IsAdministrador() ||
                                                                                        session()->get('login_role') == App\User::IsActivador()))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            @foreach ($nodos as $id => $nodo)
                                                                                                @if (isset($user->infocenter->nodo->id) && collect($user->roles)->contains('name', App\User::IsExperto()))
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('infocenter_node', $user->infocenter->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('infocenter_node') == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                        @if (isset($user->infocenter->nodo->id) && session()->has('login_role') && collect($user->roles)->contains('name', App\User::IsInfocenter()))
                                                                                            <option
                                                                                                value="{{ $user->infocenter->nodo->id }}"
                                                                                                selected="">Tecnoparque Nodo {{ $user->infocenter->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @elseif(session()->has('login_role') &&
                                                                                                session()->get('login_role') == App\User::IsDinamizador() &&
                                                                                                isset(auth()->user()->dinamizador->nodo->id))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            <option
                                                                                                value="{{ auth()->user()->dinamizador->nodo->id }}">
                                                                                                Tecnoparque Nodo {{ auth()->user()->dinamizador->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @endif
                                                                                </select>
                                                                                <label for="infocenter_node" class="active">Nodo
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_node-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="infocenter_type_relationship"
                                                                                    name="infocenter_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="0" {{ isset($user->infocenter) && $user->infocenter->vinculacion == 0 && collect($user->roles)->contains('name', App\User::IsInfocenter()) ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ isset($user->infocenter) && $user->infocenter->vinculacion == 1 && collect($user->roles)->contains('name', App\User::IsInfocenter()) ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="infocenter_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4 infocenter-field">
                                                                                <input id="infocenter_code_contract" name="infocenter_code_contract" type="text" value="{{ isset($user->infocenterContratoLatest) && collect($user->roles)->contains('name', App\User::IsInfocenter()) ? $user->infocenterContratoLatest->codigo : old('infocenter_code_contract') }}"
                                                                                {{ (isset($user->infocenterContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_code_contract">Número de contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 infocenter-field">
                                                                                <input id="infocenter_start_date_contract" name="infocenter_start_date_contract" type="text" value="{{ isset($user->infocenterContratoLatest) && collect($user->roles)->contains('name', App\User::IsInfocenter()) ? $user->infocenterContratoLatest->fecha_inicio : old('infocenter_start_date_contract') }}"
                                                                                {{ (isset($user->infocenterContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 infocenter-field">
                                                                                <input id="infocenter_end_date_contract" name="infocenter_end_date_contract" type="text" value="{{ isset($user->infocenterContratoLatest) && collect($user->roles)->contains('name', App\User::IsInfocenter()) ? $user->infocenterContratoLatest->fecha_finalizacion : old('infocenter_end_date_contract') }}"
                                                                                {{ (isset($user->infocenterContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6 infocenter-field">
                                                                                <input id="infocenter_contract_value_contract" name="infocenter_contract_value_contract" type="text" value="{{ isset($user->infocenterContratoLatest) && collect($user->roles)->contains('name', App\User::IsInfocenter()) ? $user->infocenterContratoLatest->valor_contrato : old('infocenter_contract_value_contract') }}"
                                                                                {{ (isset($user->infocenterContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 infocenter-planta">
                                                                                <input id="infocenter_fees_contract" name="infocenter_fees_contract" type="text" value="{{ isset($user->infocenter) && collect($user->roles)->contains('name', App\User::IsInfocenter()) ? $user->infocenter->honorarios : old('infocenter_fees_contract') }}"
                                                                                {{ (isset($user->infocenter) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-technical_support" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsApoyoTecnico() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="technical_support_node"
                                                                                    name="technical_support_node"
                                                                                    onchange="linea.getSelectLineForNodeTechnicalSupport()"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    @if (session()->has('login_role') &&
                                                                                    (session()->get('login_role') == App\User::IsAdministrador() ||
                                                                                        session()->get('login_role') == App\User::IsActivador()))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            @foreach ($nodos as $id => $nodo)
                                                                                                @if (isset($user->apoyotecnico->nodo->id) && collect($user->roles)->contains('name', App\User::IsExperto()))
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('technical_support_node', $user->articulador->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('technical_support_node') == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                        @if (isset($user->apoyotecnico->nodo->id) && session()->has('login_role') && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()))
                                                                                            <option
                                                                                                value="{{ $user->apoyotecnico->nodo->id }}"
                                                                                                selected="">Tecnoparque Nodo {{ $user->apoyotecnico->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @elseif(session()->has('login_role') &&
                                                                                                session()->get('login_role') == App\User::IsDinamizador() &&
                                                                                                isset(auth()->user()->dinamizador->nodo->id))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            <option
                                                                                                value="{{ auth()->user()->dinamizador->nodo->id }}">
                                                                                                Tecnoparque Nodo {{ auth()->user()->dinamizador->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @endif
                                                                                </select>
                                                                                <label for="technical_support_node" class="active">Nodo
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="technical_support_node-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2"
                                                                                    id="technical_support_line" name="technical_support_line"
                                                                                    style="width: 100%" tabindex="-1">
                                                                                    @if(isset($user->apoyotecnico->linea->id) && session()->get('login_role') == App\User::IsExperto() && collect($user->roles)->contains('name',App\User::IsApoyoTecnico()))
                                                                                    <option value="{{$user->apoyotecnico->linea->id}}" selected>{{$user->apoyotecnico->linea->nombre}}</option>
                                                                                    @else
                                                                                        @foreach($lineas as $id => $linea)
                                                                                            @if(isset($user->apoyotecnico->linea->id) && collect($user->roles)->contains('name',App\User::IsApoyoTecnico()))
                                                                                                <option value="{{$id}}" {{old('technical_support_line',$user->apoyotecnico->linea->id) ==  $id ? 'selected':''}} >{{$linea}}</option>
                                                                                            @else
                                                                                                <option value="{{$id}}" {{old('technical_support_line') ==  $id ? 'selected':''}}>{{$linea}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    @endif
                                                                                </select>
                                                                                <label for="technical_support_line" class="active">LÍnea <span class="red-text">*</span></label>
                                                                                <small id="technical_support_line-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="technical_support_type_relationship"
                                                                                    name="technical_support_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="0" {{ isset($user->apoyotecnico) && $user->apoyotecnico->vinculacion == 0 && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ isset($user->apoyotecnico) && $user->apoyotecnico->vinculacion == 1 && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="technical_support_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="technical_support_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4 technical_support-field">
                                                                                <input id="technical_support_code_contract" name="technical_support_code_contract" type="text" value="{{ isset($user->apoyoTecnicoContratoLatest) && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) ? $user->apoyoTecnicoContratoLatest->codigo : old('technical_support_code_contract') }}"
                                                                                {{ (isset($user->apoyoTecnicoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->apoyotecnico->nodo->id) && $user->apoyotecnico->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="technical_support_code_contract">Número de contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="technical_support_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 technical_support-field">
                                                                                <input id="technical_support_start_date_contract" name="technical_support_start_date_contract" type="text" value="{{ isset($user->apoyoTecnicoContratoLatest) && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) ? $user->apoyoTecnicoContratoLatest->fecha_inicio : old('technical_support_start_date_contract') }}"
                                                                                {{ (isset($user->apoyoTecnicoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->apoyotecnico->nodo->id) && $user->apoyotecnico->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="technical_support_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="technical_support_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 technical_support-field">
                                                                                <input id="technical_support_end_date_contract" name="technical_support_end_date_contract" type="text" value="{{ isset($user->apoyoTecnicoContratoLatest) && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) ? $user->apoyoTecnicoContratoLatest->fecha_finalizacion : old('technical_support_end_date_contract') }}"
                                                                                {{ (isset($user->apoyoTecnicoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->apoyotecnico->nodo->id) && $user->apoyotecnico->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="technical_support_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="technical_support_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6 technical_support-field">
                                                                                <input id="technical_support_contract_value_contract" name="technical_support_contract_value_contract" type="text" value="{{ isset($user->apoyoTecnicoContratoLatest) && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) ? $user->apoyoTecnicoContratoLatest->valor_contrato : old('technical_support_contract_value_contract') }}"
                                                                                {{ (isset($user->apoyoTecnicoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->apoyotecnico->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="technical_support_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="technical_support_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 technical_support-planta">
                                                                                <input id="technical_support_fees_contract" name="technical_support_fees_contract" type="text" value="{{ isset($user->apoyotecnico) && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()) ? $user->apoyotecnico->honorarios : old('technical_support_fees_contract') }}"
                                                                                {{ (isset($user->apoyotecnico) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->apoyotecnico->nodo->id) && $user->apoyotecnico->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="technical_support_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="technical_support_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-income" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsIngreso() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="income_node"
                                                                                    name="income_node"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    @if (session()->has('login_role') &&
                                                                                    (session()->get('login_role') == App\User::IsAdministrador() ||
                                                                                        session()->get('login_role') == App\User::IsActivador()))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            @foreach ($nodos as $id => $nodo)
                                                                                                @if (isset($user->ingreso->nodo->id) && collect($user->roles)->contains('name', App\User::IsIngreso()))
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('income_node', $user->ingreso->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('income_node') == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        @endif
                                                                                        @if (isset($user->ingreso->nodo->id) && session()->has('login_role') && collect($user->roles)->contains('name', App\User::IsIngreso()))
                                                                                            <option
                                                                                                value="{{ $user->ingreso->nodo->id }}"
                                                                                                selected="">Tecnoparque Nodo {{ $user->ingreso->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @elseif(session()->has('login_role') &&
                                                                                                session()->get('login_role') == App\User::IsDinamizador() &&
                                                                                                isset(auth()->user()->dinamizador->nodo->id))
                                                                                            <option value="">Seleccione Nodo</option>
                                                                                            <option
                                                                                                value="{{ auth()->user()->dinamizador->nodo->id }}">
                                                                                                Tecnoparque Nodo {{ auth()->user()->dinamizador->nodo->entidad->nombre }}
                                                                                            </option>
                                                                                        @endif
                                                                                </select>
                                                                                <label for="income_node" class="active">Nodo
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="income_node-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="income_type_relationship"
                                                                                    name="income_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="0" {{ isset($user->ingreso) && $user->ingreso->vinculacion == 0 && collect($user->roles)->contains('name', App\User::IsIngreso()) ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ isset($user->ingreso) && $user->ingreso->vinculacion == 1 && collect($user->roles)->contains('name', App\User::IsIngreso()) ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="income_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="income_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4 income-field">
                                                                                <input id="income_code_contract" name="income_code_contract" type="text" value="{{ isset($user->ingresoContratoLatest) && collect($user->roles)->contains('name', App\User::IsIngreso()) ? $user->ingresoContratoLatest->codigo : old('income_code_contract') }}"
                                                                                {{ (isset($user->ingresoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $user->ingreso->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="income_code_contract">Número de contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="income_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 income-field">
                                                                                <input id="income_start_date_contract" name="income_start_date_contract" type="text" value="{{ isset($user->ingresoContratoLatest) && collect($user->roles)->contains('name', App\User::IsIngreso()) ? $user->ingresoContratoLatest->fecha_inicio : old('income_start_date_contract') }}"
                                                                                {{ (isset($user->ingresoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $user->ingreso->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="income_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="income_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4 income-field">
                                                                                <input id="income_end_date_contract" name="income_end_date_contract" type="text" value="{{ isset($user->ingresoContratoLatest) && collect($user->roles)->contains('name', App\User::IsIngreso()) ? $user->ingresoContratoLatest->fecha_finalizacion : old('income_end_date_contract') }}"
                                                                                {{ (isset($user->ingresoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $user->ingreso->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="income_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="income_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6 income-field">
                                                                                <input id="income_contract_value_contract" name="income_contract_value_contract" type="text" value="{{ isset($user->ingresoContratoLatest) && collect($user->roles)->contains('name', App\User::IsIngreso()) ? $user->ingresoContratoLatest->valor_contrato : old('income_contract_value_contract') }}"
                                                                                {{ (isset($user->ingresoContratoLatest) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $user->ingreso->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="income_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="income_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6 income-planta">
                                                                                <input id="income_fees_contract" name="income_fees_contract" type="text" value="{{ isset($user->ingreso) && collect($user->roles)->contains('name', App\User::IsIngreso()) ? $user->ingreso->honorarios : old('income_fees_contract') }}"
                                                                                {{ (isset($user->ingreso) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->ingreso->nodo->id) && $user->ingreso->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="income_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="income_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                            <section id="section-talent" class="col s12 m12 l12" style="display: none;">
                                                                @include('users.forms.talent-type-information')
                                                            </section>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 m8 l8 offset-l4 offset-m4">
                                                        <div class="divider mailbox-divider m-b-5">
                                                        </div>
                                                        <div class="center">
                                                            <button type="submit"
                                                                class="waves-effect waves-teal darken-2 btn-flat m-t-xs">
                                                                Guardar cambios
                                                            </button>
                                                            <a href="{{ route('home') }}"
                                                                class="waves-effect waves-red btn-flat m-t-xs">
                                                                cancelar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#activator_end_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate);
            $('#activator_start_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate).on('change', function(e, date) {
                $('#activator_end_date_contract').bootstrapMaterialDatePicker('setMinDate', date);
            });
            //dynamizer datePicker
            $('#dynamizer_end_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate);
            $('#dynamizer_start_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate).on('change', function(e, date) {
                $('#dynamizer_end_date_contract').bootstrapMaterialDatePicker('setMinDate', date);
            });

            $('#expert_end_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate);
            $('#expert_start_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate).on('change', function(e, date) {
                $('#expert_end_date_contract').bootstrapMaterialDatePicker('setMinDate', date);
            });

            $('#articulator_end_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate);
            $('#articulator_start_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate).on('change', function(e, date) {
                $('#articulator_end_date_contract').bootstrapMaterialDatePicker('setMinDate', date);
            });

            $('#infocenter_end_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate);
            $('#infocenter_start_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate).on('change', function(e, date) {
                $('#infocenter_end_date_contract').bootstrapMaterialDatePicker('setMinDate', date);
            });

            $('#technical_support_end_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate);
            $('#technical_support_start_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate).on('change', function(e, date) {
                $('#technical_support_end_date_contract').bootstrapMaterialDatePicker('setMinDate', date);
            });

            $('#income_end_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate);
            $('#income_start_date_contract').bootstrapMaterialDatePicker(configbootstrapMaterialDatePickerRangeDate).on('change', function(e, date) {
                $('#income_end_date_contract').bootstrapMaterialDatePicker('setMinDate', date);
            });

            $("#activator_type_relationship").change(function (event) {
                if(event.target.value == 1){
                    $('.activator-field').hide();
                    $( ".activator-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 activator-planta" );
                    $(this).parent().removeClass('input-field col s12 m6 l6').addClass( "input-field col s12 m12 l12" )
                }else{
                    $('.activator-field').show();
                    $( ".activator-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 activator-planta" );
                    $(this).parent().removeClass('input-field col s12 m12 l12').addClass( "input-field col s12 m6 l6" )
                }
            });

            $("#dynamizer_type_relationship").change(function (event) {
                if(event.target.value == 1){
                    $('.dynamizer-field').hide();
                    $( ".dynamizer-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 dynamizer-planta" );
                }else{
                    $('.dynamizer-field').show();
                    $( ".dynamizer-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 dynamizer-planta" );
                }
            });

            $("#expert_type_relationship").change(function (event) {
                if(event.target.value == 1){
                    $('.expert-field').hide();
                    $( ".expert-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 expert-planta" );
                }else{
                    $('.expert-field').show();
                    $( ".expert-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 expert-planta" );
                }
            });

            $("#articulator_type_relationship").change(function (event) {
                if(event.target.value == 1){
                    $('.articulator-field').hide();
                    $( ".articulator-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 articulator-planta" );
                }else{
                    $('.articulator-field').show();
                    $( ".articulator-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 articulator-planta" );
                }
            });

            $("#technical_support_type_relationship").change(function (event) {
                if(event.target.value == 1){
                    $('.technical_support-field').hide();
                    $( ".technical_support-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 technical_support-planta" );
                }else{
                    $('.technical_support-field').show();
                    $( ".technical_support-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 technical_support-planta" );
                }
            });

            $("#infocenter_type_relationship").change(function (event) {
                if(event.target.value == 1){
                    $('.infocenter-field').hide();
                    $( ".infocenter-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 infocenter-planta" );
                }else{
                    $('.infocenter-field').show();
                    $( ".infocenter-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 infocenter-planta" );
                }
            });
            $("#income_type_relationship").change(function (event) {
                if(event.target.value == 1){
                    $('.income-field').hide();
                    $( ".income-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 income-planta" );
                }else{
                    $('.income-field').show();
                    $( ".income-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 income-planta" );
                }
            });

            @if (isset($user->activador->vinculacion))
                roles.getVinculacionActivatorSelected();
            @endif
            @if (isset($user->dinamizador->vinculacion))
                roles.getVinculacionDynamizerSelected();
            @endif
            @if (isset($user->experto->vinculacion))
                roles.getVinculacionExpertSelected();
            @endif
            @if (isset($user->articulador->vinculacion))
                roles.getVinculacionArticulatorSelected();
            @endif
            @if (isset($user->apoyotecnico->vinculacion))
                roles.getVinculacionTechnicalSupportSelected();
            @endif
            @if (isset($user->infocenter->vinculacion))
                roles.getVinculacionInfocenterSelected();
            @endif
            @if (isset($user->ingreso->vinculacion))
                roles.getVinculacionIncomeSelected();
            @endif

            roles.getRoleSeleted();
            @if (isset($user->informacion_user['talento']["tipo_talento"]))
                tipoTalento.getSelectTipoTalento('{{ $user->informacion_user["talento"]["tipo_talento"] }}');
            @endif
            @if (isset($user->informacion_user['talento']['regional']))
                tipoTalento.getCentroFormacion();
            @endif
            @if (isset($user->gestor->nodo->lineas->id))
                linea.getSelectLineForNodeExpert();
            @endif
        });

        const roles = {
            getRoleSeleted: function(idrol) {
                $('#section-activator').hide();
                $('#section-dynamizer').hide();
                $('#section-expert').hide();
                $('#section-articulator').hide();
                $('#section-infocenter').hide();
                $('#section-technical_support').hide();
                $('#section-talent').hide();
                $('#section-income').hide();
                $("input[type=checkbox]:checked").each(function() {
                    if ($(this).val() == '{{ App\User::IsActivador() }}') {
                        $('#section-activator').show();
                    } else if ($(this).val() == '{{ App\User::IsAdministrador() }}') {
                    } else if ($(this).val() == '{{ App\User::IsApoyoTecnico() }}') {
                        $('#section-technical_support').show();
                    } else if ($(this).val() == '{{ App\User::IsArticulador() }}') {
                        $('#section-articulator').show();
                    } else if ($(this).val() == '{{ App\User::IsDinamizador() }}') {
                        $('#section-dynamizer').show();
                    } else if ($(this).val() == '{{ App\User::IsExperto() }}') {
                        $('#section-expert').show();
                    } else if ($(this).val() == '{{ App\User::IsInfocenter() }}') {
                        $('#section-infocenter').show();
                    } else if ($(this).val() == '{{ App\User::IsTalento() }}') {
                        $('#section-talent').show();
                    } else if ($(this).val() == '{{ App\User::IsIngreso() }}') {
                        $('#section-income').show();
                    }else if ($(this).val() == '{{ App\User::IsUsuario() }}') {
                    }
                });
                if ($('#section-activator').css('display') === 'block') {
                    @if ($errors->any())
                        $("#activator_code_contract").val("{{ old('activator_code_contract') }}");
                        $("#activator_start_date_contract").val("{{ old('activator_start_date_contract') }}");
                        $("#activator_end_date_contract").val("{{ old('activator_end_date_contract') }}");
                        $("#activator_type_relationship").val("{{ old('activator_type_relationship') }}");
                        $("#activator_contract_value_contract").val("{{ old('activator_contract_value_contract') }}");
                        $("#activator_fees_contract").val("{{ old('activator_fees_contract') }}");
                    @else
                        $("#activator_code_contract").val();
                        $("#activator_start_date_contract").val();
                        $("#activator_end_date_contract").val();
                        $("#activator_type_relationship").val();
                        $("#activator_contract_value_contract").val();
                        $("#activator_fees_contract").val();
                    @endif
                    $("#activator_type_relationship").material_select();
                }
            },
            getVinculacionActivatorSelected: function (){
                let nameVinculacionActivator = $("#activator_type_relationship option:selected").text();
                if((String(nameVinculacionActivator.trim()) == String('Planta')))
                {
                    $('.activator-field').hide();
                    $( ".activator-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 activator-planta" );
                    $(this).parent().removeClass('input-field col s12 m6 l6').addClass( "input-field col s12 m12 l12" )
                }else{
                    $('.activator-field').show();
                    $( ".activator-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 activator-planta" );
                    $(this).parent().removeClass('input-field col s12 m12 l12').addClass( "input-field col s12 m6 l6" )
                }
            },
            getVinculacionDynamizerSelected: function (){
                let nameVinculacionDynamizer = $("#dynamizer_type_relationship option:selected").text();
                if((String(nameVinculacionDynamizer.trim()) == String('Planta')))
                {
                    $('.dynamizer-field').hide();
                    $( ".dynamizer-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 dynamizer-planta" );
                }else{
                    $('.dynamizer-field').show();
                    $( ".dynamizer-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 dynamizer-planta" );
                }
            },
            getVinculacionExpertSelected: function (){
                let nameVinculacionExpert = $("#expert_type_relationship option:selected").text();
                if((String(nameVinculacionExpert.trim()) == String('Planta')))
                {
                    $('.expert-field').hide();
                    $( ".expert-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 expert-planta" );
                }else{
                    $('.expert-field').show();
                    $( ".expert-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 expert-planta" );
                }
            },
            getVinculacionArticulatorSelected: function (){
                let nameVinculacionArticulator = $("#articulator_type_relationship option:selected").text();
                if((String(nameVinculacionArticulator.trim()) == String('Planta')))
                {
                    $('.articulator-field').hide();
                    $( ".articulator-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 articulator-planta" );
                }else{
                    $('.articulator-field').show();
                    $( ".articulator-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 articulator-planta" );
                }
            },
            getVinculacionTechnicalSupportSelected: function (){
                let nameVinculacionTechnicalSupport = $("#technical_support_type_relationship option:selected").text();
                if((String(nameVinculacionTechnicalSupport.trim()) == String('Planta')))
                {
                    $('.technical_support-field').hide();
                    $( ".technical_support-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 technical_support-planta" );
                }else{
                    $('.technical_support-field').show();
                    $( ".technical_support-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 technical_support-planta" );
                }
            },
            getVinculacionInfocenterSelected: function (){
                let nameVinculacionInfocenter = $("#infocenter_type_relationship option:selected").text();
                if((String(nameVinculacionInfocenter.trim()) == String('Planta')))
                {
                    $('.infocenter-field').hide();
                    $( ".infocenter-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 infocenter-planta" );
                }else{
                    $('.infocenter-field').show();
                    $( ".infocenter-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 infocenter-planta" );
                }
            },
            getVinculacionIncomeSelected: function (){
                let nameVinculacionIncome = $("#income_type_relationship option:selected").text();
                if((String(nameVinculacionIncome.trim()) == String('Planta')))
                {
                    $('.income-field').hide();
                    $( ".income-planta" ).removeClass( "input-field col s12 m6 l6" ).addClass( "input-field col s12 m12 l12 income-planta" );
                }else{
                    $('.income-field').show();
                    $( ".income-planta" ).removeClass( "input-field col s12 m12 l12" ).addClass( "input-field col s12 m6 l6 income-planta" );
                }
            },

        };
        const linea = {
            getSelectLineForNodeExpert: function() {
                let node = $('#expert_node').val();
                if(node != null || node != ''){
                    $.ajax({
                        dataType: 'json',
                        type: 'get',
                        url: `${host_url}/lineas/getlineasnodo/${node}`
                    }).done(function(response) {
                        $('#expert_line').empty();
                        if (response.lineasForNodo.lineas == '') {
                            $('#expert_line').append('<option value="">No hay lineas disponibles</option>');
                        } else {
                            $('#expert_line').append('<option value="">Seleccione la linea</option>');
                            $.each(response.lineasForNodo.lineas, function(i, e) {
                                $('#expert_line').append('<option  value="' + e.id + '">' + e.nombre +
                                    '</option>');
                                @if (isset($user->experto))
                                    $('#expert_line').select2('val','{{ $user->experto->linea_id }}');
                                @endif
                            });
                            @if ($errors->any())
                                $('#expert_line').val("{{ old('expert_line') }}");
                            @endif
                        }
                        $('#expert_line').material_select();
                    });
                }
            },
            getSelectLineForNodeTechnicalSupport: function() {
                let node = $('#technical_support_node').val();
                if(node != null || node != ''){
                    $.ajax({
                        dataType: 'json',
                        type: 'get',
                        url: `${host_url}/lineas/getlineasnodo/${node}`
                    }).done(function(response) {
                        $('#technical_support_line').empty();
                        if (response.lineasForNodo.lineas == '') {
                            $('#technical_support_line').append('<option value="">No hay lineas disponibles</option>');
                        } else {
                            $('#technical_support_line').append('<option value="">Seleccione la linea</option>');
                            $.each(response.lineasForNodo.lineas, function(i, e) {
                                $('#technical_support_line').append('<option  value="' + e.id + '">' + e.nombre +
                                    '</option>');
                                @if (isset($user->apoyotecnico))
                                    $('#technical_support_line').select2('val','{{ $user->apoyotecnico->linea_id }}');
                                @endif
                            });
                            @if ($errors->any())
                                $('#technical_support_line').val("{{ old('technical_support_line') }}");
                            @endif
                        }
                        $('#technical_support_line').material_select();
                    });
                }
            },
        }
        const tipoTalento = {
            getSelectTipoTalento: function(idtipotalento) {

                let nameTalentType = $("#talent_type option:selected").text();
                if ((String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_APRENDIZ_SENA_CON_APOYO }}') ||
                    String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO }}'))) {
                    tipoTalento.showAprendizSena();
                } else if (String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_EGRESADO_SENA }}')) {
                    tipoTalento.showEgresadoSena();
                } else if (String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_INSTRUCTOR_SENA }}')) {
                    tipoTalento.showInstructorSena();
                } else if (String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_FUNCIONARIO_SENA }}')) {
                    tipoTalento.showFuncionarioSena();
                } else if (String(nameTalentType.trim()) == String("{{ App\Models\TipoTalento::IS_PROPIETARIO_EMPRESA }}")) {
                    tipoTalento.showPropietarioEmpresa();
                } else if (String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_EMPRENDEDOR }}')) {
                    tipoTalento.showEmprendedor();
                } else if (String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO }}')) {
                    tipoTalento.showUniversitario();
                } else if (String(nameTalentType.trim()) == String('{{ App\Models\TipoTalento::IS_FUNCIONARIO_EMPRESA }}')) {
                    tipoTalento.showFuncionarioEmpresa();
                }else{
                    tipoTalento.showEmprendedor();
                }
            },
            showAprendizSena: function() {
                $(".regional_centro").css("display","block");
                $(".programa").css("display","block");
                $(".tipo_formacion").css("display","none");
                $(".dependencia").css("display","none");
                $(".empresa").css("display","none");
                $(".tipo_estudio_universidad_carrera").css("display","none");
            },
            showEgresadoSena: function() {
                $(".regional_centro").css("display","block");
                $(".programa").css("display","block");
                $(".tipo_formacion").css("display","block");
                $(".dependencia").css("display","none");
                $(".empresa").css("display","none");
                $(".tipo_estudio_universidad_carrera").css("display","none");

            },
            showInstructorSena: function() {
                $(".regional_centro").css("display","block");
                $(".programa").css("display","none");
                $(".tipo_formacion").css("display","none");
                $(".dependencia").css("display","none");
                $(".empresa").css("display","none");
                $(".tipo_estudio_universidad_carrera").css("display","none");
            },
            showFuncionarioSena: function() {
                $(".regional_centro").css("display","block");
                $(".programa").css("display","none");
                $(".tipo_formacion").css("display","none");
                $(".dependencia").css("display","block");
                $(".empresa").css("display","none");
                $(".tipo_estudio_universidad_carrera").css("display","none");
            },
            showPropietarioEmpresa: function() {
                $(".regional_centro").css("display","none");
                $(".programa").css("display","none");
                $(".tipo_formacion").css("display","none");
                $(".dependencia").css("display","none");
                $(".empresa").css("display","block");
                $(".tipo_estudio_universidad_carrera").css("display","none");
            },
            showEmprendedor: function() {
                $(".regional_centro").css("display","none");
                $(".programa").css("display","none");
                $(".tipo_formacion").css("display","none");
                $(".dependencia").css("display","none");
                $(".empresa").css("display","none");
                $(".tipo_estudio_universidad_carrera").css("display","none");
            },
            showUniversitario: function() {
                $(".regional_centro").css("display","none");
                $(".programa").css("display","none");
                $(".tipo_formacion").css("display","none");
                $(".dependencia").css("display","none");
                $(".empresa").css("display","none");
                $(".tipo_estudio_universidad_carrera").css("display","block");
            },
            showFuncionarioEmpresa: function() {
                $(".regional_centro").css("display","none");
                $(".programa").css("display","none");
                $(".tipo_formacion").css("display","none");
                $(".dependencia").css("display","none");
                $(".empresa").css("display","block");
                $(".tipo_estudio_universidad_carrera").css("display","none");
            },
            getCentroFormacion:function (){
                let regional = $('#regional').val();
                if(regional != null || regional != '')
                {
                    $.ajax({
                        dataType:'json',
                        type:'get',
                        url: `${host_url}/centro-formacion/getcentrosregional/${regional}`
                    }).done(function(response){
                        $('#training_center').empty();
                        $('#training_center').append('<option value="">Seleccione el centro de formación</option>')
                        $.each(response.centros, function(id, nombre) {
                                @if (isset($user->informacion_user['talento']['centro_formacion']))
                                    const selected =  String("{{$user->informacion_user['talento']['centro_formacion']}}") == String(nombre) ? 'selected' : '';
                                    $('#training_center').append(`<option ${selected} value="${id}" >${nombre}</option>`);
                                @else
                                    $('#training_center').append(`<option value="${id}" >${nombre}</option>`);
                                @endif
                        });
                        $('#training_center').material_select();
                    });
                }
            },

        }
    </script>
@endpush
