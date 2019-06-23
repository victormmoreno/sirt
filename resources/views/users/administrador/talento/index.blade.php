@extends('layouts.app')
@section('meta-title', 'Talentos')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s10 m10 l10">
                        <h5 class="left-align">
                            <i class="material-icons left">
                                supervised_user_circle
                            </i>
                            Usuarios | Talentos
                        </h5>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l10">
                                    <div class="center-align">
                                        <span class="card-title center-align">
                                            Talentos {{config('app.name')}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 l2">
                                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                                        <a class="btnregister btn btn-floating btn-large tooltipped green" data-delay="50" data-position="button" data-tooltip="Nuevo Dinamizador" href="{{route('usuario.dinamizador.create')}}">
                                            <i class="material-icons">
                                                how_to_reg
                                            </i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                            </div>
                            

                            
                            
                                <br>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection