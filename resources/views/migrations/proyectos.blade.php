@extends('layouts.app')
@section('meta-title', 'Migraciones')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">attach_file</i>Migraciones
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Migraciones</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="primary-text">
                                    <div class="mailbox-view-header">
                                        <div class="center-align">
                                            <h1 class="card-title center-align text-2xl no-m">Migraciones de base de datos</h1>
                                        </div>
                                    </div>
                                </div>


                                <div class="divider"></div>
                            </div>

                            <div class="row">
                                @if ($errors->any())
                                    @if(collect($errors->all())->count() > 1)
                                    <span class="red-text">{{collect($errors->all())->count()}} errores</span>
                                    @else
                                    <span class="red-text">Tienes {{collect($errors->all())->count()}} error</span>
                                    @endif
                                @endif
                                <div class="col s12 m12 l12">
                                    <form action="{{route('migracion.proyectos.store')}}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col s12 m6 l6">
                                            <div class="input-field file-field">
                                                <div class="btn bg-primary white-text">
                                                    <span>Archivo</span>
                                                    <input type="file"  name="nombreArchivo" accept=".xlsx">

                                                </div>
                                                <div class="file-path-wrapper ">
                                                    <input class="file-path validate " type="text">
                                                </div>
                                                @error('nombreArchivo')
                                                    <label id="nombreArchivo-error" class="error" for="nombreArchivo">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                            <select class="js-states select2 browser-default" name="txtnodo_id" id="txtnodo_id" style="width: 100%">
                                                @foreach($nodos as $nodo)
                                                <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                                @endforeach
                                            </select>
                                            <label for="txtnodo_id" class="active">Seleccione el Nodo</label>
                                            @error('txtnodo_id')
                                                <label id="txtnodo_id-error" class="error" for="txtnodo_id">{{ $message }}</label>
                                            @enderror
                                            </div>
                                        </div>
                                        <center>
                                            <button type="submit" class="waves-effect bg-secondary white-text btn center-aling">
                                                <i class="material-icons right">done</i>
                                                Migrar
                                            </button>
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
</main>
@endsection
