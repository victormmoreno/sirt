
  	<div class="row">
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txtlaboratorio">Laboratorio <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlaboratorio" id="txtlaboratorio" >
	            <option value="">Seleccione laboratorio</option>
	            @forelse($laboratorios as $id => $laboratorio)
	              <option value="{{$id}}">{{$laboratorio}}</option>
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
		</div>
		 <div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtnombre" id="txtnombre" value="{{ isset($equipo) ? $equipo->nombre: ''}}"/>
	      	<label class="active" for="txtnombre">Nombre de Equipo <span class="red-text">*</span></label>
	    </div>
	</div>
	<div class="row">
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtreferencia" id="txtreferencia" value="{{ isset($equipo) ? $equipo->referencia: ''}}"/>
	      	<label class="active" for="txtreferencia">Referencia <span class="red-text">*</span></label>
	    </div>
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtmarca" id="txtmarca" value="{{ isset($equipo) ? $equipo->marca: ''}}"/>
	      	<label class="active" for="txtmarca">Marca <span class="red-text">*</span></label>
	    </div>
		 
	</div>
	<div class="row">
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtcostoadquisicion" id="txtcostoadquisicion" value="{{ isset($equipo) ? $equipo->costo_adquisicion: ''}}"/>
	      	<label class="active" for="txtcostoadquisicion">Costo Adquisición con IVA<span class="red-text">*</span> </label>
	    </div>
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtvida_util" id="txtvida_util" value="{{ isset($equipo) ? $equipo->marca: ''}}"/>
	      	<label class="active" for="txtvida_util">Vida Util (años) <span class="red-text">*</span></label>
	    </div>
		 <div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtaniocompra" id="txtaniocompra" value="{{ isset($equipo) ? $equipo->costo_adquisicion: ''}}"/>
	      	<label class="active" for="txtaniocompra">Año de compra <span class="red-text">*</span></label>
	    </div>
	</div>


{{-- <div class="row">
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
</div> --}}
<div class="divider"></div>
<center>
  	<button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
  	<a href="{{route('equipo.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
</center>