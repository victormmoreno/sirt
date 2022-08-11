@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5>
            <a class="footer-text left-align" href="{{route('empresa')}}">
                <i class="left material-icons">arrow_back</i>
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
                    <form id="formRegisterCompany"  action="{{route('empresa.store')}}" method="POST" onsubmit="return checkSubmit()">
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
                    <center>
                        <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                        <a href="{{route('empresa')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                    <center>
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
