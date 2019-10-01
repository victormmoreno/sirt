@extends('layouts.app')
@section('meta-title', 'Equipos ' . 'Tecnoparque Nodo ' . \NodoHelper::returnNameNodoUsuario())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
        		<div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('equipo.index')}}">
				              	<i class="material-icons arrow-l">arrow_back</i>
				            </a> Equipos Tecnoparque Nodo  {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('equipo.index')}}">Equipos</a></li>
                            <li class="active">Nuevo Equipo</li>
                        </ol>
                    </div>
                </div>
          		<div class="card">
            		<div class="card-content">
              			<div class="row">
			                <center>
				                <span class="card-title center-align">Nuevo Equipo Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}
				                </span>
			                </center>
                			<div class="divider"></div>
                			<br/>
                			<form id="formEquipoCreate" action="{{route('ingreso.store')}}" method="POST" onsubmit="return checkSubmit()">
			                  	{!! csrf_field() !!}
			                  	@include('equipo.form', [
			                  	'btnText' => 'Registrar'
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
	    divRegistrarEquipo = $('#divRegistrarEquipo');
	    divEquipoRegistrado = $('#divEquipoRegistrado');
	    divRegistrarEquipo.hide();
	    divEquipoRegistrado.hide();

	    var equipoCreate = {
	    	emptyInputEquipRegistered: function (){
	    		$("label[for='txtlaboratorioEquipoRegistrado']").removeClass('active');
				$('#txtlaboratorioEquipoRegistrado').val();
				$('#txtlaboratorioEquipoRegistrado').select2();

				$("label[for='txtnombreEquipoRegistrado']").removeClass('active');
				$('#txtnombreEquipoRegistrado').val();

				$("label[for='txtmarcaEquipoRegistrado']").removeClass('active');
				$('#txtmarcaEquipoRegistrado').val();


				$("label[for='txtcostoadquisicionEquipoRegistrado']").removeClass('active');
				$('#txtcostoadquisicionEquipoRegistrado').val();

				$("label[for='txtvida_utilEquipoRegistrado']").removeClass('active');
				$('#txtvida_utilEquipoRegistrado').val();

				$("label[for='txtaniocompraEquipoRegistrado']").removeClass('active');
				$('#txtaniocompraEquipoRegistrado').val();
	    	}
	    }

	    function getEquiposTecnoparque(){
    		let codigo = $('#txtcodigoequipo').val();
    		if (codigo == "") {
			    Swal.fire({
			      title: 'Advertencia!',
			      text: "Digite el código del equipo!",
			      type: 'warning',
			      showCancelButton: false,
			      confirmButtonColor: '#3085d6',
			      confirmButtonText: 'Ok'
			    });
			    equipoCreate.emptyInputEquipRegistered();

			}else {
				$.ajax({
			      	dataType: 'json',
			      	type: 'get',
			      	url : '/equipos/consultarEquipoPorCodigo/'+codigo,
			      	success: function (response) {
			      		console.log(response);
			      		if (response.equipo == null || response.equipo == '') {
				          	divEquipoRegistrado.hide();
				          	divRegistrarEquipo.show();
				          	$('#divEquipoCreate').removeClass('green lighten-5');
				          	$('#divEquipoCreate').addClass('orange lighten-5');
				          	
				        } else {
				        	$('#divEquipoCreate').removeClass('orange lighten-5');
				        	$('#divEquipoCreate').addClass('green lighten-5');
				        	$("label[for='txtlaboratorioEquipoRegistrado']").addClass('active');
				          	$('#txtlaboratorioEquipoRegistrado').val(response.equipo.laboratorio_id);
				          	$("#txtlaboratorioEquipoRegistrado option[value='"+response.equipo.laboratorio_id+"']").attr("selected", true);
				          	$('#txtlaboratorioEquipoRegistrado').select2();

				          	$("label[for='txtreferenciaEquipoRegistrado']").addClass('active');
				          	$('#txtreferenciaEquipoRegistrado').val(response.equipo.referencia);
				          	

				          	$("label[for='txtnombreEquipoRegistrado']").addClass('active');
				          	$('#txtnombreEquipoRegistrado').val(response.equipo.nombre);

				          	$("label[for='txtmarcaEquipoRegistrado']").addClass('active');
				          	$('#txtmarcaEquipoRegistrado').val(response.equipo.marca);

				          	$("label[for='txtcostoadquisicionEquipoRegistrado']").addClass('active');
				          	$('#txtcostoadquisicionEquipoRegistrado').val(response.equipo.costo_adquisicion);

				          	$("label[for='txtvida_utilEquipoRegistrado']").addClass('active');
				          	$('#txtvida_utilEquipoRegistrado').val(response.equipo.vida_util);

				          	$("label[for='txtaniocompraEquipoRegistrado']").addClass('active');
				          	$('#txtaniocompraEquipoRegistrado').val(response.equipo.anio_compra);
				          	divRegistrarEquipo.hide();
				          	divEquipoRegistrado.show();
				        }
			      	},
			      	error: function (xhr, textStatus, errorThrown) {
				        alert("Error: " + errorThrown);
				    }
				});
			}
    	}

    	//Enviar formulario
    	$(document).on('submit', 'form#formEquipoCreate', function (event) {
    		$('button[type="submit"]').attr('disabled', 'disabled');
    		event.preventDefault();
		    let form = $(this);
		    let data = new FormData($(this)[0]);
		    let url = form.attr("action");

		    $.ajax({
		        type: form.attr('method'),
		        url: url,
		        data: data,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function (data) {
		        	$('button[type="submit"]').removeAttr('disabled');
			        $('.error').hide();
		          	if (data.fail) {
		              	Swal.fire({
		                	title: 'Registro Erróneo',
		                	text: "Estas ingresando mal los datos!",
		                	type: 'error',
		                	showCancelButton: false,
		                	confirmButtonColor: '#3085d6',
		                	confirmButtonText: 'Ok'
		            	});
		            	for (control in data.errors) {
		             	 	$('#' + control + '-error').html(data.errors[control]);
		              		$('#' + control + '-error').show();
		            	}
		          	}
		        },
		        error: function (xhr, textStatus, errorThrown) {
		        	alert("Error: " + errorThrown);
		        }
	    	});
    	});

   	</script>
@endpush