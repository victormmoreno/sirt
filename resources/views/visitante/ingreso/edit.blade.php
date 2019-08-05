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
                  @if($errors->any())
                    <div class="card red lighten-3">
                      <div class="row">
                        <div class="col s12 m12">
                          <div class="card-content white-text">
                            <p><i class="material-icons left"> info_outline</i>  Los datos marcados con * son obligatorios</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                  {!! method_field('PUT') !!}
                  {!! csrf_field() !!}
                  <div class="row">
                    <div class="input-field col s12 m12 l12">
                      <input name="txtdocumento"  id="txtdocumento" type="text" value="{{ isset($visitante) ? $visitante->documento : old('txtdocumento') }}">
                      <label for="txtdocumento">Documento de Identidad <span class="red-text">*</span></label>
                      @error('txtdocumento')
                        <label id="txtdocumento-error" class="error" for="txtdocumento">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
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
