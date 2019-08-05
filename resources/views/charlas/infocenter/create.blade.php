@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('charla')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Charlas Informativas
        </h5>
        <div class="card">
          <div class="card-content">
            <br>
            <center>
              <span class="card-title center-align">Nueva Charla Informativa - Tecnoparque nodo {{ \NodoHelper::returnNameNodoUsuario() }}</span>
            </center>
            {{-- <div class="divider"></div> --}}
            <div class="row">
              <form id="formCharlaInformativaCreate" action="{{route('charla.store')}}" method="POST" onsubmit="return checkSubmit()">
                {!! csrf_field() !!}
                @include('charlas.infocenter.form', [
                  'btnText' => 'Registrar'
                ])
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
