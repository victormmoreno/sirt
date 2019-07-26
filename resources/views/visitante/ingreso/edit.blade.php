@extends('layouts.app')
@section('meta-title', 'Visitantes')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('visitante')}}">
              <i class="material-icons arrow-l">arrow_back</i>
            </a> Usuarios
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <br/>
                <center>
                  <span class="card-title center-align">Modificar Visitante de Tecnoparque</span>
                </center>
                <div class="divider"></div>
                <br/>
                <form id="formVisitanteEdit" action="{{route('visitante.update', $visitante->id)}}" method="POST" onsubmit="return checkSubmit()">
                  {!! method_field('PUT') !!}
                  {!! csrf_field() !!}
                  @include('visitante.ingreso.form')
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                    <a href="{{route('visitante')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                  </center>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
