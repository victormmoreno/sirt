@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('meta-content', 'Articulaciones')
@section('meta-keywords', 'Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('publicacion.index')}}">
              <i class="left material-icons arrow-l">event</i>
            </a> Publicaciones
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <br>
                  <center>
                    <span class="card-title center-align">Nueva Publicación</span>
                  </center>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="card red lighten-3">
                        <div class="row">
                          <div class="col s12 m12">
                            <div class="card-content white-text">
                              <p><i class="material-icons left">info_outline</i>Los datos marcados con * son obligatorios</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <form id="frmPublicacionesCreate" method="POST" action="">
                    {!! csrf_field() !!}
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <label for="txtnombre">Título de la Publicación <span class="red-text">*</span></label>
                        <input type="text" id="txttitulo" name="txttitulo"/>
                        <small id="txttitulo-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio" href="javascript:void(0)" name="txtfecha_inicio" class="datepicker __pickerinput"/>
                        <label for="txtfecha_inicio">Fecha de inicio de la publicación<span class="red-text">*</span></label>
                        <small id="txtfecha_inicio-error" class="error red-text"></small>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_fin" href="javascript:void(0)" name="txtfecha_fin" class="datepicker __pickerinput"/>
                        <label for="txtfecha_fin">Fecha de terminación de la publicación <span class="red-text">*</span></label>
                        <small id="txtfecha_fin-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m12 l8 offset-l2">
                        <textarea id="txtcontenido" name="txtcontenido" class="materialize-textarea"></textarea>
                        <label for="txtcontenido">Contenido</label>
                        <small id="txtcontenido-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <center>
                      <button type="submit" class="cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                      <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                    </center>
                  </form>
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
  {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> --}}
  <script>
    $('#txtcontenido').summernote({
      lang: 'es-ES',
      height: 300
    });
  </script>
@endpush
