@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><a class="footer-text left-align" href="{{route('idea.ideas')}}">
          <i class="material-icons arrow-l">arrow_back</i>
        </a> Ideas de Proyecto </h5>
        <div class="card stats-card">
          <div class="card-content">
            <div class="row">
              <div class="row">
                <form method="post" action="{{ route('idea.storeegi')}}">
                  {!! csrf_field() !!}
                  @if($errors->any())
                  <div class="card red lighten-3">
                    <div class="row">
                      <div class="col s12 m12">
                        <div class="card-content white-text">
                          <p><i class="material-icons left"> info_outline</i>Los datos marcados con * son obligatorios</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  <center>
                    <p class="description text-center" align="center">Ingresa la idea de proyecto (CON EMPRESA/Grupo de Investigación) aquí debajo.</p>
                  </center>
                  <center><span class="card-title center-align">Datos de la Empresa/Grupo de Investigacón</span><i class="small material-icons prefix">business</i></center>
                  <div class="divider"></div>
                  <div class="row">
                    <p class="center card-title">Seleccione con quién es la idea de proyecto</p><br>
                    <div class="input-field col s12 m12 l12">
                      <p class="center p-v-xs">
                        <input class="with-gap" name="txttipo_idea[1]" {{ old('txttipo_idea.1')==2 ? 'checked' : ''}} type="radio" value="2" id="empresa"/>
                        <label for="empresa">Empresa</label>
                        <input class="with-gap" name="txttipo_idea[1]" {{ old('txttipo_idea.1')==3 ? 'checked' : ''}} type="radio" value="3" id="grupo"/>
                        <label for="grupo">Grupo de Investigación</label>
                      </p>
                      @error('txttipo_idea')
                      <center>
                        <label id="txttipo_idea-error" class="error" for="txttipo_idea">{{ $message }}</label>
                      </center>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m12 l12">
                      <i class="material-icons prefix">library_books</i>
                      <input id="txtnombre_proyecto" type="text" name="txtnombre_proyecto" value="{{ old('txtnombre_proyecto') }}">
                      <label for="txtnombre_proyecto">Nombre de Proyecto *</label>
                      @error('txtnombre_proyecto')
                      <label id="txtnombre_proyecto-error" class="error" for="txtnombre_proyecto">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <i class="material-icons prefix">contacts</i>
                      <input id="txtnidcod" type="text" name="txtnidcod" value="{{ old('txtnidcod') }}">
                      <label for="txtnidcod">Nit de la Empresa / Código del Grupo de Investigacón *</label>
                      @error('txtnidcod')
                      <label id="txtnidcod-error" class="error" for="txtnidcod">{{ $message }}</label>
                      @enderror
                    </div>
                    <!-- <div class="input-field col s12 m6 l6">
                      <i class="material-icons prefix">contacts</i>
                      <input id="txtnidcod" type="text" name="txtnidcod" value="{{ old('txtnidcod') }}">
                      <label for="txtnidcod">Nit de la Empresa / Código del Grupo de Investigacón *</label>
                      @error('txtnidcod')
                      <label id="txtnidcod-error" class="error" for="txtnidcod">{{ $message }}</label>
                      @enderror
                    </div> -->
                    <div class="input-field col s12 m6 l6">
                      <i class="material-icons prefix">business</i>
                      <input id="txtnombreempgi" type="text" name="txtnombreempgi" value="{{ old('txtnombreempgi') }}">
                      <label for="txtnombreempgi">Nombre de la Empresa / Nombre del Grupo de Investigacón *</label>
                      @error('txtnombreempgi')
                      <label id="txtnombreempgi-error" class="error" for="txtnombreempgi">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar Idea</button>
                    <a href="{{route('idea.ideas')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
