@extends('layouts.app')

@section('meta-title', 'Gestores')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5>
                    <a class="footer-text left-align" href="">
                        <i class="material-icons arrow-l">
                            arrow_back
                        </i>
                    </a>
                    Usuarios | Gestores
                </h5>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">

                                <center>
                                    <span class="card-title center-align">
                                        Nuevo Gestor
                                    </span>
                                    <i class="Small material-icons prefix">
                                        supervised_user_circle
                                    </i>
                                </center>
                                <div class="divider">
                                </div>
                                <div class="col s12 m12 l12">                                
                                    <div class="mailbox-view">
                                        <div class="mailbox-view-header">
                                            <div class="center">
                                                <div class="center">
                                                    <i class="Small material-icons prefix">
                                                        supervised_user_circle
                                                    </i>               
                                                </div>
                                                <div class="center">
                                                    <span class="mailbox-title">Información Básica</span>
                                                </div>
                                            </div>
                                        </div>
                                <form action="{{ route('usuario.gestor.store')}}" method="POST" onsubmit="return checkSubmit()">
                                    @include('users.administrador.gestor.form', [
                                        'btnText' => 'Guardar',
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
// UserAdmininstradorOcupacion.getOcupaciones();
    $('.selectMultipe').select2({
      language: "es",
    });
    eps.getOtraEsp();
    @if($errors->any())
        UserGestorCreate.getCiudad();
    @endif

});
    
var eps = {
    getOtraEsp:function (ideps) {
        let id = $(ideps).val();
        let nombre = $("#txteps option:selected").text();
        if (nombre != '{{App\Models\Eps::OTRA_EPS }}') {
            $('#otraeps').hide();
             
        }else{
            $('#otraeps').show();
        }
    }
}

var UserGestorCreate = {
    getCiudad:function(){
      let id;
      id = $('#txtdepartamento').val();
      $.ajax({
        dataType:'json',
        type:'get',
        url:'/usuario/getciudad/'+id
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
    getLineasPorNodo: function () {
        let nodo;
        nodo = $('#txtnodo').val();
        $.ajax({
        dataType:'json',
        type:'get',
        url:'/usuario/getlineanodo/'+nodo
      }).done(function(response){
           
        $('#txtlinea').empty();
        $('#txtlinea').append('<option value="">Seleccione la linea</option>')
        $.each(response.lineas, function(id, nombre) {
          // console.log(e.id);
          $('#txtlinea').append('<option  value="'+id+'">'+nombre+'</option>');
        })
        
        $('#txtlinea').material_select();
      });
    }
  }


</script>
@endpush

