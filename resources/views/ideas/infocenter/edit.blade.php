@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')

<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s8 m8 l10">
                  <h5>
                  <a class="footer-text left-align" href="{{route('idea.ideas')}}">
                    <i class="material-icons arrow-l">arrow_back</i>
                  </a> Ideas de Proyecto
                </h5>
              </div>
              <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li><a href="{{route('idea.ideas')}}">Ideas de Proyecto</a></li>
                      <li class="active">Modificar</li>
                  </ol>
              </div>
          </div>
        <div class="card stats-card">
          <div class="card-content">
            <br>
            <center>
              <span class="card-title center-align">Modificar Idea de Proyecto - {{ $idea->nombre_proyecto }}</span>
            </center>
            <div class="divider"></div>
            <div class="row">
              <form action="{{ route('idea.update', $idea->id)}}" method="POST" onsubmit="return checkSubmit()">
                {!! method_field('PUT')!!}
                {!! csrf_field() !!}
                <div class="card-panel red lighten-3">
                  <div class="card-content white-text">
                    <a class="btn-floating red"><i class="material-icons prefix">info_outline</i></a><span>Los elementos con (*) son obligatorios</span>
                  </div>
                </div>
                <center><span class="card-title center-align">Datos del Contacto</span> <i class="Small material-icons prefix">account_circle </i></center>
                <div class="divider"></div>
                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="txtnombres_contacto" type="text" name="txtnombres_contacto" value="{{ old('txtnombres_contacto', $idea->nombres_contacto) }}">
                    <label for="txtnombres_contacto">Nombres *</label>
                    @error('txtnombres_contacto')
                        <label id="txtnombres_contacto-error" class="error" for="txtnombres_contacto">{{ $message }}</label>
                    @enderror
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="txtapellidos_contacto" type="text" value="{{ old('txtapellidos_contacto', $idea->apellidos_contacto) }}" name="txtapellidos_contacto">
                    <label for="txtapellidos_contacto">Apellidos *</label>
                    @error('txtapellidos_contacto')
                        <label id="txtapellidos_contacto-error" class="error" for="txtapellidos_contacto">{{ $message }}</label>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">email</i>
                    <input id="txtcorreo_contacto" type="email" value="{{ old('txtcorreo_contacto', $idea->correo_contacto) }}" name="txtcorreo_contacto">
                    <label for="txtcorreo_contacto">Correo Electronico *</label>
                    @error('txtcorreo_contacto')
                        <label id="txtcorreo_contacto-error" class="error" for="txtcorreo_contacto">{{ $message }}</label>
                    @enderror
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">phone</i>
                    <input type="tel" id="txttelefono_contacto" value="{{ old('txttelefono_contacto', $idea->telefono_contacto) }}" name="txttelefono_contacto">
                    <label for="txttelefono_contacto">Contacto *</label>
                    @error('txttelefono_contacto')
                        <label id="txttelefono_contacto-error" class="error" for="txttelefono_contacto">{{ $message }}</label>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <input type="text" value="{{$idea->nombre_proyecto}}" id="txtnombre_proyecto" name="txtnombre_proyecto">
                    <label for="txtnombre_proyecto">Nombre de Proyecto *</label>
                    @error('txtnombre_proyecto')
                        <label id="txtnombre_proyecto-error" class="error" for="txtnombre_proyecto">{{ $message }}</label>
                    @enderror
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <select class=""  tabindex="-1" style="width: 100%" id="txtnodo_id" name="txtnodo_id" >
                      <option value="">Nodo *</option>
                      @foreach($nodos as $nodo)
                      <option value="{{$nodo->id}}" {{ $idea->nodo_id == $nodo->id ? 'selected' : '' }} {{ old('txtnodo_id') == $nodo->id ? 'selected':'' }} >
                          {{$nodo->nodos}}
                      </option>
                      @endforeach
                      @error('txtnodo_id')
                          <label id="txtnodo_id-error" class="error" for="txtnodo_id">{{ $message }}</label>
                      @enderror
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <textarea id="txtdescripcion" class="materialize-textarea" length="2000" name="txtdescripcion">{{$idea->descripcion}}</textarea>
                    <label for="txtdescripcion">Descripción del Proyecto *</label>
                    @error('txtdescripcion')
                        <label id="txtdescripcion-error" class="error" for="txtdescripcion">{{ $message }}</label>
                    @enderror
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <textarea id="txtobjetivo" class="materialize-textarea" length="2000" name="txtobjetivo">{{$idea->objetivo}}</textarea>
                    <label for="txtobjetivo">Objetivo general del Proyecto *</label>
                    @error('txtobjetivo')
                        <label id="txtobjetivo-error" class="error" for="txtobjetivo">{{ $message }}</label>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m12 l6 offset-l3 m3 s1">
                    <textarea id="txtalcance" class="materialize-textarea" length="2000" name="txtalcance">{{$idea->alcance}}</textarea>
                    <label for="txtalcance">Alcance del Proyecto *</label>
                    @error('txtalcance')
                        <label id="txtalcance-error" class="error" for="txtalcance">{{ $message }}</label>
                    @enderror
                  </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m8 l8 offset-l2 offset-m2 ">
                        <div class="input-field col s12 m4 l4">
                            <label for="txtlinkvideo" class="active">
                                ¿La idea viene de una convocatoria? <span class="red-text">*</span>
                            </label>
                            <select class="" id="txtconvocatoria" name="txtconvocatoria"  style="width: 100%" tabindex="-1" onchange="idea.getSelectConvocatoria()">
                                <option value="0" {{ $idea->viene_convocatoria == 0 ? 'selected' : '' }} >No</option>
                                <option value="1" {{ $idea->viene_convocatoria == 1 ? 'selected' : '' }}>Si</option>
                            </select>

                            @error('txtconvocatoria')
                            <label id="txtconvocatoria-error" class="error" for="txtconvocatoria">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="input-field col s12 m8 l8">
                            <label for="txtnombreconvocatoria">
                                Nombre de Convocatoria
                            </label>
                            <input  class="validate" id="txtnombreconvocatoria" name="txtnombreconvocatoria" type="text" value="{{ old('txtnombreconvocatoria',$idea->convocatoria) }}" {{ $idea->viene_convocatoria == 0 ? 'disabled' : '' }}>
                            @error('txtnombreconvocatoria')
                                <label id="txtnombreconvocatoria-error" class="error" for="txtnombreconvocatoria">{{ $message }}</label>
                            @enderror
                        </div>

                    </div>
                </div>
                <center>
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                  <a href="{{route('idea.ideas')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
