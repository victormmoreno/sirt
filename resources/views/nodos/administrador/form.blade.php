{!! csrf_field() !!}

<div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            details
        </i>

        <select class="" id="txtregional" name="txtregional" onchange="Regional.getCentrosFormacion()" style="width: 100%" tabindex="-1" >
            <option value="0">Seleccione regional </option>
            @foreach($regionales as $id => $nombre)
                @if(isset($nodo->centro->regional_id))
                <option value="{{$id}}" {{old('txtregional',$nodo->centro->regional_id) ==  $id ? 'selected':''}}>{{$nombre}}</option> 
                @else
                    <option value="{{$id}}" {{old('txtregional') == $id  ? 'selected':''}}> {{$nombre}}</option> 
                @endif
            @endforeach
        </select>
       <label for="txtregional" >Regional <span class="red-text">*</span></label>
        @error('txtregional')
            <label id="txtregional-error" class="error" for="txtregional">{{ $message }}</label>
        @enderror 
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            details
        </i>
        
       
        <select class="" id="txtcentro" name="txtcentro" style="width: 100%" tabindex="-1">
            <option value="">Seleccione Primero la regional</option> 
        </select>
        <label for="txtcentro">Centro de fomracion <span class="red-text">*</span></label>
        @error('txtcentro')
            <label id="txtcentro-error" class="error" for="txtcentro">{{ $message }}</label>
        @enderror 
    </div>   
    
</div>

<div class="row">
	<div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            account_circle
        </i>
        <input class="validate" id="txtnombre" name="txtnombre" type="text"  value="{{ isset($nodo->nombre) ? $nodo->nombre : old('txtnombre')}}">
        <label for="txtnombre">Nombre Nodo <span class="red-text">*</span></label>
        @error('txtnombre')
            <label id="txtnombre-error" class="error" for="txtnombre">{{ $message }}</label>
        @enderror
    </div>
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">
            account_circle
        </i>
        <input class="validate" id="txtdireccion" name="txtdireccion" type="text"  value="{{ isset($nodo->direccion) ? $nodo->direccion : old('txtdireccion')}}">
        <label for="txtdireccion">Dirección <span class="red-text">*</span></label>
        @error('txtdireccion')
            <label id="txtdireccion-error" class="error" for="txtdireccion">{{ $message }}</label>
        @enderror
    </div>
</div>

<div class="col s12 m6 l6 offset-l3 m3">
            <ul class="collection with-header">
                <li class="collection-header center">
                	<h5><b>Lineas</b></h5>
                	<p class="center">Seleccione lineas</p>
                     @error('txtlineas')
                        <span class="red-text text-darken-1">{{ $message }}</span>
                    @enderror
                </li>
              
                @forelse($lineas as $value)
                    <li class="collection-item">
                        <p class="p-v-xs">
                            @if(isset($nodo))
                            <input {{collect(old('txtlineas',$nodo->lineas->pluck('id')))->contains($value->id) ? 'checked' : ''  }}  type="checkbox" id="txtlineas-{{$value->nombre}}" name="txtlineas[]"  value="{{$value->id}}">
                            @else
                            <input {{collect(old('txtlineas'))->contains($value->id) ? 'checked' : ''  }}  type="checkbox" id="txtlineas-{{$value->nombre}}" name="txtlineas[]"  value="{{$value->id}}">
                            @endif
                            <label for="txtlineas-{{$value->nombre}}">{{$value->nombre}}</label>
                        </p>
                    </li>
                @empty
                <p>No hay Lineas</p>
                @endforelse
                @if(isset($lineas))
                        {{ $lineas->links() }}
                @endif
                
            </ul>
        </div>
<div class="divider mailbox-divider"></div>
<br>
<center>
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="waves-effect red lighten-2 btn center-aling" href="">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>