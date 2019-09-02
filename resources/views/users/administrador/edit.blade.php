@extends('layouts.app')

@section('meta-title', 'Usuarios')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l10">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                    <i class="material-icons arrow-l">
                                        arrow_back
                                    </i>
                                </a>
                                Usuarios
                            </a>
                        </h5>
                    </div>
                    <div class="col s4 m4 l2 rigth-align">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="{{route('home')}}">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a href="{{route('usuario.index')}}">
                                    Usuarios
                                </a>
                            </li>
                            <li class="active">
                                Editar Usuario
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <center>
                                    <span class="card-title center-align">
                                        Editar Usuario:
                                        <b>
                                            {{$user->nombres}} {{$user->apellidos}}
                                        </b>
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
                                                    <span class="mailbox-title">
                                                        Información Básica
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('usuario.usuarios.update',$user->id)}}" method="POST" onsubmit="return checkSubmit()">
                                            {!! method_field('PUT')!!}
                                          @include('users.administrador.form', [
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
    ocupacion.getOtraOcupacion();
    roles.getRoleSeleted();
    grupoInvestigacion.getGrupoInvestigacion();
    TipoTalento.getSelectTipoTalento();
    regional.getCentroFormacion();
    UserEdit.getCiudad();
        linea.getSelectLineaForNodo();
    @if($errors->any())
    @endif
});

function falseCheckbox() {
  return false;
}
    


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

var ocupacion = {
    getOtraOcupacion:function (idocupacion) {
        $('#otraocupacion').hide();
        let id = $(idocupacion).val();
        let nombre = $("#txtocupaciones option:selected").text();
        let resultado = nombre.match(/[A-Z][a-z]+/g);
        @if($errors->any())
            $('#otraocupacion').hide();
           
              if (resultado != null  && resultado.includes('{{App\Models\Ocupacion::IsOtraOcupacion() }}')) {
                  $('#otraocupacion').show();
              }

        @endif
          if (resultado != null ) {
              if (resultado.includes('{{App\Models\Ocupacion::IsOtraOcupacion() }}')) {
                  $('#otraocupacion').show();
              }
          }     
    }
};

var TipoTalento = {
    getSelectTipoTalento:function (idperfil) {
        let id = $(idperfil).val();
        if($('.aprendizSena').css('display') === 'block')
        {
          @if($errors->any())
              $("#txtregional").val({{old('txtregional')}});
              $("#txtcentroformacion").val({{old('txtcentroformacion')}});
             
          @else
              $("#txtregional").val();
              $("#txtcentroformacion").val('');
              $("#txtprogramaformacion").val();
          @endif
          $("#txtregional").material_select();  
          $("#txtcentroformacion").material_select();  
        }

        if($('.estudianteUniversitario').css('display') === 'block')
        {
              @if($errors->any())
                $('#txtuniversidad').val({{old('txtuniversidad')}});
              @else
                  $('#txtuniversidad').val();
              @endif
        }

        if($('#funcionarioEmpresa').css('display') === 'block')
        {
              @if($errors->any())
                $('#txtempresa').val('{{old('txtempresa')}}');
              @else
                @if(isset($user->talento->empresa) )
                  $('#txtempresa').val('{{$user->talento->empresa}}');
                @endif
              @endif 
        }
        
        if($('.investigador').css('display') == 'block')
        {
              @if($errors->any())
                $('#txtgrupoinvestigacion').val('{{old('txtgrupoinvestigacion')}}');
              @else
                  @if(isset($user->talento->entidad->nombre))
                    $('#txtgrupoinvestigacion').val("{{$user->talento->entidad->nombre}}");
                  @endif
              @endif 
        }else{
          @if(isset($user->talento->entidad->nombre))
              $('#txtgrupoinvestigacion').val("{{$user->talento->entidad->nombre}}");
          @endif
        }
        if ($("#otroTipoTalento").css('display') === 'block') {
              
              @if($errors->any())
                $('#txtotrotipotalento').val({{old('txtotrotipotalento')}});
              @else
                  $('#txtotrotipotalento').val();
              @endif 
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
                                        <select class="" id="txtdepartamentogrupo" name="txtdepartamentogrupo" onchange="UserEdit.getCiudadForModal()" style="width: 100%" tabindex="-1" >
                                            <option value="">Seleccione Departamento</option>
                                            @foreach($departamentos as $value)
                                               
                                                    <option value="{{$value->id}}" {{old('txtdepartamento') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                               
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
        $('#gruposmodal_table').DataTable({
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            }
        });
        
    
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
        

        $('#txtcentroformacion').empty();

        @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
          @if(isset($user->talento->entidad->centro->id))
      
          $('#txtcentroformacion').append('<option value="{{$user->talento->entidad->centro->id}}">{{$user->talento->entidad->nombre}}</option>');
          @endif
        @else
        $('#txtcentroformacion').append('<option value="">Seleccione el centro de formación</option>')
        $.each(response.centros, function(id, nombre) {
          $('#txtcentroformacion').append('<option  value="'+id+'">'+nombre+'</option>');
          @if($errors->any())
            $('#txtcentroformacion').val("{{old('txtcentroformacion')}}");
          @else
            @if(isset($user->talento->entidad->centro->id))
              $('#txtcentroformacion').val({{$user->talento->entidad->centro->id}});
            @endif
          @endif
        });
        @endif
        $('#txtcentroformacion').material_select();
         
      });    
      
    }
}

var roles = {
    getRoleSeleted:function (idrol) {
        let role = $(idrol).val();
        if($('#dinamizador').css('display') === 'block')
        {
              @if($errors->any())
                  $("#txtnododinamizador").val({{old('txtnododinamizador')}});
              @else
                $("#txtnododinamizador").val();
              @endif
              $("#txtnododinamizador").material_select(); 
        }

        if ($('#gestor').css('display') === 'block') {
            
            @if($errors->any())
                $('#txtnodogestor').val({{old('txtnodogestor')}});
                $('#txtlinea').val({{old('txtlinea')}});
                $("#txthonorario").val({{old('txthonorario')}});
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
                $('#txtnodoinfocenter').val({{old('txtnodoinfocenter')}});
                $('#txtextension').val({{old('txtextension')}});
            @else 
                $("#txtnodoinfocenter").val();
                $("#txtextension").val();
            @endif
            $("#txtnodoinfocenter").material_select();

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
        
            if ($(this).val() == 'Dinamizador') {
                
                $('#dinamizador').show();
   
            }else if($(this).val() == 'Gestor'){
                $('#gestor').show();
            }else if($(this).val() == 'Infocenter'){
                $('#infocenter').show();
            }else if($(this).val() == 'Talento'){
                $('#talento').show();
            }else if($(this).val() == 'Ingreso'){
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

            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                $('#txtlinea').append('<option value="">Seleccione la linea</option>');

                $.each(response.lineasForNodo.lineas, function(i, e) {  
                      $('#txtlinea').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                           
                });
                
                @if($errors->any())
                    $('#txtlinea').val('{{old('txtlinea')}}');
                @else
                    @if(isset($user->gestor->lineatecnologica_id))
                    $('#txtlinea').val('{{$user->gestor->lineatecnologica_id}}');
                    @endif
                @endif
            @else
                @if($errors->any())
                    $('#txtlinea').val('{{old('txtlinea')}}');
                @else
                    @if(isset($user->gestor->lineatecnologica_id))
                    $('#txtlinea').append('<option value="{{$user->gestor->lineatecnologica->id}}">{{$user->gestor->lineatecnologica->nombre}}</option>');
                    @endif
                @endif
            @endif


        }
        
        $('#txtlinea').material_select();
      });
    },

  }



var UserEdit = {
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
        @else
        $('#txtciudad').val({{$user->ciudad->id}});
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
