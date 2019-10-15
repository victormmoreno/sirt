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
    
    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
    <div class="row">
		<div class="input-field col s12 m12 l12">
		    <label class="active" for="txtlineatecnologica">Linea Tecnológica <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" >
	            <option value="">Seleccione Linea Tecnológica</option>
	            @forelse($lineastecnologicas as $id => $linea)
		            @if(isset($material->lineatecnologica->id))
		            	<option value="{{$id}}" {{ old('txtlineatecnologica', $material->lineatecnologica->id) == $id ? 'selected':'' }}>{{$linea}}</option>
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
		
	</div>
	@endif

	<div class="row">
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txttipomaterial">Tipo Material <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txttipomaterial" id="txttipomaterial" >
	            <option value="">Seleccione Tipo Material</option>
	            @forelse($tiposmateriales as $id => $tipomaterial)
		            @if(isset($material->lineatecnologica->id))
		            	<option value="{{$id}}" {{ old('txttipomaterial', $material->lineatecnologica->id) == $id ? 'selected':'' }}>{{$tipomaterial}}</option>
		            @else
		            	<option value="{{$id}}" {{ old('txttipomaterial') == $id ? 'selected':'' }}>{{$tipomaterial}}</option>
		            @endif
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
	        @error('txttipomaterial')
            <label class="error" for="txttipomaterial" id="txttipomaterial-error">
                {{ $message }}
            </label>
            @enderror
		</div>
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txtcategoria">Categoria Material <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtcategoria" id="txtcategoria" >
	            <option value="">Seleccione Categoria Material</option>
	            @forelse($categoriasMateriales as $id => $categoriaMaterial)
		            @if(isset($material->lineatecnologica->id))
		            	<option value="{{$id}}" {{ old('txtcategoria', $material->lineatecnologica->id) == $id ? 'selected':'' }}>{{$categoriaMaterial}}</option>
		            @else
		            	<option value="{{$id}}" {{ old('txtcategoria') == $id ? 'selected':'' }}>{{$categoriaMaterial}}</option>
		            @endif
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
	        @error('txtcategoria')
            <label class="error" for="txtcategoria" id="txtcategoria-error">
                {{ $message }}
            </label>
            @enderror
		</div>		
	</div>
	<div class="row">
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txtpresentacion">Presentación <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtpresentacion" id="txtpresentacion" >
	            <option value="">Seleccione Presentación</option>
	            @forelse($presentaciones as $id => $presentacion)
		            @if(isset($material->lineatecnologica->id))
		            	<option value="{{$id}}" {{ old('txtpresentacion', $material->lineatecnologica->id) == $id ? 'selected':'' }}>{{$presentacion}}</option>
		            @else
		            	<option value="{{$id}}" {{ old('txtpresentacion') == $id ? 'selected':'' }}>{{$presentacion}}</option>
		            @endif
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
	        @error('txtpresentacion')
            <label class="error" for="txtpresentacion" id="txtpresentacion-error">
                {{ $message }}
            </label>
            @enderror
		</div>
		<div class="input-field col s12 m6 l6">
		    <label class="active" for="txtmedida">Medida <span class="red-text">*</span></label>
		    <select class="js-states browser-default select2Tags" tabindex="-1" style="width: 100%" name="txtmedida" id="txtmedida" >
	            <option value="">Seleccione Medida</option>
	            @forelse($medidas as $id => $medida)
		            @if(isset($material->lineatecnologica->id))
		            	<option value="{{$id}}" {{ old('txtmedida', $material->lineatecnologica->id) == $id ? 'selected':'' }}>{{$medida}}</option>
		            @else
		            	<option value="{{$id}}" {{ old('txtmedida') == $id ? 'selected':'' }}>{{$medida}}</option>
		            @endif
	            @empty
	             	<option value="">No hay información disponible</option>
	            @endforelse
	        </select>
	        @error('txtmedida')
            <label class="error" for="txtmedida" id="txtmedida-error">
                {{ $message }}
            </label>
            @enderror
		</div>
	</div>
	
	<div class="row">
		<div class="input-field col s12 m3 l2">
	      	<input type="text" name="txtcantidad" id="txtcantidad" value="{{ isset($material) ? $material->referencia: old('txtcantidad')}}"/>
	      	<label class="active" for="txtcantidad">Cantidad <span class="red-text">*</span></label>
	      	@error('txtcantidad')
            <label class="error" for="txtcantidad" id="txtcantidad-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
	    <div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtnombre" id="txtnombre" value="{{ isset($material) ? $material->nombre: old('txtnombre')}}"/>
	      	<label class="active" for="txtnombre">Nombre de Material <span class="red-text">*</span></label>
	      	@error('txtnombre')
            <label class="error" for="txtnombre" id="txtnombre-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		<div class="input-field col s12 m3 l4">
	      	<input type="text" name="txtvalorcompra" id="txtvalorcompra" value="{{ isset($material) ? $material->marca: old('txtvalorcompra')}}"/>
	      	<label class="active" for="txtvalorcompra">Valor total compra <span class="red-text">*</span></label>
	      	@error('txtvalorcompra')
            <label class="error" for="txtvalorcompra" id="txtvalorcompra-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		 
	</div>
	<div class="row">
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtmarca" id="txtmarca" value="{{ isset($material) ? $material->horas_uso_anio: old('txtmarca')}}"/>
	      	<label class="active" for="txtmarca">Marca <span class="red-text">*</span></label>
	      	@error('txtmarca')
            <label class="error" for="txtmarca" id="txtmarca-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtproveedor" id="txtproveedor" value="{{ isset($material) ? $material->vida_util: old('txtproveedor')}}"/>
	      	<label class="active" for="txtproveedor">Proveedor <span class="red-text">*</span></label>
	      	@error('txtproveedor')
            <label class="error" for="txtproveedor" id="txtproveedor-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
	</div>
	
	<div class="divider"></div>
	<center>
	  	<button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
	  	<a href="{{route('material.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
	</center>
</div>

  	