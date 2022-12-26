@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <h5 class="left left-align primary-text">
                        <a class="primary-text" href="{{route('empresa')}}">
                            <i class="material-icons left">arrow_back</i>
                        </a>
                        Empresas
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li class="active">Empresas</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <br>
                                <div class="center primary-text">
                                    <span class="card-title center-align">Nueva Empresa - Red Tecnoparque</span>
                                </div>
                                <div class="divider"></div>
                                <form id="formRegisterCompany" action="{{route('empresa.store')}}" method="POST" onsubmit="return checkSubmit()">
                                    {!! csrf_field() !!}
                                    <div class="card red lighten-3">
                                        <div class="row">
                                        <div class="col s12 m12">
                                            <div class="card-content white-text">
                                            <p><i class="material-icons left"> info_outline</i> Los datos marcados con * son obligatorios</p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    @include('empresa.form', ['vista' => 'empresa'])
                                    <div class="divider"></div>
                                    @include('empresa.form_sedes', ['vista' => 'empresa'])
                                    <div class="divider"></div>
                                    <div class="center">
                                        <button type="submit" class="btn bg-secondary center-aling"><i class="material-icons right">send</i>Registrar</button>
                                        <a href="{{route('empresa')}}" class="btn bg-danger center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
                                    <div>
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
    @if($errors->any())
    EmpresaCreate.getCiudad();
    @endif
  });
  function getCiudadSede() {
    let id;
    id = $('#txtdepartamento_sede').val();
    $.ajax({
        dataType: 'json',
        type: 'get',
        url: host_url + '/usuario/getciudad/' + id
    }).done(function(response) {
        $('#txtciudad_id_sede').empty();
        $('#txtciudad_id_sede').append('<option value="">Seleccione la Ciudad</option>')
        $.each(response.ciudades, function(i, e) {
            @if(isset($empresa))
            let id_ciudade_sede = {{$sede->ciudad->id}};
                if (id_ciudade_sede == e.id) {
                $('#txtciudad_id_sede').append('<option value="' + e.id + '" selected>' + e.nombre + '</option>');
                $('#txtciudad_id_sede').material_select();
                } else {
                $('#txtciudad_id_sede').append('<option value="' + e.id + '">' + e.nombre + '</option>');
                }
            @else
            $('#txtciudad_id_sede').append('<option value="' + e.id + '">' + e.nombre + '</option>');
            @endif
        })
        $('#txtciudad_id_sede').material_select();
    });
}
</script>
@endpush