@extends('layouts.app')

@section('meta-title', 'Usuarios')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                              <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Usuarios
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li class="active">Nuevo Usuario</li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">

                                <center>
                                    <span class="card-title center-align hand-of-Sean-fonts orange-text text-darken-3">
                                        Nuevo Usuario
                                    </span>
                                    <i class="Small material-icons prefix orange-text text-darken-3">
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
                                                    <i class="Small material-icons prefix green-complement-text">
                                                        supervised_user_circle
                                                    </i>               
                                                </div>
                                                <div class="center">
                                                    <span class="mailbox-title green-complement-text">Información Básica</span>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="formRegisterUser" action="{{ route('usuario.usuarios.store')}}" method="POST" onsubmit="return checkSubmit()">
                                            @include('users.administrador.form2', [
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
    $('.selectMultipe').select2({
      language: "es",
    });
    // eps.getOtraEsp();
    // ocupacion.getOtraOcupacion();
    roles.getRoleSeleted();
    // regional.getCentroFormacion();
    // grupoInvestigacion.getGrupoInvestigacion();
    //     TipoTalento.getSelectTipoTalento();
    // @if($errors->any())
    //     linea.getSelectLineaForNodo();
    //     UserCreate.getCiudad();
    //     UserCreate.getCiudadExpedicion();
    //     regional.getCentroFormacion();
    // @endif

});
    




var roles = {
    getRoleSeleted:function (idrol) {
        let role = $(idrol).val();
        if($('#dinamizador').css('display') === 'block')
        {
              @if($errors->any())
                  $("#txtnododinamizador").val("{{old('txtnododinamizador')}}");
              @else
                $("#txtnododinamizador").val();
              @endif
              $("#txtnododinamizador").material_select(); 
        }

        if ($('#gestor').css('display') === 'block') {
            
            @if($errors->any())
                $('#txtnodogestor').val("{{old('txtnodogestor')}}");
                $('#txtlinea').val("{{old('txtlinea')}}");
                $("#txthonorario").val("{{old('txthonorario')}}");
            @else
                $("#txtnodogestor").val();
                $("#txtlinea").val();
                $("#txthonorario").val();
            @endif
            
            $("#txtnodogestor").material_select();
            $("#txtlinea").material_select();

        }



        if ($('#infocenter').css('display') === 'block') {
            @if($errors->any())
                $('#txtnodoinfocenter').val("{{old('txtnodoinfocenter')}}");
                $('#txtextension').val("{{old('txtextension')}}");
            @else 
                $("#txtnodoinfocenter").val();
                $("#txtextension").val();
            @endif
            $("#txtnodoinfocenter").material_select();

        }

        if($('#ingreso').css('display') === 'block')
        {
              @if($errors->any())
                  $("#txtnodoingreso").val("{{old('txtnodoingreso')}}");
              @else
                $("#txtnodoingreso").val();
              @endif
              $("#txtnodoingreso").material_select(); 
        }

        if ($('#talento').css('display') === 'block') {
            $("#txtperfil").val();
            $("#txtperfil").material_select();
            $("#txtregional").val();
            $("#txtregional").material_select();
            $("#txtcentroformacion").val();
            $("#txtcentroformacion").material_select();
            
            $("#txtuniversidad").val(); 
            $("#txtempresa").val(); 
            $("#txtotrotipotalento").val(); 
            $("#txtgrupoinvestigacion").val();

            $('.aprendizSena').hide();
            $('.estudianteUniversitario').hide();
            $('#funcionarioEmpresa').hide();
            $('#otroTipoTalento').hide();
            $('.investigador').hide(); 
        }

        $('#dinamizador').hide();
        $('#gestor').hide();
        $('#infocenter').hide();
        $('#talento').hide();
        $('#ingreso').hide();
        $("input[type=checkbox]:checked").each(function(){
        
            if ($(this).val() == '{{App\User::IsDinamizador()}}') {
                
                $('#dinamizador').show();
   
            }else if($(this).val() == '{{App\User::IsGestor()}}'){
                $('#gestor').show();
            }else if($(this).val() == '{{App\User::IsInfocenter()}}'){
                $('#infocenter').show();
            }else if($(this).val() == '{{App\User::IsTalento()}}'){
                $('#talento').show();
            }else if($(this).val() == '{{App\User::IsIngreso()}}'){
                $('#ingreso').show();
            }

        });
       
        
    }
};

var linea = {
    getSelectLineaForNodo:function(){
      let nodo = $('#txtnodogestor').val();
      $.ajax({
        dataType:'json',
        type:'get',
        url:'/lineas/getlineasnodo/'+nodo
      }).done(function(response){

        $('#txtlinea').empty();
        if (response.lineasForNodo.lineas == '') {
            $('#txtlinea').append('<option value="">No hay lineas disponibles</option>');
        }else{
            
            $('#txtlinea').append('<option value="">Seleccione la linea</option>');

            $.each(response.lineasForNodo.lineas, function(i, e) {
                $('#txtlinea').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
            });
            @if($errors->any())
              $('#txtlinea').val("{{old('txtlinea')}}");
            @endif
        }
        
        
        
        $('#txtlinea').material_select();
      });
    },

  }





</script>
@endpush
