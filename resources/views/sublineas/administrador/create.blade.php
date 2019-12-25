@extends('layouts.app')
@section('meta-title', 'Sublineas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                              <a class="footer-text left-align" href="{{route('sublineas.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Sublineas
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('sublineas.index')}}">Sublineas</a></li>
                            <li class="active">Nueva Sublinea</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <center>
                                    <span class="card-title center-align">
                                        Nueva Sublinea
                                    </span>
                                    <i class="Small material-icons prefix">
                                        dns
                                    </i>
                                </center>
                                <div class="divider">
                                </div>
                                <div class="col s12 m12 l12"> 
                                        <form action="{{ route('sublineas.store')}}" method="POST" onsubmit="return checkSubmit()">
                                        	@include('sublineas.administrador.form', [
        								    	'btnText' => 'Guardar',
        								   	])
                                        </form>
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
