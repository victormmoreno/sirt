@extends('layouts.app')

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5>
                    <a class="footer-text left-align" href="{{route('nodo.index')}}">
                        <i class="material-icons arrow-l">
                            arrow_back
                        </i>
                    </a>
                    Nodos
                </h5>
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <center><span class="card-title center-align">Editar Nodo <b>{{$entidad->nombre}}</b></span> <i class="Small material-icons prefix">location_city </i></center>
                                <div class="divider mailbox-divider"></div>
                               
                                <form action="{{ route('nodo.update', $entidad->id)}}" method="POST" onsubmit="return checkSubmit()">
                                	{!! method_field('PUT')!!}
	                                @include('nodos.administrador.form', [
								    	'btnText' => 'Modificar',
								   	])
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
        url:'/help/getcentrosformacion/'+id
      }).done(function(response){
      

        $('#txtcentro').empty();
        $('#txtcentro').append('<option value="">Seleccione el centro de formación</option>')
        $.each(response.centros, function(i, e) {
  
          $('#txtcentro').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
        })
         @if($errors->any())
        $('#txtcentro').val('{{old('txtcentro')}}');
        @else
        $('#txtcentro').val('{{$entidad->nodo->centro->id}}');
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
        url:'/help/getciudades/'+id
      }).done(function(response){
        $('#txtciudad').empty();
        $('#txtciudad').append('<option value="">Seleccione la Ciudad</option>')
    
        $.each(response.ciudades, function(i, e) {
          $('#txtciudad').append('<option  value="'+e.id+'">'+e.nombre+'</option>');

        })
        @if($errors->any())
        $('#txtciudad').val('{{old('txtciudad')}}');
        @else
            $('#txtciudad').val('{{$entidad->ciudad->id}}');
        @endif
        $('#txtciudad').material_select();
      });
    },
}
</script>
@endpush