<div class="col s12 m10 l10 offset-l1 m1">

    {!! csrf_field() !!}
    @if ($errors->any())
    <div class="card red lighten-3">
        <div class="row">
            <div class="col s12 m12">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons left">
                            info_outline
                        </i>
                        @if(collect($errors->all())->count() > 1)
                        Tienes {{collect($errors->all())->count()}} errores
                        @else
                            Tienes {{collect($errors->all())->count()}} error
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
            <div class="col s12 m12 l12">
                <blockquote>
                    <ul class="collection">
                        <li class="collection-item">Debes tener en cuenta que el equipo sólo se registra una vez, en caso de que se desee hacer un mantemiento a un equipo previamente registrado tienes que editarlo.</li>
                </ul>
            </blockquote>
        </div>
    </div>
    <div class="row">
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txtlineatecnologica">Linea Tecnológica <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" >
	            <option value="">Seleccione Linea Tecnológica</option>
	            @forelse($lineastecnologicas as $id => $linea)
		            @if(isset($equipo->lineatecnologica_id))
		            	<option value="{{$id}}" {{ old('txtlineatecnologica', $equipo->lineatecnologica_id) == $id ? 'selected':'' }}>{{$linea}}</option>
		            @else
		            	<option value="{{$id}}" {{ old('txtlineatecnologica') == $id ? 'selected':'' }}>{{$linea}}</option>
		            @endif
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
	        @error('txtlineatecnologica')
            <label class="error" for="txtlineatecnologica" id="txtlineatecnologica-error">
                {{ $message }}
            </label>
            @enderror
		</div>
		 <div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtnombre" id="txtnombre" value="{{ isset($equipo) ? $equipo->nombreequipo: old('txtnombre')}}"/>
	      	<label class="active" for="txtnombre">Nombre de Equipo <span class="red-text">*</span></label>
	      	@error('txtnombre')
            <label class="error" for="txtnombre" id="txtnombre-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
	</div>
	<div class="row">
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtreferencia" id="txtreferencia" value="{{ isset($equipo) ? $equipo->referencia: old('txtreferencia')}}"/>
	      	<label class="active" for="txtreferencia">Referencia <span class="red-text">*</span></label>
	      	@error('txtreferencia')
            <label class="error" for="txtreferencia" id="txtreferencia-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtmarca" id="txtmarca" value="{{ isset($equipo) ? $equipo->marca: old('txtmarca')}}"/>
	      	<label class="active" for="txtmarca">Marca <span class="red-text">*</span></label>
	      	@error('txtmarca')
            <label class="error" for="txtmarca" id="txtmarca-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		 
	</div>
	<div class="row">
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtcostoadquisicion" id="txtcostoadquisicion" value="{{ isset($equipo) ? $equipo->costo_adquisicion: old('txtcostoadquisicion')}}"/>
	      	<label class="active" for="txtcostoadquisicion">Costo Adquisición con IVA<span class="red-text">*</span> </label>
	      	@error('txtcostoadquisicion')
            <label class="error" for="txtcostoadquisicion" id="txtcostoadquisicion-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		<div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtvida_util" id="txtvida_util" value="{{ isset($equipo) ? $equipo->vida_util: old('txtvida_util')}}"/>
	      	<label class="active" for="txtvida_util">Vida Util (años) <span class="red-text">*</span></label>
	      	@error('txtvida_util')
            <label class="error" for="txtvida_util" id="txtvida_util-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		 <div class="input-field col s12 m4 l4">
	      	<input type="text" name="txtaniocompra" id="txtaniocompra" value="{{ isset($equipo) ? $equipo->anio_compra:  old('txtaniocompra')}}"/>
	      	<label class="active" for="txtaniocompra">Año de compra <span class="red-text">*</span></label>
	      	@error('txtaniocompra')
            <label class="error" for="txtaniocompra" id="txtaniocompra-error">
                {{ $message }}
            </label>
            @enderror
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
</div>

  	