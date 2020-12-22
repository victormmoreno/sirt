@extends('layouts.app')

@section('meta-title', 'Usuarios')

@section('content')


<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                            <a class="footer-text left-align" href="{{route('usuario.index')}}">
                                <i class="material-icons arrow-l">arrow_back</i>
                            </a>Usuarios
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
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
                            <div class="center">
                                <span class="card-title center center-align">
                                    Editar Usuario:
                                    <b class="hand-of-Sean-fonts orange-text text-darken-3">
                                        {{$user->nombres}} {{$user->apellidos}}
                                    </b>
                                </span>
                                <i class="Small material-icons prefix">
                                    supervised_user_circle
                                </i>
                            </div>
                            <div class="divider">
                            </div>
                            <div class="col s12 m12 l12">
                                <div class="mailbox-view">
                                    <div class="mailbox-view-header">
                                        <div class="center">
                                            <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Información básica</h5>
                                        </div>
                                    </div>
                                    <form id="formEditUser" action="{{ route('usuario.usuarios.update',$user->id)}}" method="POST" onsubmit="return checkSubmit()">
                                        {!! method_field('PUT')!!}
                                        @include('users.form', [
                                            'btnText' => 'Modificar',
                                        ])
                                    </form>
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
    user.getCiudadExpedicion();
    user.getCiudad();
    @if(isset($user->grado_discapacidad))
    user.getGradoDiscapacidad('{{$user->grado_discapacidad}}');
    @endif
    @if(isset($user->eps->id))
    user.getOtraEsp('{{$user->eps_id}}');
    @endif
    @if(isset($user->talento->tipotalento->id))
    tipoTalento.getSelectTipoTalento('{{$user->talento->tipotalento->id}}');
    @endif
    tipoTalento.getCentroFormacionAprendiz();
    tipoTalento.getCentroFormacionEgresadoSena();
    tipoTalento.getCentroFormacionFuncionarioSena();
    tipoTalento.getCentroFormacionInstructorSena();
    ocupacion.getOtraOcupacion();
    roles.getRoleSeleted();
    linea.getSelectLineaForNodo();
});
function falseCheckbox() {
    return false;
}
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
                $('#txtnodogestor').val({{old('txtnodogestor')}});
                $('#txtlinea').val({{old('txtlinea')}});
                $("#txthonorario").val('{{old('txthonorario')}}');
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
var tipoTalento = {
    getSelectTipoTalento:function (idtipotalento) {
        let valor = $(idtipotalento).val();
        let nombretipotalento = $("#txttipotalento option:selected").text();
        if((nombretipotalento == '{{App\Models\TipoTalento::IS_APRENDIZ_SENA_CON_APOYO }}' ||
            nombretipotalento == '{{App\Models\TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO }}') ){
            tipoTalento.showAprendizSena();
        }else if(nombretipotalento == '{{App\Models\TipoTalento::IS_EGRESADO_SENA }}' ){
            tipoTalento.showEgresadoSena();
        }
        else if(nombretipotalento == '{{App\Models\TipoTalento::IS_INSTRUCTOR_SENA }}' ){
            tipoTalento.showInstructorSena();
        }
        else if(nombretipotalento == '{{App\Models\TipoTalento::IS_FUNCIONARIO_SENA }}'){
            tipoTalento.showFuncionarioSena();
        }
        else if(nombretipotalento == '{{App\Models\TipoTalento::IS_PROPIETARIO_EMPRESA }}'){
            tipoTalento.showPropietarioEmpresa();
        }
        else if(nombretipotalento == '{{App\Models\TipoTalento::IS_EMPRENDEDOR }}'){
            tipoTalento.showEmprendedor();
        }
        else if(nombretipotalento == '{{App\Models\TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO }}'){
            tipoTalento.showUniversitario();
        }
        else if(nombretipotalento == '{{App\Models\TipoTalento::IS_FUNCIONARIO_EMPRESA }}' ){
            tipoTalento.showFuncionarioEmpresa();
        }
        else{
            tipoTalento.ShowSelectTipoTalento();
        }
    },
    showAprendizSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".aprendizSena").css("display", "block");
    },
    showEgresadoSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".egresadoSena").css("display", "block");
        $(".egresadoSena").show();
    },
    showInstructorSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".instructorSena").css("display", "block");
    },
    showFuncionarioSena: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $(".funcionarioSena").css("display", "block");
    },
    showPropietarioEmpresa: function (){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();

        $('.otherUser').empty();
        $('.otherUser').append(`<div class="valign-wrapper" >
            <h5> Seleccionaste Propietario empresa</h5>
        </div>`);
    },
    showEmprendedor: function (){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hideUniversitario();
        tipoTalento.hideFuncionarioEmpresa();
        $('.otherUser').empty();
        $('.otherUser').append(`<div class="valign-wrapper" >
            <h5> Seleccionaste Emprendedor</h5>
        </div>`);
    },

    showUniversitario: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideEmprendedor();
        tipoTalento.hideFuncionarioEmpresa();
        $(".universitario").css("display", "block");
    },
    showFuncionarioEmpresa: function(){
        tipoTalento.hideSelectTipoTalento();
        tipoTalento.hideAprendizSena();
        tipoTalento.hideEgresadoSena();
        tipoTalento.hideInstructorSena();
        tipoTalento.hideFuncionarioSena();
        tipoTalento.hidePropietarioEmpresa();
        tipoTalento.hideUniversitario();
        tipoTalento.hideEmprendedor();
        $(".funcionarioEmpresa").css("display", "block");
    },

    hideAprendizSena: function(){
        $(".aprendizSena").css("display", "none");
    },
    hideEgresadoSena: function(){
        $(".egresadoSena").hide();
    },
    hideInstructorSena: function(){
        $(".instructorSena").css("display", "none");
    },
    hideFuncionarioSena: function(){
        $(".funcionarioSena").css("display", "none");
    },
    hideSelectTipoTalento: function(){
        $(".selecttipotalento").css("display", "none");
    },
    hidePropietarioEmpresa: function(){
        $(".otherUser").css("display", "none");
    },
    hideUniversitario: function(){
        $(".universitario").css("display", "none");
    },
    hideFuncionarioEmpresa: function(){
        $(".funcionarioEmpresa").css("display", "none");
    },

    hideEmprendedor: function(){
        $(".otherUser").css("display", "none");
    },
    ShowSelectTipoTalento: function(){
        tipoTalento.hideAprendizSena();
        $(".selecttipotalento").css("display", "block");
    },
    getCentroFormacionAprendiz:function (){
        let regional = $('#txtregional_aprendiz').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_aprendiz').empty();
            $('#txtcentroformacion_aprendiz').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_aprendiz').append('<option  value="'+id+'">'+nombre+'</option>');
                @if(isset($user->talento->entidad))
                    $('#txtcentroformacion_aprendiz').select2('val','{{$user->talento->entidad->id}}');
                @endif
                $('#txtcentroformacion_aprendiz').material_select();
            });
            
        });
    },
    getCentroFormacionEgresadoSena:function (){
        let regional = $('#txtregional_egresado').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_egresado').empty();
            $('#txtcentroformacion_egresado').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_egresado').append('<option  value="'+id+'">'+nombre+'</option>');
                @if(isset($user->talento->entidad))
                    $('#txtcentroformacion_egresado').select2('val','{{$user->talento->entidad->id}}');
                    @endif
                $('#txtcentroformacion_egresado').material_select();
            });
        });
    },
    getCentroFormacionFuncionarioSena:function (){
        let regional = $('#txtregional_funcionarioSena').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_funcionarioSena').empty();
            $('#txtcentroformacion_funcionarioSena').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_funcionarioSena').append('<option  value="'+id+'">'+nombre+'</option>');
                @if(isset($user->talento->entidad))
                    $('#txtcentroformacion_funcionarioSena').select2('val','{{$user->talento->entidad->id}}');
                    @endif
                $('#txtcentroformacion_funcionarioSena').material_select();
            });
        });
    },
    getCentroFormacionInstructorSena:function (){
        let regional = $('#txtregional_instructorSena').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/centro-formacion/getcentrosregional/'+regional
        }).done(function(response){
            $('#txtcentroformacion_instructorSena').empty();
            $('#txtcentroformacion_instructorSena').append('<option value="">Seleccione el centro de formación</option>')
            $.each(response.centros, function(id, nombre) {
                $('#txtcentroformacion_instructorSena').append('<option value="'+id+'">'+nombre+'</option>');
                @if(isset($user->talento->entidad))
                $('#txtcentroformacion_instructorSena').select2('val','{{$user->talento->entidad->id}}');
                @endif
                $('#txtcentroformacion_instructorSena').material_select();
            });
        });
    },

}
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
            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsDinamizador() || session()->get('login_role') == App\User::IsAdministrador()))
                $('#txtlinea').append('<option value="">Seleccione la linea</option>');
                $.each(response.lineasForNodo.lineas, function(i, e) {
                    $('#txtlinea').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                });
                @if(isset($user->gestor->lineatecnologica_id))
                    $('#txtlinea').val('{{$user->gestor->lineatecnologica_id}}');
                @endif
            @endif
            @if(session()->get('login_role') == App\User::IsGestor())
                $.each(response.lineasForNodo.lineas, function(i, e) {
                    $('#txtlinea').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                });
                @if(isset($user->gestor->lineatecnologica_id))
                    $('#txtlinea').val('{{$user->gestor->lineatecnologica_id}}');
                @endif
            @endif
        }
        $('#txtlinea').material_select();
    });
    },
}
var user = {
    getCiudadExpedicion:function(){
        let id;
        id = $('#txtdepartamentoexpedicion').val();
        $.ajax({
            dataType:'json',
            type:'get',
            url:'/usuario/getciudad/'+id
        }).done(function(response){
            $('#txtciudadexpedicion').empty();
            $('#txtciudadexpedicion').append('<option value="">Seleccione la Ciudad</option>')
            $.each(response.ciudades, function(i, e) {
                $('#txtciudadexpedicion').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                @if(isset($user->ciudadexpedicion->id))
                    $('#txtciudadexpedicion').select2('val','{{$user->ciudadexpedicion->id}}');
                @endif
            });
            $('#txtciudadexpedicion').material_select();
        });
    },
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
                @if(isset($user->ciudad->id))
                    $('#txtciudad').select2('val','{{$user->ciudad->id}}');
                @endif
            });
            $('#txtciudad').material_select();
        });
    },
    getOtraEsp:function (ideps) {
        let id = $("#txteps").val();
        let nombre = $("#txteps option:selected").text();
        if (nombre == '{{App\Models\Eps::OTRA_EPS }}') {
            $(".otraeps").css("display", "block");
        }else{
            $(".otraeps").css("display", "none");
        }
    },
    getGradoDiscapacidad(discapacidad){
        let gradodiscapacidad = $("#txtgrado_discapacidad").val();
        if (gradodiscapacidad == 1) {
            $('.gradodiscapacidad').css("display", "block");
        }else{
            $(".gradodiscapacidad").css("display", "none");
        }
    }
}
</script>
@endpush
