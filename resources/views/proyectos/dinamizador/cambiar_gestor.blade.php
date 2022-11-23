@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="content">
            <div class="row no-m-t no-m-b m-r-lg m-l-lg">
                <div class="left left-align primary-text">
                    <h5>
                        <a class="footer-text left-align" href="{{route('proyecto')}}">
                            <i class="material-icons arrow-l left">arrow_back</i>
                        </a> Proyectos de Base Tecnológica
                    </h5>
                </div>
                <div class="right right-align show-on-large hide-on-med-and-down">
                    <ol class="breadcrumbs">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="{{ route('proyecto') }}">Proyectos</a></li>
                        <li>
                            <a href="{{  route('proyecto.inicio', $proyecto)  }}">{{ $proyecto->present()->proyectoCode() }}</a>
                        </li>
                        <li class="active">Cambiar experto</li>
                    </ol>
                </div>
            </div>
            <div class="row no-m-t no-m-b">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                @include('proyectos.navegacion_fases')
                                <div class="divider"></div>
                                <br/>
                                <form action="{{route('proyecto.update.gestor', $proyecto->id)}}" method="POST"
                                      name="frmUpdateGestor">
                                    {!! method_field('PUT')!!}
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <select id="txtgestor_id" class="js-states browser-default select2"
                                                    name="txtgestor_id" style="width: 100%;">
                                                <option value="">Seleccione el experto</option>
                                                @forelse ($gestores as $id => $value)
                                                    <option
                                                        value="{{$id}}" {{ $id == $proyecto->articulacion_proyecto->actividad->gestor_id ? 'selected' : '' }} {{ old('txtgestor_id') == $id ? 'selected':'' }} >{{$value}}</option>
                                                @empty
                                                    <option value="">No hay información disponible</option>
                                                @endforelse
                                            </select>
                                            <label class="active" for="txtgestor_id">Expertos <span
                                                    class="red-text">*</span></label>
                                            @error('txtgestor_id')
                                            <label id="txtgestor_id-error" class="error"
                                                   for="txtgestor_id">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <input disabled type="text" id="txtlineatecnologica_id"
                                                   name="txtlineatecnologica_id"
                                                   value="{{ $proyecto->sublinea->linea->nombre }}">
                                            <label for="txtlineatecnologica_id">Línea Tecnológica</label>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="center-align">
                                        <button type="submit" value="send"
                                                class="waves-effect bg-secondary text-white btn center-aling">
                                            <i class="material-icons left">done</i>
                                            Cambiar experto
                                        </button>
                                        <a href="{{route('proyecto')}}"
                                           class="waves-effect bg-danger white-text btn center-aling">
                                            <i class="material-icons right">backspace</i>Cancelar
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
