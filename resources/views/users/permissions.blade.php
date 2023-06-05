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
                                            <form id="FormChangeNodo"
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
                                                            <div class="input-field col s12 m12 l12 valign-wrapper selectRole"
                                                                style="display:none">
                                                                <h5><- Selecciona los roles</h5>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <section id="section-activator" class="col s12 m12 l12" style="display: none;">
                                                                <div class="card grey lighten-4 p">
                                                                    <div class="card-content">
                                                                        <span class="card-title grey-text text-darken-4 center-align">Información contractual {{ App\User::IsActivador() }}</span>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m12 l12">
                                                                                <input id="activator_code_contract" name="activator_code_contract" type="text" value="{{ isset($user->activador->codigo) && collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activador->codigo : old('activator_code_contract') }}">
                                                                                <label for="activator_code_contract">Código
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="activator_start_date_contract" name="activator_start_date_contract" type="text" value="{{ isset($user->infocenter->fecha_inicio) && collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activador->fecha_inicio : old('activator_start_date_contract') }}">
                                                                                <label for="activator_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="activator_end_date_contract" name="activator_end_date_contract" type="text" value="{{ isset($user->activador->fecha_finalizacion) && collect($user->roles)->contains('name', App\User::IsActivador()) ? $user->activador->fecha_finalizacion : old('activator_end_date_contract') }}">
                                                                                <label for="activator_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="activator_type_relationship"
                                                                                    name="activator_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="">Seleccione tipo de vinculación</option>
                                                                                        <option value="0">Contratista</option>
                                                                                        <option value="1">Planta</option>
                                                                                </select>
                                                                                <label for="activator_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="activator_contract_value_contract" name="activator_contract_value_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('activator_contract_value_contract') }}">
                                                                                <label for="activator_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="activator_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="activator_fees_contract" name="activator_fees_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('activator_fees_contract') }}">
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
                                                                                    @if (session()->has('login_role') &&
                                                                                    (session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsActivador())
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
                                                                                <input id="dynamizer_code_contract" name="dynamizer_code_contract" type="text" value="{{ isset($user->dinamizador->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->dinamizador->codigo : old('dynamizer_code_contract') }}"
                                                                                {{ (isset($user->dinamizador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_code_contract">Código
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="dynamizer_start_date_contract" name="dynamizer_start_date_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('dynamizer_start_date_contract') }}"
                                                                                {{ (isset($user->dinamizador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="dynamizer_end_date_contract" name="dynamizer_end_date_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('dynamizer_end_date_contract') }}"
                                                                                {{ (isset($user->dinamizador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="dynamizer_type_relationship"
                                                                                    name="dynamizer_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="">Seleccione tipo de vinculación</option>
                                                                                        <option value="0">Contratista</option>
                                                                                        <option value="1">Planta</option>
                                                                                </select>
                                                                                <label for="dynamizer_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="dynamizer_contract_value_contract" name="dynamizer_contract_value_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('dynamizer_contract_value_contract') }}"
                                                                                {{ (isset($user->dinamizador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="dynamizer_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="dynamizer_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="dynamizer_fees_contract" name="dynamizer_fees_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('dynamizer_fees_contract') }}"
                                                                                {{ (isset($user->dinamizador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
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
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="expert_node"
                                                                                    name="expert_node"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                    @if (session()->has('login_role') &&
                                                                                    (session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsActivador())
                                                                                    )
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
                                                                                <label for="expert_node" class="active">Nodo
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_node-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="expert_code_contract" name="expert_code_contract" type="text" value="{{ isset($user->experto->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('expert_code_contract') }}"
                                                                                {{ (isset($user->experto->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_code_contract">Código
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="expert_start_date_contract" name="expert_start_date_contract" type="text" value="{{ isset($user->experto->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('expert_start_date_contract') }}"
                                                                                {{ (isset($user->experto->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="expert_end_date_contract" name="expert_end_date_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('expert_end_date_contract') }}"
                                                                                {{ (isset($user->experto->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="expert_type_relationship"
                                                                                    name="expert_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="">Seleccione tipo de vinculación</option>
                                                                                        <option value="0"  {{ old('expert_type_relationship') == 0 ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ old('expert_type_relationship') == 1 ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="expert_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="expert_contract_value_contract" name="expert_contract_value_contract" type="text" value="{{ isset($user->experto->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('expert_contract_value_contract') }}"
                                                                                {{ (isset($user->experto->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="expert_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="expert_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="expert_fees_contract" name="expert_fees_contract" type="text" value="{{ isset($user->experto->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('expert_fees_contract') }}"
                                                                                {{ (isset($user->experto->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->experto->nodo->id) && $user->experto->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
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
                                                                                                        {{ old('txtnodoarticulador', $user->articulador->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                        {{ $nodo }}
                                                                                                    </option>
                                                                                                @else
                                                                                                    <option
                                                                                                        value="{{ $id }}"
                                                                                                        {{ old('txtnodoarticulador') == $id ? 'selected' : '' }}>
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
                                                                                            <option value="">Seleccione Nodo
                                                                                            </option>
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
                                                                                <input id="articulator_code_contract" name="articulator_code_contract" type="text" value="{{ isset($user->experto->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('articulator_code_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_code_contract">Código
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="articulator_start_date_contract" name="articulator_start_date_contract" type="text" value="{{ isset($user->articulador->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->articulador->codigo : old('articulator_start_date_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="articulator_end_date_contract" name="articulator_end_date_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('articulator_end_date_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="articulator_type_relationship"
                                                                                    name="articulator_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="">Seleccione tipo de vinculación</option>
                                                                                        <option value="0"  {{ old('articulator_type_relationship') == 0 ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ old('articulator_type_relationship') == 1 ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="articulator_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="articulator_contract_value_contract" name="articulator_contract_value_contract" type="text" value="{{ isset($user->articulador->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('articulator_contract_value_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="articulator_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="articulator_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="articulator_fees_contract" name="articulator_fees_contract" type="text" value="{{ isset($user->articulador->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->articulador->codigo : old('articulator_fees_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
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
                                                                                                        {{ old('infocenter_node', $user->articulador->nodo->id) == $id ? 'selected' : '' }}>
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
                                                                                        @if (isset($user->articulador->nodo->id) && session()->has('login_role') && collect($user->roles)->contains('name', App\User::IsInfocenter()))
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
                                                                                <input id="infocenter_code_contract" name="infocenter_code_contract" type="text" value="{{ isset($user->experto->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('infocenter_code_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->dinamizador->nodo->id) && $user->dinamizador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_code_contract">Código
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_code_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="infocenter_start_date_contract" name="infocenter_start_date_contract" type="text" value="{{ isset($user->articulador->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->articulador->codigo : old('infocenter_start_date_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_start_date_contract">Fecha inicio del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_start_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <input id="infocenter_end_date_contract" name="infocenter_end_date_contract" type="text" value="{{ isset($user->infocenter->codigo) && collect($user->roles)->contains('name', App\User::IsDinamizador()) ? $user->infocenter->codigo : old('infocenter_end_date_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_end_date_contract">Fecha finalización del contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_end_date_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m4 l4">
                                                                                <select class="js-states browser-default select2 select2-hidden-accessible"
                                                                                    id="infocenter_type_relationship"
                                                                                    name="infocenter_type_relationship"
                                                                                    style="width: 100%; display: none" tabindex="-1">
                                                                                        <option value="">Seleccione tipo de vinculación</option>
                                                                                        <option value="0"  {{ old('infocenter_type_relationship') == 0 ? 'selected' : '' }}>Contratista</option>
                                                                                        <option value="1" {{ old('infocenter_type_relationship') == 1 ? 'selected' : '' }}>Planta</option>
                                                                                </select>
                                                                                <label for="infocenter_type_relationship" class="active">Tipo Vinculación
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_type_relationship-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="infocenter_contract_value_contract" name="infocenter_contract_value_contract" type="text" value="{{ isset($user->articulador->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->experto->codigo : old('infocenter_contract_value_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_contract_value_contract">Valor contrato
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_contract_value_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                            <div class="input-field col s12 m6 l6">
                                                                                <input id="infocenter_fees_contract" name="infocenter_fees_contract" type="text" value="{{ isset($user->articulador->codigo) && collect($user->roles)->contains('name', App\User::IsExperto()) ? $user->articulador->codigo : old('infocenter_fees_contract') }}"
                                                                                {{ (isset($user->articulador->codigo) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->articulador->nodo->id) && $user->articulador->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                                <label for="infocenter_fees_contract">Honorarios mensuales
                                                                                    <span class="red-text">*</span>
                                                                                </label>
                                                                                <small id="infocenter_fees_contract-error" class="error red-text"></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>

                                                            <section id="section-user_apoyo"
                                                                class="input-field col s12 m12 l6 offset-l3">
                                                                <div class="card mailbox-content">
                                                                    <div class="card-content">
                                                                        <span
                                                                            class=" card-title activator grey-text text-darken-4 center-align">Información
                                                                            {{ App\User::IsApoyoTecnico() }}</span>
                                                                        <div class="input-field col s12 m12 l12">
                                                                            <select
                                                                                class="js-states browser-default select2 select2-hidden-accessible"
                                                                                id="txtnodouser" name="txtnodouser"
                                                                                style="width: 100%" tabindex="-1">
                                                                                @if (session()->has('login_role') &&
                                                                                        (session()->get('login_role') == App\User::IsAdministrador() ||
                                                                                            session()->get('login_role') == App\User::IsActivador()))
                                                                                    <option value="">Seleccione Nodo
                                                                                    </option>
                                                                                    @foreach ($nodos as $id => $nodo)
                                                                                        @if (isset($user->apoyotecnico->nodo->id) && collect($user->roles)->contains('name', App\User::IsApoyoTecnico()))
                                                                                            <option
                                                                                                value="{{ $id }}"
                                                                                                {{ old('txtnodouser', $user->apoyotecnico->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                {{ $nodo }}
                                                                                            </option>
                                                                                        @else
                                                                                            <option
                                                                                                value="{{ $id }}"
                                                                                                {{ old('txtnodouser') == $id ? 'selected' : '' }}>
                                                                                                {{ $nodo }}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                                @if (isset($user->apoyotecnico->nodo->id) &&
                                                                                        session()->has('login_role') &&
                                                                                        collect($user->roles)->contains('name', App\User::IsApoyoTecnico()))
                                                                                    <option
                                                                                        value="{{ $user->apoyotecnico->nodo->id }}"
                                                                                        selected="">Tecnoparque Nodo
                                                                                        {{ $user->apoyotecnico->nodo->entidad->nombre }}
                                                                                    </option>
                                                                                @elseif(session()->has('login_role') &&
                                                                                        session()->get('login_role') == App\User::IsDinamizador() &&
                                                                                        isset(auth()->user()->dinamizador->nodo->id))
                                                                                    <option value="">Seleccione Nodo
                                                                                    </option>
                                                                                    <option
                                                                                        value="{{ auth()->user()->dinamizador->nodo->id }}">
                                                                                        Tecnoparque Nodo
                                                                                        {{ auth()->user()->dinamizador->nodo->entidad->nombre }}
                                                                                    </option>
                                                                                @endif
                                                                            </select>
                                                                            <label for="txtnodouser" class="active">Nodo
                                                                                <span class="red-text">*</span></label>
                                                                            <small id="txtnodouser-error"
                                                                                class="error red-text"></small>
                                                                        </div>
                                                                        <div class="input-field col s12 m12 l12">
                                                                            <input id="txthonorariouser"
                                                                                name="txthonorariouser" type="text"
                                                                                value="{{ isset($user->apoyotecnico->honorarios) ? $user->apoyotecnico->honorarios : old('txthonorario') }}"
                                                                                {{ (isset($user->apoyotecnico->honorarios) && session()->get('login_role') == App\User::IsExperto()) || (session()->get('login_role') == App\User::IsDinamizador() && isset(auth()->user()->dinamizador->nodo->id) && isset($user->apoyotecnico->nodo->id) && $user->apoyotecnico->nodo->id != auth()->user()->dinamizador->nodo->id) ? 'readonly' : '' }}>
                                                                            <label for="txthonorariouser">Honorario mensual
                                                                                <span class="red-text">*</span></label>
                                                                            <small id="txthonorariouser-error"
                                                                                class="error red-text"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>

                                                            <section id="section-ingreso"
                                                                class="input-field col s12 m12 l6 offset-l3">
                                                                <div class="card mailbox-content">
                                                                    <div class="card-content">
                                                                        <span
                                                                            class="card-title activator grey-text text-darken-4 center-align">Información
                                                                            Ingreso</span>
                                                                        <div class="input-field col s12 m12 l12">
                                                                            <select
                                                                                class="js-states browser-default select2 select2-hidden-accessible"
                                                                                id="txtnodoingreso" name="txtnodoingreso"
                                                                                style="width: 100%" tabindex="-1">
                                                                                @if (session()->has('login_role') &&
                                                                                        (session()->get('login_role') == App\User::IsAdministrador() ||
                                                                                            session()->get('login_role') == App\User::IsActivador()))
                                                                                    <option value="">Seleccione Nodo
                                                                                    </option>
                                                                                    @foreach ($nodos as $id => $nodo)
                                                                                        @if (isset($user->dinamizador->nodo->id) && collect($user->roles)->contains('name', App\User::IsIngreso()))
                                                                                            <option
                                                                                                value="{{ $id }}"
                                                                                                {{ old('txtnodoingreso', $user->dinamizador->nodo->id) == $id ? 'selected' : '' }}>
                                                                                                {{ $nodo }}
                                                                                            </option>
                                                                                        @else
                                                                                            <option
                                                                                                value="{{ $id }}"
                                                                                                {{ old('txtnodoingreso') == $id ? 'selected' : '' }}>
                                                                                                {{ $nodo }}
                                                                                            </option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                                @if (isset($user->ingreso->nodo) && collect($user->roles)->contains('name', App\User::IsIngreso()))
                                                                                    <option selected
                                                                                        value="{{ $user->ingreso->nodo->id }}">
                                                                                        Tecnoparque Nodo
                                                                                        {{ $user->ingreso->nodo->entidad->nombre }}
                                                                                    </option>
                                                                                @elseif(session()->has('login_role') &&
                                                                                        session()->get('login_role') == App\User::IsDinamizador() &&
                                                                                        isset(auth()->user()->dinamizador->nodo->id))
                                                                                    <option
                                                                                        value="{{ auth()->user()->dinamizador->nodo->id }}">
                                                                                        Tecnoparque Nodo
                                                                                        {{ auth()->user()->dinamizador->nodo->entidad->nombre }}
                                                                                    </option>
                                                                                @endif
                                                                            </select>
                                                                            <label for="txtnodoingreso"
                                                                                class="active">Nodo<span
                                                                                    class="red-text">*</span></label>
                                                                            <small id="txtnodoingreso-error"
                                                                                class="error red-text"></small>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
            roles.getRoleSeleted();
            @if (isset($user->talento->tipotalento->id))
                tipoTalento.getSelectTipoTalento('{{ $user->talento->tipotalento->id }}');
            @endif
            @if (isset($user->talento->entidad))
                tipoTalento.getCentroFormacionAprendiz();
                tipoTalento.getCentroFormacionEgresadoSena();
                tipoTalento.getCentroFormacionFuncionarioSena();
                tipoTalento.getCentroFormacionInstructorSena();
            @endif
            @if (isset($user->gestor->nodo->lineas->id))
                linea.getSelectLineaForNodo();
            @endif
        });

        var roles = {
            getRoleSeleted: function(idrol) {
                $('#section-activator').hide();
                $('#section-dynamizer').hide();
                $('#section-expert').hide();
                $('#section-user_apoyo').hide();
                $('#section-articulator').hide();


                $('#section-infocenter').hide();
                $('#section-talento').hide();
                $('#section-ingreso').hide();
                $("input[type=checkbox]:checked").each(function() {
                    if ($(this).val() == '{{ App\User::IsActivador() }}') {
                        roles.hideSelectRole();
                        $('#section-activator').show();
                    } else if ($(this).val() == '{{ App\User::IsAdministrador() }}') {
                        roles.hideSelectRole();
                    } else if ($(this).val() == '{{ App\User::IsApoyoTecnico() }}') {
                        roles.hideSelectRole();
                        $('#section-user_apoyo').show();
                    } else if ($(this).val() == '{{ App\User::IsArticulador() }}') {
                        roles.hideSelectRole();
                        $('#section-articulator').show();
                    } else if ($(this).val() == '{{ App\User::IsDinamizador() }}') {
                        roles.hideSelectRole();
                        $('#section-dynamizer').show();
                    } else if ($(this).val() == '{{ App\User::IsExperto() }}') {
                        roles.hideSelectRole();
                        $('#section-expert').show();
                    } else if ($(this).val() == '{{ App\User::IsInfocenter() }}') {
                        roles.hideSelectRole();
                        $('#section-infocenter').show();
                    } else if ($(this).val() == '{{ App\User::IsTalento() }}') {
                        roles.hideSelectRole();
                        $('#section-talento').show();
                    } else if ($(this).val() == '{{ App\User::IsIngreso() }}') {
                        roles.hideSelectRole();
                        $('#section-ingreso').show();
                    }else if ($(this).val() == '{{ App\User::IsUsuario() }}') {
                        roles.hideSelectRole();
                    } else {
                        roles.showSelectRole();
                    }
                });

                if ($('#section-user_apoyo').css('display') === 'block') {
                    @if ($errors->any())
                        $("#txtnodouser").val("{{ old('txtnodouser') }}");
                    @else
                        $("#txtnodouser").val();
                    @endif
                    $("#txtnodouser").material_select();
                }

                if ($('#section-dynamizer').css('display') === 'block') {
                    @if ($errors->any())
                        $("#dynamizer_node").val("{{ old('dynamizer_node') }}");
                    @else
                        $("#dynamizer_node").val();
                    @endif
                    $("#dynamizer_node").material_select();
                }

                if ($('#section-expert').css('display') === 'block') {
                    @if ($errors->any())
                        $('#txtnodogestor').val("{{ old('txtnodogestor') }}");
                        $('#txtlinea').val("{{ old('txtlinea') }}");
                        $("#txthonorario").val("{{ old('txthonorario') }}");
                    @else
                        $("#txtnodogestor").val();
                        $("#txtlinea").val();
                        $("#txthonorario").val();
                    @endif
                    $("#txtnodogestor").material_select();
                    $("#txtlinea").material_select();
                }
                if ($('#section-infocenter').css('display') === 'block') {
                    @if ($errors->any())
                        $('#txtnodoinfocenter').val("{{ old('txtnodoinfocenter') }}");
                        $('#txtextension').val("{{ old('txtextension') }}");
                    @else
                        $("#txtnodoinfocenter").val();
                        $("#txtextension").val();
                    @endif
                    $("#txtnodoinfocenter").material_select();
                }
                if ($('#section-ingreso').css('display') === 'block') {
                    @if ($errors->any())
                        $("#txtnodoingreso").val("{{ old('txtnodoingreso') }}");
                    @else
                        $("#txtnodoingreso").val();
                    @endif
                    $("#txtnodoingreso").material_select();
                }
                if ($('#section-talento').css('display') === 'block') {
                    $("#txtperfil").val();
                    $("#txtperfil").material_select();
                    $("#txtregional").val();
                    $("#txtregional").material_select();
                    $("#txtcentroformacion").val();
                    $("#txtcentroformacion").material_select();
                    $("#txtuniversidad").val();
                    $("#txtempresa").val();
                    $("#txtotrotipotalento").val();
                    $("#txtgrupoinvestigacion").val();
                    $('.aprendizSena').hide();
                    $('.estudianteUniversitario').hide();
                    $('#funcionarioEmpresa').hide();
                    $('#otroTipoTalento').hide();
                    $('.investigador').hide();
                }
            },
            hideSelectRole: function() {
                $(".selectRole").css("display", "none");
            },
            showSelectRole: function() {
                $(".selectRole").css("display", "block");
            }
        };
        var linea = {
            getSelectLineaForNodo: function() {
                let nodo = $('#txtnodogestor').val();
                $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: host_url + '/lineas/getlineasnodo/' + nodo
                }).done(function(response) {
                    $('#txtlinea').empty();
                    if (response.lineasForNodo.lineas == '') {
                        $('#txtlinea').append('<option value="">No hay lineas disponibles</option>');
                    } else {
                        $('#txtlinea').append('<option value="">Seleccione la linea</option>');
                        $.each(response.lineasForNodo.lineas, function(i, e) {
                            $('#txtlinea').append('<option  value="' + e.id + '">' + e.nombre +
                                '</option>');
                            @if (isset($user->gestor))
                                $('#txtlinea').select2('val',
                                    '{{ $user->gestor->lineatecnologica_id }}');
                            @endif
                        });
                        @if ($errors->any())
                            $('#txtlinea').val("{{ old('txtlinea') }}");
                        @endif
                    }
                    $('#txtlinea').material_select();
                });
            },
        }
        var tipoTalento = {
            getSelectTipoTalento: function(idtipotalento) {
                let valor = $(idtipotalento).val();
                let nombretipotalento = $("#txttipotalento option:selected").text();
                if ((nombretipotalento == '{{ App\Models\TipoTalento::IS_APRENDIZ_SENA_CON_APOYO }}' ||
                        nombretipotalento == '{{ App\Models\TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO }}')) {
                    tipoTalento.showAprendizSena();
                } else if (nombretipotalento == '{{ App\Models\TipoTalento::IS_EGRESADO_SENA }}') {
                    tipoTalento.showEgresadoSena();
                } else if (nombretipotalento == '{{ App\Models\TipoTalento::IS_INSTRUCTOR_SENA }}') {
                    tipoTalento.showInstructorSena();
                } else if (nombretipotalento == '{{ App\Models\TipoTalento::IS_FUNCIONARIO_SENA }}') {
                    tipoTalento.showFuncionarioSena();
                } else if (nombretipotalento == '{{ App\Models\TipoTalento::IS_PROPIETARIO_EMPRESA }}') {
                    tipoTalento.showPropietarioEmpresa();
                } else if (nombretipotalento == '{{ App\Models\TipoTalento::IS_EMPRENDEDOR }}') {
                    tipoTalento.showEmprendedor();
                } else if (nombretipotalento == '{{ App\Models\TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO }}') {
                    tipoTalento.showUniversitario();
                } else if (nombretipotalento == '{{ App\Models\TipoTalento::IS_FUNCIONARIO_EMPRESA }}') {
                    tipoTalento.showFuncionarioEmpresa();
                } else {
                    tipoTalento.ShowSelectTipoTalento();
                }
            },
            showAprendizSena: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideEgresadoSena();
                tipoTalento.hideInstructorSena();
                tipoTalento.hideFuncionarioSena();

                tipoTalento.hideUniversitario();
                tipoTalento.hideFuncionarioEmpresa();
                $(".aprendizSena").css("display", "block");
            },
            showEgresadoSena: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideAprendizSena();
                tipoTalento.hideInstructorSena();
                tipoTalento.hideFuncionarioSena();

                tipoTalento.hideUniversitario();
                tipoTalento.hideFuncionarioEmpresa();
                $(".egresadoSena").css("display", "block");
                $(".egresadoSena").show();

            },
            showInstructorSena: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideAprendizSena();
                tipoTalento.hideEgresadoSena();
                tipoTalento.hideFuncionarioSena();
                tipoTalento.hideFuncionarioSena();
                tipoTalento.hideUniversitario();
                tipoTalento.hideFuncionarioEmpresa();
                $(".instructorSena").css("display", "block");
            },
            showFuncionarioSena: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideAprendizSena();
                tipoTalento.hideEgresadoSena();
                tipoTalento.hideInstructorSena();
                tipoTalento.hideFuncionarioSena();
                tipoTalento.hideUniversitario();
                tipoTalento.hideFuncionarioEmpresa();
                $(".funcionarioSena").css("display", "block");
            },
            showPropietarioEmpresa: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideAprendizSena();
                tipoTalento.hideEgresadoSena();
                tipoTalento.hideInstructorSena();
                tipoTalento.hideFuncionarioSena();
                tipoTalento.hideUniversitario();
                tipoTalento.hideFuncionarioEmpresa();
            },
            showEmprendedor: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideAprendizSena();
                tipoTalento.hideEgresadoSena();
                tipoTalento.hideInstructorSena();
                tipoTalento.hideFuncionarioSena();
                tipoTalento.hideUniversitario();
                tipoTalento.hideFuncionarioEmpresa();
            },
            showUniversitario: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideAprendizSena();
                tipoTalento.hideEgresadoSena();
                tipoTalento.hideInstructorSena();
                tipoTalento.hideFuncionarioSena();
                tipoTalento.hideFuncionarioEmpresa();
                $(".universitario").css("display", "block");
            },
            showFuncionarioEmpresa: function() {
                tipoTalento.hideSelectTipoTalento();
                tipoTalento.hideAprendizSena();
                tipoTalento.hideEgresadoSena();
                tipoTalento.hideInstructorSena();
                tipoTalento.hideFuncionarioSena();
                tipoTalento.hideUniversitario();
                $(".funcionarioEmpresa").css("display", "block");
            },
            hideAprendizSena: function() {
                $(".aprendizSena").css("display", "none");
            },
            hideEgresadoSena: function() {
                $(".egresadoSena").hide();
            },
            hideInstructorSena: function() {
                $(".instructorSena").css("display", "none");
            },
            hideFuncionarioSena: function() {
                $(".funcionarioSena").css("display", "none");
            },
            hideSelectTipoTalento: function() {
                $(".selecttipotalento").css("display", "none");
            },
            hideUniversitario: function() {
                $(".universitario").css("display", "none");
            },
            hideFuncionarioEmpresa: function() {
                $(".funcionarioEmpresa").css("display", "none");
            },
            ShowSelectTipoTalento: function() {
                tipoTalento.hideAprendizSena();
                $(".selecttipotalento").css("display", "block");
            },
            getCentroFormacionAprendiz: function() {
                let regional = $('#txtregional_aprendiz').val();
                $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: host_url + '/centro-formacion/getcentrosregional/' + regional
                }).done(function(response) {
                    $('#txtcentroformacion_aprendiz').empty();
                    @if (isset($user->talento->entidad) &&
                            collect($user->roles)->contains('name', App\User::IsTalento()) &&
                            session()->get('login_role') != App\User::IsExperto())
                        $('#txtcentroformacion_aprendiz').append(`<option value=` +
                            '{{ $user->talento->entidad->id }}' + `>` +
                            '{{ $user->talento->entidad->nombre }}' + `</option>`);
                        @if (isset($user->talento->entidad))
                            $('#txtcentroformacion_aprendiz').select2('val',
                                '{{ $user->talento->entidad->id }}');
                        @endif
                    @else
                        $('#txtcentroformacion_aprendiz').append(
                            '<option value="">Seleccione el centro de formación</option>')
                        $.each(response.centros, function(id, nombre) {
                            $('#txtcentroformacion_aprendiz').append('<option  value="' + id +
                                '">' + nombre + '</option>');
                            @if (isset($user->talento->entidad))
                                $('#txtcentroformacion_aprendiz').select2('val',
                                    '{{ $user->talento->entidad->id }}');
                            @endif
                            $('#txtcentroformacion_aprendiz').material_select();
                        });
                    @endif
                });
            },
            getCentroFormacionEgresadoSena: function() {
                let regional = $('#txtregional_egresado').val();
                $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: host_url + '/centro-formacion/getcentrosregional/' + regional
                }).done(function(response) {
                    $('#txtcentroformacion_egresado').empty();
                    $('#txtcentroformacion_egresado').append(
                        '<option value="">Seleccione el centro de formación</option>')
                    $.each(response.centros, function(id, nombre) {
                        $('#txtcentroformacion_egresado').append('<option  value="' + id + '">' +
                            nombre + '</option>');
                        @if (isset($user->talento->entidad))
                            $('#txtcentroformacion_egresado').select2('val',
                                '{{ $user->talento->entidad->id }}');
                        @endif
                        $('#txtcentroformacion_egresado').material_select();
                    });
                });
            },
        }
    </script>
@endpush
