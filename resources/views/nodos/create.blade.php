@extends('layouts.app')
@section('meta-title', 'Nuevo Nodo')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <a class="footer-text left-align" href="{{route('nodo.index')}}">
                        <i class="material-icons left">arrow_back</i>
                    </a>
                    Nodos | Nuevo Nodo
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li><a href="{{route('nodo.index')}}">Nodos</a></li>
                    <li class="active">Nuevo Nodo</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <form action="{{ route('nodo.store')}}" method="POST" onsubmit="return checkSubmit()">
                    @include('nodos.form', [
                        'btnText' => 'Guardar',
                    ])
                </form>
            </div>
        </div>
    </div>
</main>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        Regional.getCentrosFormacion();
        DepartamentsCreate.getCiudad();
});

var Regional = {
    getCentrosFormacion:function(){
      let id;
      id = $('#txtregional').val();
      $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + '/help/getcentrosformacion/'+id
      }).done(function(response){


        $('#txtcentro').empty();
        $('#txtcentro').append('<option value="">Seleccione el centro de formación</option>')
        $.each(response.centros, function(i, e) {

          $('#txtcentro').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
        })
         @if($errors->any())
        $('#txtcentro').val({{old('txtcentro')}});
        @endif
        $('#txtcentro').material_select();
      });
    },
}

var DepartamentsCreate = {
    getCiudad:function(){
      let id;
      id = $('#txtdepartamento').val();
      $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + '/help/getciudades/'+id
      }).done(function(response){
        $('#txtciudad').empty();
        $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
        $.each(response.ciudades, function(i, e) {
          $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
        })
        @if($errors->any())
            $('#txtciudad').val({{old('txtciudad')}});
        @endif
        $('#txtciudad').material_select();
      });
    },
}
</script>
@endpush
