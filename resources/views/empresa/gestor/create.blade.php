@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('empresa')}}">
              <i class="material-icons arrow-l">business_center</i>
            </a> Empresas
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <br>
                  <center>
                    <span class="card-title center-align">Nueva Empresa - Red Tecnoparque</span>
                  </center>
                  <div class="divider"></div>
                  <form id="formValidate" method="POST" onsubmit="return checkSubmit()">
                    {!! csrf_field() !!}
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
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="nombre" id="nombre" maxlength="100">
                        <label for="nombre">Nombre de la Empresa <span class="red-text">*</span></label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="nit" id="nit">
                        <label for="nit">Nit de la Empresa <span class="red-text">*</span></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="email_entidad" id="email_entidad">
                        <label for="email_entidad">Email de la Empresa <span class="red-text"></span></label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="email" name="direccion" id="direccion">
                        <label for="direccion">Dirección de la Empresa </label>
                      </div>
                    </div>
                    <center>
                      <i class="material-icons">person</i>
                    </center>
                    <center>
                      <span class="card-title center-align">Datos del Contacto</span>
                    </center>
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m4 l4">
                        <input type="text" name="nombre_contacto" id="nombre_contacto">
                        <label for="nombre_contacto">Nombre del Contacto <span class="red-text"></span></label>
                      </div>
                      <div class="input-field col s12 m4 l4">
                        <input type="email" name="email_contacto" id="email_contacto">
                        <label for="email_contacto">Email del Contacto </label>
                      </div>
                      <div class="input-field col s12 m4 l4">
                        <input type="email" name="telefono_contacto" id="telefono_contacto">
                        <label for="telefono_contacto">Teléfono/Celular del Contacto </label>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <center>
                      <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                      <a href="{{route('empresa')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
