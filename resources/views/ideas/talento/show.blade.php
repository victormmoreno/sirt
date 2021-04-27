@extends('layouts.app')
@section('meta-title', 'Ideas de Proyecto')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('idea.index')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Ideas de Proyecto
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <center>
                <span class="card-title center-align"><b>Idea de proyecto - {{ $idea->codigo_idea }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="row">
                <div class="col s12 m3 l3">
                  <ul class="collection with-header">
                    <li class="collection-header"><h5>Opciones</h5></li>
                    @if ($idea->estadoIdea->nombre === "En registro")
                    <li class="collection-item">
                      <form action="{{route('idea.enviar', $idea->id)}}" method="POST" id="frmEnviarIdeaTalento" name="frmEnviarIdeaTalento">
                        {!! method_field('PUT')!!}
                        <input type="hidden" value="{{$idea}}" name="txtidea_id">
                        @csrf
                        <a href="" onclick="confirmacionPostulacion(event)">
                          <div class="card-panel light-blue lighten-2 black-text center">
                            Postular proyecto al nodo {{$idea->nodo->entidad->nombre}}.
                          </div>
                        </a>
                      </form>
                    </li>
                    <li class="collection-item">
                      <a href="{{route('idea.edit', $idea->id)}}">
                        <div class="card-panel teal lighten-2 black-text center">
                          Cambiar información de la idea.
                        </div>
                      </a>
                    </li>
                    @endif
                    @if ($idea->estadoIdea->nombre == 'Rechazado por comité')
                    <li class="collection-item">
                      <form action="{{route('idea.duplicar', $idea->id)}}" method="POST" id="frmDuplicarIdea" name="frmDuplicarIdea">
                        {!! method_field('PUT')!!}
                        <input type="hidden" value="{{$idea}}" name="txtidea_id">
                        @csrf
                        <a href="" onclick="confirmacionDuplicacion(event)">
                          <div class="card-panel orange lighten-2 black-text center">
                            Duplicar idea de proyecto.
                          </div>
                        </a>
                      </form>
                    </li>
                    @endif
                    @if ($idea->estadoIdea->nombre != 'En PBT' && $idea->estadoIdea->nombre != 'Inhabilitado')
                    <li class="collection-item">
                      <form action="{{route('idea.inhabilitar', $idea->id)}}" method="POST" id="frmInhabilitarIdea" name="frmInhabilitarIdea">
                        {!! method_field('PUT')!!}
                        <input type="hidden" value="{{$idea}}" name="txtidea_id">
                        @csrf
                        <a href="" onclick="confirmacionInhabilitar(event)">
                          <div class="card-panel orange lighten-2 black-text center">
                            Inhabilitar idea de proyecto.
                          </div>
                        </a>
                      </form>
                    </li>
                    @endif
                    <li class="collection-item">
                      @include('ideas.historial_cambios')
                    </li>
                  </ul>
                </div>
                <div class="col s12 m8 l8">
                  @include('ideas.detalle')
                  <center>
                    <a href="{{route('idea.index')}}" class="waves-effect red lighten-2 btn center-aling">
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
