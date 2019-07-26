@extends('layouts.app')
@section('meta-title', 'Entrenamientos')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('entrenamientos')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Entrenamientos
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <br>
                <center>
                  <span class="card-title center-align">Nuevo Entrenamiento - Tecnoparque nodo {{$nodo}}</span>
                </center>
                <div class="divider"></div>
                <div class="row">
                  @if($errors->any())
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
                  @endif
                </div>
                <form action="{{route('entrenamientos.store')}}" method="post" id="formEntrenamientos" onsubmit="return checkSubmit()">
                  {!! csrf_field() !!}
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="txtfecha_sesion1" id="txtfecha_sesion1" value="{{ old('txtfecha_sesion1') }}">
                      <label for="txtfecha_sesion1" {{-- id="labelprimerasesion" --}}>Primera Sesión <span class="red-text">*</span></label>
                      @error('txtfecha_sesion1')
                        <label id="txtfecha_sesion1-error" class="error" for="txtfecha_sesion1">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <!-- <i class="material-icons prefix">phone</i> -->
                      <input id="txtfecha_sesion2" type="text" name="txtfecha_sesion2" value="{{ old('txtfecha_sesion2') }}">
                      <label for="txtfecha_sesion2" {{-- id="labelsegundasesion" --}}>Segunda Sesión <span class="red-text">*</span></label>
                      @error('txtfecha_sesion2')
                        <label id="txtfecha_sesion2-error" class="error" for="txtfecha_sesion2">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s10 m10 l10">
                      <select class="browser-default select2" id="txtidea" name="txtidea" onchange="entrenamiento.addIdea()">
                        <option value="0">Seleccione una Idea de Proyecto</option>
                        @foreach ($ideas as $key => $value)
                          <option value="{{$value['id']}}">{{$value['nombre_proyecto']}}</option>
                        @endforeach
                      </select>
                      <label for="txtidea" class="active">Idea de Proyecto <span class="red-text">*</span></label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s10 m9 l9">
                      <div class="card blue-grey lighten-5">
                        <div class="card-content">
                          <table class="highlight centered responsive-table">
                            <thead>
                              <tr>
                                <th style="width: 20%">Idea de Proyecto</th>
                                <th style="width: 20%">Nombres del Contacto</th>
                                <th style="width: 10%">¿Confirmación?</th>
                                <th style="width: 10%">¿Canvas?</th>
                                <th style="width: 10%">¿Asistió a la Primera Sesion?</th>
                                <th style="width: 10%">¿Asistió a la Segunda Sesion?</th>
                                <th style="width: 10%">¿Convocado a CSIBT?</th>
                                <th style="width: 10%">Eliminar</th>
                              </tr>
                            </thead>
                            <tbody id="tblIdeasEntrenamientoCreate">

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="col s2 m3 l3">
                      <blockquote>
                        <ul class="collection">
                          <li class="collection-item">Para agregar una idea de proyecto al entrenamiento solo debe buscarla y seleccionarla.</li>
                        </ul>
                      </blockquote>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                    <a href="{{route('entrenamientos')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
