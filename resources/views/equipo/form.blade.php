<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
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
                        	Tienes {{collect($errors->all())}} errores
                        @else
                            Tienes {{collect($errors->all())->count()}} error
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

	@can('showInputsForAdmin', App\Models\Equipo::class)
		<div class="row">
			<div class="input-field col s12 m6 l6">
				<select style="width: 100%" class="js-states" id="txtnodo_id" name="txtnodo_id" onchange="consultarLineasNodo(this.value);">
				<option value="">Seleccione el nodo donde se registrará el equipo</option>
				@if (isset($equipo->nodo->id))
					@forelse ($nodos as $id => $nodo)
					<option value="{{$nodo->id}}" {{ $equipo->nodo_id == $nodo->id ? 'selected' : '' }}>{{$nodo->nodos}}</option>
					@empty
					<option value=""> No hay información disponible</option>
					@endforelse
				@else
					@forelse ($nodos as $id => $nodo)
					<option value="{{$nodo->id}}" {{ old('txtnodo_id') == $nodo->id ? 'selected':'' }}>{{$nodo->nodos}}</option>
					@empty
					<option value=""> No hay información disponible</option>
					@endforelse
				@endif
				</select>
				@error('txtnodo_id')
				<label class="error" for="txtnodo_id" id="txtnodo_id-error">
					{{ $message }}
				</label>
				@enderror
			</div>
			<div class="input-field col s12 m6 l6">
				<select style="width: 100%" class="js-states" id="txtlineatecnologica" name="txtlineatecnologica">
					<option value="">Seleccione la línea tecnológica donde se registrará el equipo</option>
					@if (isset($equipo->lineatecnologica->id))
					@forelse ($lineastecnologicas as $id => $linea)
						<option value="{{$linea->id}}" {{ $equipo->lineatecnologica_id == $linea->id ? 'selected':'' }}>{{$linea->nombre}}</option>
						@empty
						<option value=""> No hay información disponible</option>
						@endforelse
					@endif
				</select>
				@error('txtlineatecnologica')
				<label class="error" for="txtlineatecnologica" id="txtlineatecnologica-error">
					{{ $message }}
				</label>
				@enderror
			</div>
		</div>
	@elsecan('showInputsForDinamizador', App\Models\Equipo::class)
		<div class="row">
			<div class="input-field col s12 m12 l12">
				<label class="active" for="txtlineatecnologica">Linea Tecnológica <span class="red-text">*</span></label>
				<select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" >
					<option value="">Seleccione Linea Tecnológica</option>
					@forelse($lineastecnologicas as $id => $linea)
						@if(isset($equipo->lineatecnologica->id))
							<option value="{{$linea->id}}" {{ old('txtlineatecnologica', $equipo->lineatecnologica_id) == $linea->id ? 'selected':'' }}>{{$linea->nombre}}</option>
						@else
							<option value="{{$linea->id}}" {{ old('txtlineatecnologica') == $id ? 'selected':'' }}>{{$linea}}</option>
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
	@endcan
	<div class="row">
		<div class="input-field col s12 m12 l12">
			<input type="text" name="txtnombre" id="txtnombre" value="{{ isset($equipo) ? $equipo->nombre: old('txtnombre')}}"/>
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
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtvida_util" id="txtvida_util" value="{{ isset($equipo) ? $equipo->vida_util: old('txtvida_util')}}"/>
	      	<label class="active" for="txtvida_util">Vida Util (años) <span class="red-text">*</span></label>
	      	@error('txtvida_util')
            <label class="error" for="txtvida_util" id="txtvida_util-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
	    <div class="input-field col s12 m6 l6">
	      	<input type="text" name="txthorasuso" id="txthorasuso" value="{{ isset($equipo) ? $equipo->horas_uso_anio: old('txthorasuso')}}"/>
	      	<label class="active" for="txthorasuso">Promedio horas uso por Año <span class="red-text">*</span></label>
	      	@error('txthorasuso')
            <label class="error" for="txthorasuso" id="txthorasuso-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
	</div>
	<div class="row">
		<div class="input-field col s12 m6 l6">
		 	<select class="js-states browser-default select2"   tabindex="-1" style="width: 100%" id="txtaniocompra" name="txtaniocompra">
		 		<option>Seleccione el año de compra</option>
            	@for ($i=2010; $i <= $year; $i++)
				
              		@if(isset($equipo->anio_compra))
		            	<option value="{{$i}}" {{ old('txtaniocompra', $equipo->anio_compra) ==  $i  ? 'selected' : '' }}>{{$i}}</option>
		            @else
		            	<option value="{{$i}}" {{ $i  == old('txtaniocompra')  ? 'selected' :  ''}}>{{$i}}</option>
		            @endif
            	@endfor
          	</select>
	      	<label class="active"  for="txtaniocompra">Año de compra <span class="red-text">*</span></label>
	      	@error('txtaniocompra')
            <label class="error" for="txtaniocompra" id="txtaniocompra-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		<div class="input-field col s12 m6 l6">
	      	<input type="text" name="txtcostoadquisicion" id="txtcostoadquisicion" value="{{ isset($equipo) ? $equipo->costo_adquisicion: old('txtcostoadquisicion')}}"/>
	      	<label class="active" for="txtcostoadquisicion">Costo Adquisición con IVA<span class="red-text">*</span> </label>
	      	@error('txtcostoadquisicion')
            <label class="error" for="txtcostoadquisicion" id="txtcostoadquisicion-error">
                {{ $message }}
            </label>
            @enderror
	    </div>
		
		 
	</div>

	<div class="divider"></div>
	<div class="center">
	  	<button type="submit" class="waves-effect btn bg-secondary center-aling"><i class="material-icons right">send</i>{{isset($btnText) ? $btnText : 'error'}}</button>
	  	<a href="{{route('equipo.index')}}" class="waves-effect btn bg-danger center-aling"><i class="material-icons left">backspace</i>Cancelar</a>
	</div>
</div>

  	