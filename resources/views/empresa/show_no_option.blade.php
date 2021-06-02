@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('empresa')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Empresas
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <center>
                <span class="card-title center-align"><b>Detalle de la empresa</b></span>
              </center>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m12 l12">
                  @include('empresa.detalle')
                  <center>
                    <a href="{{route('empresa')}}" class="waves-effect red lighten-2 btn center-aling">
                      <i class="material-icons right">backspace</i>Volver
                    </a>
                  </center>
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