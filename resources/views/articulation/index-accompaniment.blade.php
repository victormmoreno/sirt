@extends('layouts.app')
@section('meta-title', __('Accompaniments'))
@section('content')
@php
    $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="left left-align">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">autorenew</i>{{__('Accompaniments')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">{{__('Accompaniments')}}</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <div class="row">
                        @if((session()->has('login_role') && session()->get('login_role') === App\User::IsAdministrador()))
                            <div class="col s12 m8 l8">
                                <div class="center-align orange-text text-darken-3">
                                    <span class="card-title center-align">{{__('Accompaniments')}} -  {{config('app.name')}}</span>
                                </div>
                            </div>
                        @elseif((session()->has('login_role') && session()->get('login_role') === App\User::IsDinamizador()))
                            <div class="col s12 m12 l12">
                                <div class="center-align orange-text text-darken-3">
                                    <span class="card-title center-align">{{__('Accompaniments')}} - nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
                                </div>
                            </div>
                        @elseif((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))
                            <div class="col s12 m8 l8">
                            <div class="center-align orange-text text-darken-3">
                                <span class="card-title center-align">{{__('Accompaniments')}} - nodo {{ \NodoHelper::returnNameNodoUsuario() }} </span>
                            </div>
                            </div>
                            <div class="col s12 m4 l4 ">
                            <a  href="{{route('articulation.create')}}" class="waves-effect waves-grey grey darken-1 white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">{{__('New Accompaniment')}}</a>
                            </div>
                        @else
                            <div class="col s12 m12 l12">
                            <div class="center-align orange-text text-darken-3">
                                <span class="card-title center-align">{{__('Accompaniments')}} - {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }} </span>
                            </div>
                            </div>
                        @endif
                    </div>
                    <div class="divider"></div>
                        <div class="row search-tabs-row search-tabs-header">
                            @if((session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador()))
                            <div class="input-field col s12 m2 l2">
                                <label class="active" for="filter_nodo_art">Nodo <span class="red-text">*</span></label>
                                <select name="filter_nodo_art" id="filter_nodo_art">
                                    <option value="all" >todos</option>
                                    @foreach($nodos as $id => $name)
                                        <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="input-field col s12 m2 l1">
                                <label class="active" for="filter_year_art">Año <span class="red-text">*</span></label>
                                <select name="filter_year_art" id="filter_year_art">
                                    @for ($i=$year; $i >= 2016; $i--)
                                        <option value="{{$i}}" >{{$i}}</option>
                                    @endfor
                                    <option value="all" >todos</option>
                                </select>
                            </div>
                            <div class="col s12 m6 l4 offset-m3 right">
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="download_archive_art"><i class="material-icons">cloud_download</i>{{__('Download')}}</button>
                                <button class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_articulacion"><i class="material-icons">search</i>{{__('Filter')}}</button>
                            </div>
                        </div>
                    <table id="articulaciones_data_table" class="display responsive-table datatable-example dataTable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>{{__('Node')}}</th>
                            <th>{{__('Code Accompaniment')}}</th>
                            <th>{{__('Name Accompaniment')}}</th>
                            <th>{{__('Phase')}}</th>
                            <th>{{__('Created_at')}}</th>
                            <th>{{__('Process')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Bogotá</td>
                            <td>A2022-0535233-4234</td>
                            <td>Acompañamiento Sennainnva - Postobon</td>
                            <td>Abierta</td>
                            <td>14/03/2022</td>
                            <td><a class="btn m-b-xs" href="{{route('articulation.show', 1)}}"><i class="material-icons">search</i></a></td>
                        </tr>
                        <tr>
                            <td>Bogotá</td>
                            <td>A2022-736634-5487</td>
                            <td>Acompañamiento Ecommerce Online</td>
                            <td>Cerrada</td>
                            <td>01/03/2022</td>
                            <td><a class="btn m-b-xs" href="{{route('articulation.show', 1)}}"><i class="material-icons">search</i></a></td>
                        </tr>
                        <tr>
                            <td>Bogotá</td>
                            <td>A2022-65457466-6325</td>
                            <td>Acompañamiento UPI</td>
                            <td>Abierta</td>
                            <td>04/03/2022</td>
                            <td><a class="btn m-b-xs" href="{{route('articulation.show', 1)}}"><i class="material-icons">search</i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>
            @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))
            <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{route('articulation.create')}}"  class="btn tooltipped btn-floating btn-large grey" data-position="left" data-delay="50" data-tooltip="Nueva Articulación">
                <i class="material-icons">add</i>
            </a>
            </div>
            @endif
        </div>
        </div>
    </div>
</main>
@endsection

