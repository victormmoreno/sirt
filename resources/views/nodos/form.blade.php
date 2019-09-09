<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Nodo</b></span>
                    <p>señor(a) ususario, por favor ingrese la información que se solcita en formulario.</p>
                </li>
                <li class="collection-item">
                    <span class="title"><b>Nodo</b></span>
                    <p>Por favor sólo ingrese el nombre del nodo. Ejemplo (Medellin)</p>
                </li>
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m9 l9">
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
        <br>

            {!! csrf_field() !!}
        
            <div class="row">
                <div class="input-field col s12 m6 l6">

                    <i class="material-icons prefix">
                        details
                    </i>
                    {{-- {{var_dump()}} --}}
                    @if(isset($entidad->ciudad->departamento->id))
                    <select class="" id="txtdepartamento" name="txtdepartamento" onchange="DepartamentsEdit.getCiudad()" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione departamento</option>
                        @foreach($departamentos as $id =>$nombre)
                            @if(isset($entidad->ciudad->departamento->id))
                                <option value="{{$id}}" {{old('txtdepartamento',$entidad->ciudad->departamento->id) ==  $id ? 'selected':''}}>{{$nombre}}</option> 
                            @else
                                <option value="{{$id}}" {{old('txtdepartamento') == $id  ? 'selected':''}}>{{$nombre}}</option> 
                            @endif
                        @endforeach
                    </select>
                    @else
                    <select class="" id="txtdepartamento" name="txtdepartamento" onchange="DepartamentsCreate.getCiudad()" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione departamento</option>
                        @foreach($departamentos as $id => $nombre)
                            @if(isset($entidad->ciudad->departamento->id))
                                <option value="{{$id}}" {{old('txtdepartamento',$entidad->ciudad->departamento->id) ==  $id ? 'selected':''}}>{{$nombre}}</option> 
                            @else
                                <option value="{{$id}}" {{old('txtdepartamento') == $id  ? 'selected':''}}>{{$nombre}}</option> 
                            @endif
                        @endforeach
                    </select>
                    @endif
                    <label for="txtdepartamento">Departamento de Ubicación <span class="red-text">*</span></label>
                    @error('txtdepartamento')
                        <label id="txtdepartamento-error" class="error" for="txtdepartamento">{{ $message }}</label>
                    @enderror 
                </div>
             
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        details
                    </i>
                    @if(isset($entidad->ciudad->id))
                    <select class="" id="txtciudad" name="txtciudad" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Primero el Departamento</option>
                        
                    </select>
                    @else
                    <select class="" id="txtciudad" name="txtciudad" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Primero el Departamento</option> 
                    </select>
                    @endif
                    
                    <label for="txtciudad">Ciudad de Ubicación <span class="red-text">*</span></label>
                    @error('txtciudad')
                        <label id="txtciudad-error" class="error" for="txtciudad">{{ $message }}</label>
                    @enderror 
                </div>
            </div>


            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        details
                    </i>

                    <select class="" id="txtregional" name="txtregional" onchange="Regional.getCentrosFormacion()" style="width: 100%" tabindex="-1" >
                        <option value="">Seleccione regional </option>
                        @foreach($regionales as $id => $nombre)
                            @if(isset($entidad->nodo->centro->regional->id))
                            <option value="{{$id}}" {{old('txtregional',$entidad->nodo->centro->regional->id) ==  $id ? 'selected':''}}>{{$nombre}}</option> 
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
                        domain
                    </i>
                   
                    <input class="validate" id="txtnombre" name="txtnombre" type="text" placeholder="Digite el nombre del nodo" value="{{ isset($entidad->nombre) ? $entidad->nombre : old('txtnombre')}}">
                    <label for="txtnombre">Tecnoparque Nodo <span class="red-text">*</span></label>
                    <span class="helper-text" data-error="wrong" data-success="right">Por favor solo ingrese el nombre del nodo. Ejemplo (Medellin)</span>
                    @error('txtnombre')
                        <label id="txtnombre-error" class="error" for="txtnombre">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        room
                    </i>
                    <input class="validate" id="txtdireccion" name="txtdireccion" type="text"  value="{{ isset($entidad->nodo->direccion) ? $entidad->nodo->direccion : old('txtdireccion')}}">
                    <label for="txtdireccion">Dirección <span class="red-text">*</span></label>
                    @error('txtdireccion')
                        <label id="txtdireccion-error" class="error" for="txtdireccion">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="row">
                
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        email
                    </i>
                    <input class="validate" id="txtemail_entidad" name="txtemail_entidad" type="text"  value="{{ isset($entidad->email_entidad) ? $entidad->email_entidad : old('txtemail_entidad')}}">
                    <label for="txtemail_entidad">Correo Electrónico <span class="red-text">*</span></label>
                    @error('txtemail_entidad')
                        <label id="txtemail_entidad-error" class="error" for="txtemail_entidad">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        phone
                    </i>
                    <input class="validate" id="txttelefono" name="txttelefono" type="text"  value="{{ isset($entidad->nodo->telefono) ? $entidad->nodo->telefono : old('txttelefono')}}">
                    <label for="txttelefono">Teléfono fijo <span class="red-text">*</span></label>
                    @error('txttelefono')
                        <label id="txttelefono-error" class="error" for="txttelefono">{{ $message }}</label>
                    @enderror
                </div>
            </div>


            
    </div>
</div>
<div class="divider mailbox-divider"></div>
<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Lineas</b></span>
                    <p>señor(a) ususario, por favor seleccione al menos una linea tecnológica.</p>
                </li>
                
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m9 l9">
        <div class="row">
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
                                @if(isset($entidad->nodo->lineas))
                                <input {{collect(old('txtlineas',$entidad->nodo->lineas->pluck('id')))->contains($value->id) ? 'checked' : ''  }}  type="checkbox" id="txtlineas-{{$value->nombre}}" name="txtlineas[]"  value="{{$value->id}}">
                                @else
                                <input {{collect(old('txtlineas'))->contains($value->id) ? 'checked' : ''  }}  type="checkbox" id="txtlineas-{{$value->nombre}}" name="txtlineas[]"  value="{{$value->id}}">
                                @endif
                                <label for="txtlineas-{{$value->nombre}}">{{$value->nombre}}</label>
                            </p>
                        </li>
                    @empty
                    <p>No hay Lineas</p>
                    @endforelse                    
                </ul>
                 @if(isset($lineas))
                    <div class="center">
                        {{ $lineas->links() }}
                    </div>
                @endif      
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
        </div>
    </div>
</div>







