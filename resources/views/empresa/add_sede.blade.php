@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <h5 class="left primary-text">
                        <a class="primary-text" href="{{route('empresa.detalle', $empresa->id)}}">
                            <i class="left material-icons">arrow_back</i>
                        </a> Empresas
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('empresa.detalle', $empresa->id)}}">Empresa</a></li>
                            <li>Agregar nueva sede {{$empresa->nombre}}</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="center primary-text">
                                    <span class="card-title center-align">Agregar nueva sede para {{$empresa->nombre}}</span>
                                </div>
                                <div class="divider"></div>
                                <form id="formAddCompanyHq"  action="{{route('empresa.store.sede', $empresa->id)}}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('PUT')!!}
                                <div class="card red lighten-3">
                                    <div class="row">
                                    <div class="col s12 m12">
                                        <div class="card-content white-text">
                                        <p><i class="material-icons left"> info_outline</i> Los datos marcados con * son obligatorios</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @include('empresa.form_sedes', ['vista' => 'empresa'])
                                <div class="divider"></div>
                                <div class="center">
                                    <button type="submit" class="bg-secondary btn center-aling"><i class="material-icons right">send</i>Modificar</button>
                                    <a href="{{route('empresa.detalle', $empresa->id)}}" class="bg-danger btn center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
                                </div>
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
    <script>
        $(document).ready(function() {
            getCiudadSede();
        });
        function getCiudadSede() {
        let id;
        id = $('#txtdepartamento_sede').val();
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: `${host_url}/help/getciudades/${id}`
        }).done(function(response) {
            $('#txtciudad_id_sede').empty();
            $('#txtciudad_id_sede').append('<option value="">Seleccione la Ciudad</option>')
            $.each(response.ciudades, function(i, e) {
                $('#txtciudad_id_sede').append('<option value="' + e.id + '">' + e.nombre + '</option>');
            })
            $('#txtciudad_id_sede').material_select();
            });
        }
    </script>
@endpush
