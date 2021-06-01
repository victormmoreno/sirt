@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')


<main class="mn-inner">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s8 m8 l5">
            <h5 class="left-align orange-text text-darken-3">
                <i class="material-icons left">
                  autorenew
                </i>
                Articulaciones PBT
            </h5>
        </div>
        <div class="col s4 m4 l5 offset-l2  rigth-align show-on-large hide-on-med-and-down">
            <ol class="breadcrumbs">
                <li><a href="{{route('home')}}">Inicio</a></li>
                <li ><a href="{{route('articulaciones.index')}}">Articulaciones PBT</a></li>
                <li ><a href="{{route('articulaciones.show', $actividad->articulacionpbt->id)}}">detalle</a></li>
                <li class="active">Inicio</li>
            </ol>
        </div>
    </div>
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12 no-p-h">
            <div class="card mailbox-content">
                <div class="card-content">
                    <div class="row no-m-t no-m-b">
                        <div class="col s12 m12 l12">
                            <div class="mailbox-options">
                              <ul>
                                <li class="text-mailbox active">Inicio</li>
                                <li class="text-mailbox">Ejecución</li>
                                <li class="text-mailbox">Cierre</li>
                                <div class="right">
                                    <li class="text-mailbox "> Fase actual: {{$actividad->articulacionpbt->present()->articulacionPbtNameFase()}}</li>
                                    <li class="text-mailbox">Fecha Inicio: {{$actividad->present()->startDate()}}</li>   
                                </div>
                            </ul>
                            </div>
                            <div class="mailbox-view no-s">
                                
                                <div class="mailbox-view-header">
                                    <div class="left">
                                        <span class="mailbox-title p-v-lg">{{$actividad->present()->actividadCode()}} - {{$actividad->present()->actividadName()}}</span>
                                        
                                        <div class="left">
                                            <span class="mailbox-title">{{$actividad->present()->actividadUserAsesor()}}</span>
                                            <span class="mailbox-author">{{$actividad->present()->actividadUserRolesAsesor()}} </span>
                                        </div>
                                    </div>
                                    <div class="right mailbox-buttons p-v-lg">
                                        <div class="right">
                                            <span class="mailbox-title">{{$actividad->present()->actividadNode()}}</span>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="divider mailbox-divider"></div>
                               
                                <div class="mailbox-text">
                                    <div class="row">
                                        <form action="{{route('articulacion.update.articulador', $actividad->articulacionpbt->id)}}" method="POST" name="frmUpdateGestor" onsubmit="return checkSubmit()">
                                            {!! method_field('PUT')!!}
                                            @csrf
                                            <div class="row">
                                                <div class="input-field col s12 m6 l6 offset-l3 offset-m3">
                                                <select id="txtgestor" class="js-states" name="txtgestor" style="width: 100%;">
                                                    <option value="">Seleccione el Articulador</option>
                                                    @forelse ($articuladores as $id => $value)
                                                    <option value="{{$id}}" {{ $id == $actividad->gestor_id ? 'selected' : '' }} {{ old('txtgestor') == $id ? 'selected':'' }} >{{$value}}</option>
                                                    @empty
                                                    <option value="">No hay información disponible</option>
                                                    @endforelse
                                                </select>
                                                <label for="txtgestor">Articuladores <span class="red-text">*</span></label>
                                                @error('txtgestor')
                                                    <label id="txtgestor-error" class="error" for="txtgestor">{{ $message }}</label>
                                                @enderror
                                                </div>
                                                
                                            </div>
                                            <div class="divider"></div>
                                            <center>
                                            <button type="submit" value="send" class="waves-effect cyan darken-1 btn center-aling">
                                                <i class="material-icons right">done</i>
                                                Cambiar Articulador.
                                            </button>
                                            <a href="{{route('articulaciones.show', $actividad->articulacionpbt->id)}}" class="waves-effect red lighten-2 btn center-aling">
                                                <i class="material-icons right">backspace</i>Cancelar
                                            </a>
                                            </center>
                                        </form>
                                    </div>
                                </div>
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
@push('script')
<script>

@endpush