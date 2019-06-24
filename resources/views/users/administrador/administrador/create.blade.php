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
                                        Nuevo Administrador
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
                                    @include('users.administrador.administrador.form', [
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
    eps.getOtraEsp();
     @if($errors->any())
    UserAdministradorCreate.getCiudad();
    @endif

});
    
//  var UserAdmininstradorOcupacion = {
//     addOcupacion:function(e){
//         let id = $(e).val();

//         console.log(id);
       
//         $.ajax({
//             dataType:'json',
//             type:'get',
//             url:'/usuario/administrador/anadir-ocupacion/'+ id,
//         }).done(function(response){
//             // console.log(response.ocupacion);
//             UserAdmininstradorOcupacion.getOcupaciones();
//             // $('#tblOcupacionAdministradorCreate').empty();
//             // $.each(response.ocupacion, function (i,elemento){
                
//             //      $.each(elemento, function (e,el){
//             //         console.log(el.item.nombre);
//             //         $('#tblOcupacionAdministradorCreate').append('<tr>'
//             //         +'<td>'+el.item.nombre+'</td>'
//             //         +'<td>'+el.item.nombre+'</td>');

//             //      });
                
            
//             // });
//         });
//     },
//     getOcupaciones: function(){
//         $.ajax({
//             dataType:'json',
//             type:'get',
//             url:'/usuario/administrador/getOcupaciones',
//         }).done(function(response){
//             // console.log(response.getOcupacion.items);
            
//             $('#tblOcupacionAdministradorCreate').empty();
                      
//             $.each(response.getOcupacion.items, function (i,elemento){
                   
//                     $('#tblOcupacionAdministradorCreate').append('<tr>'
//                     +'<td>'+elemento.item.nombre+'</td>'
//                      +'<td><a class="waves-effect red lighten-3 btn" onclick="UserAdmininstradorOcupacion.getEliminar('+elemento.item.id+');"><i class="material-icons">delete_sweep</i></a></td>'
//                     +'</tr>');

                
            
//             });
//         });
//     },
//     getEliminar:function (idOcupacion) {
//         console.log(idOcupacion);
//         $.ajax({
//           type:'get',
//           dataType:'json',
//           url:'/usuario/administrador/remove-ocupacion/'+idOcupacion,
//         }).done(function(respuesta){
//                 console.log(respuesta);
//                 UserAdmininstradorOcupacion.getOcupaciones();
//         });
//     },
// }

var eps = {
    getOtraEsp:function (ideps) {
        let id = $(ideps).val();
        let nombre = $("#txteps option:selected").text();
        if (nombre != '{{App\Models\Eps::OTRA_EPS }}') {
            $('#otraeps').hide();
             
        }else{
            console.log(nombre);
            $('#otraeps').show();
        }
        console.log(id);
        
    }
}

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
