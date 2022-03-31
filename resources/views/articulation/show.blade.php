@extends('layouts.app')
@section('meta-title', __('Accompaniments'))
@section('content')
<main class="mn-inner">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s8 m8 l5">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    {{__('Accompaniments')}}
                </h5>
            </div>
            <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li ><a href="{{route('articulation.accompaniments')}}">{{__('Accompaniments')}}</a></li>
                    <li class="active">detalle</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12 no-p-h">
                <div class="card mailbox-content">
                    <div class="card-content">
                        <div class="row no-m-t no-m-b">
                            <div class="col s12 m12 l12">
                                <div class="mailbox-options">
                                    <ul>
                                        <li class="text-mailbox ">El acompañamiento se encuentra actualmente abierto</li>
                                        <div class="right">
                                            <li class="text-mailbox">Fecha registro: 24 mayo 2022</li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mailbox-view no-s">
                                        
                                        @if((session()->has('login_role') && session()->get('login_role') != App\User::IsAdministrador()))
                                            <div class="mailbox-view-header no-m-b no-m-t">
                                                <div class="right mailbox-buttons no-s">
                                                        <a href="" class="waves-effect waves-orange btn orange m-t-xs">Nueva Articulación</a>
                                                    @if((session()->has('login_role') && session()->get('login_role') === App\User::IsDinamizador()) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsSuspendido()))
                                                        <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Cambiar articulador</a>
                                                    @endif
                                                    @if((session()->has('login_role') && session()->get('login_role') === App\User::IsArticulador()))

                                                       
                                                            <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Miembros</a>
                                                            <a href="" class="waves-effect waves-grey btn-flat m-t-xs">Suspender Acpmpañamiento</a>
                                                        
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    <div class="mailbox-view-header">
                                        <div class="left">
                                            <span class="mailbox-title p-v-lg">A2022-464356-4645 Acompañamiento Ecommerce</span>

                                            <div class="left">
                                                <span class="mailbox-title">Ana Milena Zapata</span>
                                                <span class="mailbox-author">Articulador (Autor) </span>
                                            </div>
                                        </div>
                                        <div class="right mailbox-buttons p-v-lg">
                                            <div class="right">
                                                <span class="mailbox-title">Nodo Bogotá</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <div class="mailbox-text">
                                        <div class="row">
                                            <div class="col s12">
                                            </div>
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <div class="card card-transparent">
                                                        <div class="row card-talent">
                                                            <div class="col s12 m12 l4">
                                                                <div class="card bs-dark ">
                                                                    <div class="card-content">
                                                                        <span class="card-title p-h-lg"> </span><p class="orange-text p-h-lg">A2022-6464645-6534 Ecommerce Recursos Sennova</p>
                                                                        <div class=" p-h-lg mail-date hide-on-med-and-down"> Estado: Inicio</div>

                                                                        <p class="hide-on-med-and-down p-h-lg"> Descripción de la articulación</p>
                                                                    </div>
                                                                    <div class="card-action">
                                                                        <a class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m12 l4">
                                                                <div class="card bs-dark ">
                                                                    <div class="card-content">
                                                                        <span class="card-title p-h-lg"> </span><p class="orange-text p-h-lg">A2022-6464645-6534 Ecommerce Recursos Sennova</p>
                                                                        <div class=" p-h-lg mail-date hide-on-med-and-down"> Estado: Inicio</div>

                                                                        <p class="hide-on-med-and-down p-h-lg"> Descripción de la articulación</p>
                                                                    </div>
                                                                    <div class="card-action">
                                                                        <a class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m12 l4">
                                                                <div class="card bs-dark ">
                                                                    <div class="card-content">
                                                                        <span class="card-title p-h-lg"> </span><p class="orange-text p-h-lg">A2022-6464645-6534 Ecommerce Recursos Sennova</p>
                                                                        <div class=" p-h-lg mail-date hide-on-med-and-down"> Estado: Inicio</div>

                                                                        <p class="hide-on-med-and-down p-h-lg"> Descripción de la articulación</p>
                                                                    </div>
                                                                    <div class="card-action">
                                                                        <a class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m12 l4">
                                                                <div class="card bs-dark ">
                                                                    <div class="card-content">
                                                                        <span class="card-title p-h-lg"> </span><p class="orange-text p-h-lg">A2022-6464645-6534 Ecommerce Recursos Sennova</p>
                                                                        <div class=" p-h-lg mail-date hide-on-med-and-down"> Estado: Inicio</div>

                                                                        <p class="hide-on-med-and-down p-h-lg"> Descripción de la articulación</p>
                                                                    </div>
                                                                    <div class="card-action">
                                                                        <a class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m12 l4">
                                                                <div class="card bs-dark ">
                                                                    <div class="card-content">
                                                                        <span class="card-title p-h-lg"> </span><p class="orange-text p-h-lg">A2022-6464645-6534 Ecommerce Recursos Sennova</p>
                                                                        <div class=" p-h-lg mail-date hide-on-med-and-down"> Estado: Inicio</div>

                                                                        <p class="hide-on-med-and-down p-h-lg"> Descripción de la articulación</p>
                                                                    </div>
                                                                    <div class="card-action">
                                                                        <a class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m12 l4">
                                                                <div class="card bs-dark ">
                                                                    <div class="card-content">
                                                                        <span class="card-title p-h-lg"> </span><p class="orange-text p-h-lg">A2022-6464645-6534 Ecommerce Recursos Sennova</p>
                                                                        <div class=" p-h-lg mail-date hide-on-med-and-down"> Estado: Inicio</div>

                                                                        <p class="hide-on-med-and-down p-h-lg"> Descripción de la articulación</p>
                                                                    </div>
                                                                    <div class="card-action">
                                                                        <a class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col s12 m12 l4">
                                                                <div class="card bs-dark ">
                                                                    <div class="card-content">
                                                                        <span class="card-title p-h-lg"> </span><p class="orange-text p-h-lg">A2022-6464645-6534 Ecommerce Recursos Sennova</p>
                                                                        <div class=" p-h-lg mail-date hide-on-med-and-down"> Estado: Inicio</div>

                                                                        <p class="hide-on-med-and-down p-h-lg"> Descripción de la articulación</p>
                                                                    </div>
                                                                    <div class="card-action">
                                                                        <a class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

