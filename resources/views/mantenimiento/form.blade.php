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
        <div class="input-field col s12 m6 l6">
            <label class="active" for="txtlineatecnologica">Linea Tecnológica <span class="red-text">*</span></label>
            @if(isset($mantenimiento->equipo->lineatecnologica->id))
                <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" onchange="mantenimientoEdit.getEquipoPorLinea()">
            @else
                <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" onchange="mantenimientoCreate.getEquipoPorLinea()">
            @endif
            
                <option value="">Seleccione Linea Tecnológica</option>
                @forelse($lineastecnologicas as $id => $linea)
                    @if(isset($mantenimiento->equipo->lineatecnologica->id))
                        <option value="{{$id}}" {{ old('txtlineatecnologica', $mantenimiento->equipo->lineatecnologica->id) == $id ? 'selected':'' }}>{{$linea}}</option>
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
            <select class="js-states browser-default select2 " id="txtequipo" name="txtequipo" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Primero la Linea Tecnológica</option>
                    </select>
            <label class="active" for="txtequipo">Equipo <span class="red-text">*</span></label>
            @error('txtequipo')
            <label class="error" for="txtequipo" id="txtequipo-error">
                {{ $message }}
            </label>
            @enderror
        </div>
    </div>
    
    <div class="row">
        
        <div class="input-field col s12 m6 l6">
            
            <input class="validate" id="txtvidautil" name="txtvidautil" type="text"  value="{{ isset($mantenimiento->vida_util_mantenimiento) ? $mantenimiento->vida_util_mantenimiento : old('txtvidautil')}}">
            <label for="txtvidautil">Vida uitl del mantenimiento (Años) <span class="red-text">*</span></label>
            @error('txtvidautil')
                <label id="txtvidautil-error" class="error" for="txtvidautil">{{ $message }}</label>
            @enderror
        </div>
        <div class="input-field col s12 m6 l6">
            
            <input class="validate" id="txthorasuso" name="txthorasuso" type="text"  value="{{ isset($mantenimiento->horas_uso_anio) ? $mantenimiento->horas_uso_anio : old('txthorasuso')}}">
            <label for="txthorasuso">Horas de uso al año <span class="red-text">*</span></label>
            @error('txthorasuso')
                <label id="txthorasuso-error" class="error" for="txthorasuso">{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m6 l6">
            <select class="js-states browser-default select2"   tabindex="-1" style="width: 100%" id="txtanio" name="txtanio">
                <option>Seleccione el año de mantenimiento</option>
                @for ($i=2016; $i <= $year; $i++)
                    
                    @if(isset($mantenimiento->ultimo_anio_mantenimiento))
                        
                        <option value="{{$i}}" {{ old('txtanio', $mantenimiento->ultimo_anio_mantenimiento) ==  $i  ? 'selected' : '' }}>{{$i}}</option>
                    @else
                        <option value="{{$i}}" {{ $i  == old('txtanio')  ? 'selected' : ''}}>{{$i}}</option>
                    @endif
                @endfor
            </select>
            <label class="active" for="txtanio">Año Mantenimiento <span class="red-text">*</span></label>
            @error('txtanio')
            <label class="error" for="txtanio" id="txtanio-error">
                {{ $message }}
            </label>
            @enderror
        </div>
        <div class="input-field col s12 m6 l6">
            <input type="text" name="txtvalor" id="txtvalor" value="{{ isset($mantenimiento) ? $mantenimiento->valor_mantenimiento: old('txtvalor')}}"/>
            <label class="active" for="txtvalor">Valor Mantenimiento <span class="red-text">*</span></label>
            @error('txtvalor')
            <label class="error" for="txtvalor" id="txtvalor-error">
                {{ $message }}
            </label>
            @enderror
        </div>
         
    </div>
    <div class="divider"></div>
    <center>
        <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>{{isset($btnText) ? $btnText : 'error'}}</button>
        <a href="{{route('mantenimiento.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
    </center>
</div> 