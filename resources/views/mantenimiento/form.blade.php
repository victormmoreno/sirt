    {!! csrf_field() !!}
    @can('showInputAdmin', App\Models\EquipoMantenimiento::class)
        <div class="row">
			<div class="input-field col s12 m12 l12">
				<select style="width: 100%" class="js-states" id="txtnodo_id" name="txtnodo_id" onchange="consultarLineasNodo(this.value);">
				<option value="">Seleccione el nodo donde se registrará el equipo</option>
				@if (isset($mantenimiento->equipo->nodo->id))
					@forelse ($nodos as $id => $nodo)
					<option value="{{$nodo->id}}" {{ $mantenimiento->equipo->nodo_id == $nodo->id ? 'selected' : '' }}>{{$nodo->nodos}}</option>
					@empty
					<option value=""> No hay información disponible</option>
					@endforelse
				@else
					@forelse ($nodos as $id => $nodo)
					<option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
					@empty
					<option value=""> No hay información disponible</option>
					@endforelse
				@endif
				</select>
				<label class="error" for="txtnodo_id" id="txtnodo_id-error">
			</div>
        </div>
    @endcan
    <div class="row">
        <div class="input-field col s12 m6 l6">
            <label class="active" for="txtlineatecnologica">Linea Tecnológica <span class="red-text">*</span></label>
            <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" onchange="mantenimiento.getEquipoPorLinea()">
                <option value="">Seleccione Linea Tecnológica</option>
                @forelse($lineastecnologicas as $id => $linea)
                    @if(isset($mantenimiento->equipo->lineatecnologica->id))
                        <option value="{{$linea->id}}" {{ $mantenimiento->equipo->lineatecnologica->id == $linea->id ? 'selected':'' }}>{{$linea->nombre}}</option>
                    @else
                        <option value="{{$linea->id}}">{{$linea->nombre}}</option>
                    @endif
                @empty
                    <option value="">No hay información disponible</option>
                @endforelse
            </select>
            <label class="error" for="txtlineatecnologica" id="txtlineatecnologica-error">
        </div>
         <div class="input-field col s12 m6 l6">
            <select class="js-states browser-default select2 " id="txtequipo" name="txtequipo" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Primero la Linea Tecnológica</option>
                    </select>
            <label class="active" for="txtequipo">Equipo <span class="red-text">*</span></label>
            <label class="error" for="txtequipo" id="txtequipo-error">
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 l6">
            <select class="js-states browser-default select2"   tabindex="-1" style="width: 100%" id="txtanio" name="txtanio">
                <option>Seleccione el año de mantenimiento</option>
                @for ($i=2016; $i <= $year; $i++)
                    
                    @if(isset($mantenimiento->ultimo_anio_mantenimiento))
                        
                        <option value="{{$i}}" {{ $mantenimiento->ultimo_anio_mantenimiento ==  $i  ? 'selected' : '' }}>{{$i}}</option>
                    @else
                        <option value="{{$i}}">{{$i}}</option>
                    @endif
                @endfor
            </select>
            <label class="active" for="txtanio">Año Mantenimiento <span class="red-text">*</span></label>
            <label class="error" for="txtanio" id="txtanio-error">
        </div>
        <div class="input-field col s12 m6 l6">
            <input type="text" name="txtvalor" id="txtvalor" value="{{ isset($mantenimiento) ? $mantenimiento->valor_mantenimiento : '' }}"/>
            <label class="active" for="txtvalor">Valor Mantenimiento <span class="red-text">*</span></label>
            <label class="error" for="txtvalor" id="txtvalor-error">
        </div>
    </div>
    <div class="divider"></div>
<center>
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Guardar' ? 'done' : 'done_all' : '' }}</i>
        {{isset($btnText) ? $btnText : 'error'}}
    </button>
    <a href="{{route('mantenimiento.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
</center>