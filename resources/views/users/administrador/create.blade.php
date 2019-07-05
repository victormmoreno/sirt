@extends('layouts.app')

@section('meta-title', 'Administradores')

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
                    Usuarios
                </h5>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">

                                <center>
                                    <span class="card-title center-align">
                                        Nuevo Usuario
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
                                <form action="{{ route('usuario.administrador.store')}}" method="POST" onsubmit="return checkSubmit()">
                                    @include('users.administrador.form', [
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
    eps.getOtraEsp();
  
    roles.getRoleSeleted();
    @if($errors->any())
        UserAdministradorCreate.getCiudad();
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
};

var roles = {
    getRoleSeleted:function (idrol) {
        let role = $(idrol).val();

        // console.log($(idrol).prop('checked') );

        // if(!$(idrol).prop('checked') && role !== 'Dinamizador'){
        //     $('#dinamizador').hide();
        // }else if($(idrol).prop('checked') && role === 'Dinamizador'){
        //     $('#dinamizador').show();
        // }else{
        //     $('#dinamizador').hide();
        // }
        $('#dinamizador').hide();
        $('#gestor').hide();
        $('#infocenter').hide();
        $("input[type=checkbox]:checked").each(function(){
        //cada elemento seleccionado
        // console.log($(this).val());
            if ($(this).val() == 'Dinamizador') {
                console.log($(this).val());
                $('#dinamizador').show();
            }else if($(this).val() == 'Gestor'){
                $('#gestor').show();
            }else if($(this).val() == 'Infocenter'){
                $('#infocenter').show();
            }
            
            
        });
       
        
    }
};

var UserAdministradorCreate = {
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
          // console.log(e.id);
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
