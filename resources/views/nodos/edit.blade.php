@extends('layouts.app')
@section('meta-title', 'Tecnoparque nodo '. $nodo->entidad->present()->entidadName())

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align" href="{{route('nodo.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Nodos | Editar Nodo
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align  show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('nodo.index')}}">Nodos</a></li>
                            <li class="active">Editar Nodo</li>
                        </ol>
                    </div>
                </div>
                <form action="{{ route('nodo.update', $nodo->entidad->id)}}" method="POST" onsubmit="return checkSubmit()">
                {!! method_field('PUT')!!}
                    @include('nodos.form', [
                        'btnText' => 'Guardar Cambios',
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
        DepartamentsEdit.getCiudad();
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
        $('#txtcentro').select2('val','{{old('txtcentro')}}');
        @else
        $('#txtcentro').select2('val','{{$nodo->entidad->nodo->centro->id}}');
        @endif
        $('#txtcentro').material_select();
      });
    },
}

var DepartamentsEdit = {
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
        $('#txtciudad').select2('val','{{old('txtciudad')}}');
        @else
            $('#txtciudad').select2('val','{{$nodo->entidad->ciudad->id}}');
        @endif
        $('#txtciudad').material_select();
      });
    },
}
</script>
@endpush