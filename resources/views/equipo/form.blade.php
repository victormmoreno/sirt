<div class="row">
    <div class="input-field col s11 m11 l11">
        <input id="txtcodigoequipo" name="txtcodigoequipo" type="text" value="{{ isset($equipo) ? $equipo->referencia : '' }}"/>
        <label for="txtcodigoequipo">
            Código de equipo
            <span class="red-text">
                *
            </span>
        </label>
        <small class="error red-text" id="txtcodigoequipo-error">
        </small>
    </div>
    <div class="col s1 m1 l1">
        <a class="btn-floating btn-large waves-effect tooltipped waves-light blue" data-delay="50" data-position="bottom" data-tooltip="Verificar" id="btngetEquiposTecnoparque" onclick="getEquiposTecnoparque()">
            <i class="material-icons">
                search
            </i>
        </a>
    </div>
</div>
<div id="divEquipoCreate" class="card-panel">
  	<h5 class="center">Registrar nuevo equipo</h5>
  	<div class="divider"></div>
  	<div class="row">
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txtlaboratorioRegistrarEquipo">Laboratorio <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlaboratorioRegistrarEquipo" id="txtlaboratorio" >
	            <option value="">Seleccione laboratorio</option>
	            @forelse($laboratorios as $id => $laboratorio)
	              <option value="{{$id}}">{{$laboratorio}}</option>
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
		</div>
		 <div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtnombreRegistrarEquipo" id="txtnombreRegistrarEquipo" value="{{ isset($equipo) ? $equipo->nombre: ''}}"/>
	      	<label class="active" for="txtnombreRegistrarEquipo">Nombre de Equipo <span class="red-text">*</span></label>
	    </div>
	</div>
	<div class="row">
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtreferenciaRegistrarEquipo" id="txtreferenciaRegistrarEquipo" value="{{ isset($equipo) ? $equipo->referencia: ''}}"/>
	      	<label class="active" for="txtreferenciaRegistrarEquipo">Referencia <span class="red-text">*</span></label>
	    </div>
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtmarcaRegistrarEquipo" id="txtmarcaRegistrarEquipo" value="{{ isset($equipo) ? $equipo->marca: ''}}"/>
	      	<label class="active" for="txtmarcaRegistrarEquipo">Marca <span class="red-text">*</span></label>
	    </div>
		 
	</div>
	<div class="row">
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtcostoadquisicionRegistrarEquipo" id="txtcostoadquisicionRegistrarEquipo" value="{{ isset($equipo) ? $equipo->costo_adquisicion: ''}}"/>
	      	<label class="active" for="txtcostoadquisicionRegistrarEquipo">Costo Adquisición con IVA<span class="red-text">*</span> </label>
	    </div>
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtvida_utilRegistrarEquipo" id="txtvida_utilRegistrarEquipo" value="{{ isset($equipo) ? $equipo->marca: ''}}"/>
	      	<label class="active" for="txtvida_utilRegistrarEquipo">Vida Util (años) <span class="red-text">*</span></label>
	    </div>
		 <div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtaniocompraRegistrarEquipo" id="txtaniocompraRegistrarEquipo" value="{{ isset($equipo) ? $equipo->costo_adquisicion: ''}}"/>
	      	<label class="active" for="txtaniocompraRegistrarEquipo">Año de compra <span class="red-text">*</span></label>
	    </div>
	</div>
</div>
{{-- <div id="divEquipoRegistrado" class="card-panel">
	<h5 class="center">Equipo Registrado</h5>
  	<div class="divider"></div>
  	<div class="row">
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txtlaboratorioEquipoRegistrado">Laboratorio <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlaboratorioEquipoRegistrado" id="txtlaboratorioEquipoRegistrado" disabled>
	            <option value="">Seleccione laboratorio</option>
	            @forelse($laboratorios as $id => $laboratorio)
	              <option value="{{$id}}">{{$laboratorio}}</option>
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
		</div>
		 <div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtnombreEquipoRegistrado" id="txtnombreEquipoRegistrado" value="{{ isset($equipo) ? $equipo->nombre: ''}}" readonly />
	      	<label class="active" for="txtnombreEquipoRegistrado">Nombre de Equipo <span class="red-text">*</span></label>
	    </div>
	</div>
	<div class="row">
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtreferenciaEquipoRegistrado" id="txtreferenciaEquipoRegistrado" value="{{ isset($equipo) ? $equipo->referencia: ''}}" readonly/>
	      	<label class="active" for="txtreferenciaEquipoRegistrado">Referencia <span class="red-text">*</span></label>
	    </div>
	    <div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtmarcaEquipoRegistrado" id="txtmarcaEquipoRegistrado" value="{{ isset($equipo) ? $equipo->marca: ''}}" readonly/>
	      	<label class="active" for="txtmarcaEquipoRegistrado">Marca <span class="red-text">*</span></label>
	    </div>
		 
	</div>
	<div class="row">
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtcostoadquisicionEquipoRegistrado" id="txtcostoadquisicionEquipoRegistrado" value="{{ isset($equipo) ? $equipo->costo_adquisicion: ''}}" readonly/>
	      	<label class="active" for="txtcostoadquisicionEquipoRegistrado">Costo Adquisición con IVA <span class="red-text">*</span></label>
	    </div>
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtvida_utilEquipoRegistrado" id="txtvida_utilEquipoRegistrado" value="{{ isset($equipo) ? $equipo->marca: ''}}" readonly/>
	      	<label class="active" for="txtvida_utilEquipoRegistrado">Vida Util (años) <span class="red-text">*</span></label>
	    </div>
		 <div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtaniocompraEquipoRegistrado" id="txtaniocompraEquipoRegistrado" value="{{ isset($equipo) ? $equipo->costo_adquisicion: ''}}" readonly/>
	      	<label class="active" for="txtaniocompraEquipoRegistrado">Año de compra <span class="red-text">*</span></label>
	    </div>
	</div>
</div> --}}
<div class="row">
	<h4 class="center">¿El equipo tiene mantenimiento?</h4>
</div>
<div class="row">
	<div class="input-field col s12 m6 l6">
      	<input type="text" name="txtaniomantenimiento" id="txtaniomantenimiento" value="{{ isset($equipo) ? $equipo->marca: ''}}"/>
      	<label class="active" for="txtaniomantenimiento">Año mantenimiento</label>
    </div>
	 <div class="input-field col s12 m6 l6">
      	<input type="text" name="txtvalormantenimiento" id="txtvalormantenimiento" value="{{ isset($equipo) ? $equipo->costo_adquisicion: ''}}"/>
      	<label class="active" for="txtvalormantenimiento">Valor Mantenimiento</label>
    </div>
</div>
<div class="divider"></div>
<center>
  	<button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
  	<a href="{{route('equipo.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
</center>