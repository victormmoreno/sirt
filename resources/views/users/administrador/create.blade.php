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
                                <form action="{{ route('usuario.usuarios.store')}}" method="POST" onsubmit="return checkSubmit()">
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
      tags: true,
    });
    eps.getOtraEsp();
    TipoTalento.getSelectTipoTalento();
    grupoInvestigacion.getGrupoInvestigacion();
  
    roles.getRoleSeleted();
    @if($errors->any())
        linea.getSelectLineaForNodo();
        UserCreate.getCiudad();
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

var TipoTalento = {
    getSelectTipoTalento:function (idperfil) {
        let id = $(idperfil).val();
        if($('.aprendizSena').css('display') === 'block')
        {
          $("#txtregional").val('');
          $("#txtregional").material_select();  
          $("#txtcentroformacion").val('');
          $("#txtcentroformacion").material_select();  
        }

        if($('.estudianteUniversitario').css('display') === 'block')
        {
          $("#txtuniversidad").val('');
        }

        if($('#funcionarioEmpresa').css('display') === 'block')
        {
          $("#txtempresa").val(''); 
        }
        if($('#funcionarioEmpresa').css('display') === 'block')
        {
          $("#txtotrotipotalento").val('');
        }
        if($('.investigador').css('display') === 'block')
        {
          $("#txtgrupoinvestigacion").val('');
        }
        let nombrePerfil = $("#txtperfil option:selected").text();
        if (nombrePerfil == '{{App\Models\Perfil::IsEgresadoSena() }}' || nombrePerfil == '{{App\Models\Perfil::IsAprendizSenaConApoyo() }}' || nombrePerfil == '{{App\Models\Perfil::IsAprendizSenaSinApoyo() }}') {
                $('.estudianteUniversitario').hide();
                $('#funcionarioEmpresa').hide();
                $('#otroTipoTalento').hide();
                $('.investigador').hide();
             $('.aprendizSena').show();
        }else if(nombrePerfil == '{{App\Models\Perfil::IsEstudianteUniversitarioPregrado() }}' || nombrePerfil == '{{App\Models\Perfil::IsEstudianteUniversitarioPostgrado() }}'){
             $('.aprendizSena').hide();
             $('#funcionarioEmpresa').hide();
             $('#otroTipoTalento').hide();
             $('.investigador').hide();
             $('.estudianteUniversitario').show();
        }else if(nombrePerfil == '{{App\Models\Perfil::IsFuncionarioEmpresaPublica() }}' || nombrePerfil == '{{App\Models\Perfil::IsFuncionarioMicroempresa() }}' || nombrePerfil == '{{App\Models\Perfil::IsFuncionarioMedianaEmpresa() }}' || nombrePerfil == '{{App\Models\Perfil::IsFuncionarioGrandeEmpresa() }}'){
             $('.aprendizSena').hide();
             $('.estudianteUniversitario').hide();
             $('#otroTipoTalento').hide(); 
             $('.investigador').hide();
             $('#funcionarioEmpresa').show(); 
        }else if(nombrePerfil == '{{App\Models\Perfil::IsOtro() }}'){
             $('.aprendizSena').hide();
             $('#funcionarioEmpresa').hide();
             $('.estudianteUniversitario').hide();
             $('.investigador').hide(); 
             $('#otroTipoTalento').show();
        }else if(nombrePerfil == '{{App\Models\Perfil::IsInvestigador() }}'){
             $('.aprendizSena').hide();
             $('#funcionarioEmpresa').hide();
             $('.estudianteUniversitario').hide(); 
             $('#otroTipoTalento').hide(); 
             $('.investigador').show(); 
        }else{
            $('.aprendizSena').hide();
            $('.estudianteUniversitario').hide();
            $('#funcionarioEmpresa').hide();
            $('#otroTipoTalento').hide();
            $('.investigador').hide();
        }
        
        
    }
    

};
var grupoInvestigacion = {
    getGrupoInvestigacion:function () {
        
        $('.modal-trigger').leanModal();
        $(".contenido").empty();
        $(".contenido").html(`<div class="row">
                                    <div class="input-field col s12 m6 l6 ">
                                        <i class="material-icons prefix">
                                             details
                                        </i>
                                        <select class="" id="txtdepartamentogrupo" name="txtdepartamentogrupo" onchange="UserCreate.getCiudadForModal()" style="width: 100%" tabindex="-1" >
                                            <option value="">Seleccione Departamento</option>
                                            @foreach($departamentos as $value)
                                                @if(isset($user->ciudad->departamento->id))
                                                    <option value="{{$value->id}}" {{old('txtdepartamento',$user->ciudad->departamento->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                                @else
                                                    <option value="{{$value->id}}" {{old('txtdepartamento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                                @endif
                                            @endforeach
                                        </select>
                                        <label for="txtdepartamentogrupo">Departamento</option> <span class="red-text">*</span></label>
                                        @error('txtdepartamentogrupo')
                                            <label id="txtdepartamentogrupo-error" class="error" for="txtdepartamentogrupo">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="input-field col s12 m6 l6 ">
                                        <i class="material-icons prefix">
                                             details
                                        </i>
                                        <select class="" id="txtciudadgrupo" name="txtciudadgrupo" onchange="grupoInvestigacion.selectGrupoForCiudad()" style="width: 100%" tabindex="-1" >
                                            <option value="">Seleccione primero el departamento</option>
                                            
                                        </select>
                                        <label for="txtciudadgrupo">Ciudad <span class="red-text">*</span></label>
                                        @error('txtciudadgrupo')
                                            <label id="txtciudadgrupo-error" class="error" for="txtciudadgrupo">{{ $message }}</label>
                                        @enderror
                                    </div>
                                    <div class="divider mailbox-divider"></div>
                                    <table class="display responsive-table" id="gruposmodal_table">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Institución</th>
                                    </thead>
                    
                                </table>
                                </div>`);

        $('#txtdepartamentogrupo').material_select();
        $('#txtciudadgrupo').material_select();
        $('#gruposmodal_table').dataTable().fnDestroy();
        
        
    
    },
    selectGrupoForCiudad:function () {
        let ciudadGrupo = $('#txtciudadgrupo').val();
        $('#gruposmodal_table').dataTable().fnDestroy();
        $('#gruposmodal_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            processing: true,
             serverSide: true,
             order: false,
             ajax: {
                 url: "/grupo/getgrupodatatables/" + ciudadGrupo,
                 type: "get",
             },
             columns: [
             {
                 data: 'details',
                 name: 'details',
             },
             {
                 data: 'codigo_grupo',
                 name: 'codigo_grupo',
             },{
                 data: 'nombre',
                 name: 'nombre',
             }, {
                 data: 'institucion',
                 name: 'institucion',
             },
             ],
        });
    },
    getCheckoxSeletedDatatables:function(grupo){
        let nombreGrupo = $(grupo).val();
        $('#modal1').closeModal();
        $('label:last').addClass( "active" );
        $('#txtgrupoinvestigacion').val(nombreGrupo);


    }

}




var regional = {
    getCentroFormacion:function (){
        let regional = $('#txtregional').val();
        $.ajax({
        dataType:'json',
        type:'get',
        url:'/centro-formacion/getcentrosregional/'+regional
      }).done(function(response){
        console.log(response);
        $('#txtcentroformacion').empty();
        $('#txtcentroformacion').append('<option value="">Seleccione el centro de formación</option>')
        $.each(response.centros, function(id, nombre) {
          // console.log(e.id);
          $('#txtcentroformacion').append('<option  value="'+id+'">'+nombre+'</option>');
        });
        $('#txtcentroformacion').material_select();
       
      });
    }
}

var roles = {
    getRoleSeleted:function (idrol) {
        let role = $(idrol).val();
        if($('#dinamizador').css('display') === 'block')
        {
          $("#txtnododinamizador").val('');
          $("#txtnododinamizador").material_select();  
        }

        if ($('#gestor').css('display') === 'block') {
            $("#txtnodogestor").val('');
            $("#txtnodogestor").material_select();
            $("#txtlinea").val('');  
            $("#txtlinea").material_select('');
            $("#txthonorario").val(''); 
        }

        if ($('#infocenter').css('display') === 'block') {
            $("#txtnodoinfocenter").val('');
            $("#txtnodoinfocenter").material_select();
            $("#txtextension").val(''); 
        }

        if ($('#talento').css('display') === 'block') {
            $("#txtperfil").val('');
            $("#txtperfil").material_select();
            $("#txtregional").val('');
            $("#txtregional").material_select();
            $("#txtcentroformacion").val('');
            $("#txtcentroformacion").material_select();
            
            $("#txtuniversidad").val(''); 
            $("#txtempresa").val(''); 
            $("#txtotrotipotalento").val(''); 
            $("#txtgrupoinvestigacion").val('');

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
        $("input[type=checkbox]:checked").each(function(){
        
            if ($(this).val() == 'Dinamizador') {
                
                $('#dinamizador').show();
   
            }else if($(this).val() == 'Gestor'){
                $('#gestor').show();
            }else if($(this).val() == 'Infocenter'){
                $('#infocenter').show();
            }else if($(this).val() == 'Talento'){
                $('#talento').show();
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
        console.log(response.lineasForNodo.lineas);
        $('#txtlinea').empty();
        if (response.lineasForNodo.lineas == '') {
            $('#txtlinea').append('<option value="">No hay lineas disponibles</option>');
        }else{
            
            $('#txtlinea').append('<option value="">Seleccione la linea</option>');

            $.each(response.lineasForNodo.lineas, function(i, e) {
                $('#txtlinea').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
            });
        }
        
        
        
        $('#txtlinea').material_select();
      });
    },

  }



var UserCreate = {
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
    getCiudadForModal:function(){
      let id;
      id = $('#txtdepartamentogrupo').val();
      $.ajax({
        dataType:'json',
        type:'get',
        url:'/usuario/getciudad/'+id
      }).done(function(response){
        $('#txtciudadgrupo').empty();
        $('#txtciudadgrupo').append('<option value="">Seleccione la Ciudad</option>')
        $.each(response.ciudades, function(i, e) {
          $('#txtciudadgrupo').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
        })
        @if($errors->any())
        $('#txtciudadgrupo').val({{old('txtciudadgrupo')}});
        @endif
        $('#txtciudadgrupo').material_select();
      });
    },
}


</script>
@endpush
