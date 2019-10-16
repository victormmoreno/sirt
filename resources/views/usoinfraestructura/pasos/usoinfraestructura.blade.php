<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Uso de Infraestructura</b></span>
                    <p>señor(a) ususario, por favor ingrese la información que se solcita en formulario.</p>
                </li>
                <li class="collection-item">
                    <span class="title"><b>Paso 1</b></span>
                    <p>Por favor seleccione el tipo de uso de infraestructura (Proyectos - Articulaciones - EDT)</p>
                </li>
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m9 l9">

        <fieldset>
            <legend>Paso 1</legend>
            {!! csrf_field() !!}
            <p class="center card-title orange-text text-darken-3">
               <b> Uso de Infraestructura</b> 
            </p>
            <div class="divider"></div>
            <h5 class="center-align">
            <mark><i class="material-icons">info_outline</i> Seleccione a que se le hará el uso de infraestructura</mark>
        </h5>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <p class="center p-v-xs">
                        @if(isset($usoinfraestructura->tipo_usoinfraestructura))
                            <input class="with-gap" id="IsProyecto" name="txttipousoinfraestructura" type="radio" {{$usoinfraestructura->tipo_usoinfraestructura == App\Models\UsoInfraestructura::IsProyecto() ? 'checked' : old('txttipousoinfraestructura')}}  value="0"/>
                            <label for="IsProyecto">
                                Proyectos
                            </label>
                            <input class="with-gap" id="IsArticulacion" name="txttipousoinfraestructura" type="radio" {{$usoinfraestructura->tipo_usoinfraestructura == App\Models\UsoInfraestructura::IsArticulacion() ? 'checked' : old('txttipousoinfraestructura')}} value="1"/>
                            <label for="IsArticulacion">
                                Articulaciones
                            </label>
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                                <input class="with-gap" id="IsEdt" name="txttipousoinfraestructura" type="radio" {{$usoinfraestructura->tipo_usoinfraestructura == App\Models\UsoInfraestructura::IsEdt() ? 'checked' : old('txttipousoinfraestructura')}} value="2"/>
                                <label for="IsEdt">
                                    EDT
                                </label>
                            @endif
                        @else
                            <input class="with-gap" id="IsProyecto" name="txttipousoinfraestructura" type="radio" value="0"/>
                            <label for="IsProyecto">
                                Proyectos
                            </label>
                            <input class="with-gap" id="IsArticulacion" name="txttipousoinfraestructura" type="radio" value="1"/>
                            <label for="IsArticulacion">
                                Articulaciones
                            </label>
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                                <input class="with-gap" id="IsEdt" name="txttipousoinfraestructura" type="radio" value="2"/>
                                <label for="IsEdt">
                                    EDT
                                </label>
                            @endif
                        @endif
                    </p>
                    <center>
                        <small class="center-align error red-text" id="txttipousoinfraestructura-error">
                        </small>
                    </center>
                </div>
            </div>
            <div class="row">
                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        date_range
                    </i>
                    @if(isset($usoinfraestructura->fecha))
                        <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$usoinfraestructura->fecha->format('Y-m-d')}}"/>
                    @else
                        <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$date}}"/>
                    @endif
                    <label for="txtfecha">
                        fecha
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtfecha" id="txtfecha-error"></label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        vertical_split
                    </i>
                    
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        @if(isset($usoinfraestructura->actividad->gestor->lineatecnologica))
                            <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$usoinfraestructura->actividad->gestor->lineatecnologica->nombre}}"/>
                        @else
                            <input id="txtlinea" name="txtlinea" readonly="" type="text" value="Por favor seleccione un tipo de uso de infraestructura"/>
                        @endif
                   
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        @if(isset($usoinfraestructura->actividad->gestor->lineatecnologica))
                            <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$usoinfraestructura->actividad->gestor->lineatecnologica->nombre}}"/>
                        @else
                            <input id="txtlinea" name="txtlinea" readonly="" type="text" value="Por favor seleccione un tipo de uso de infraestructura"/>
                        @endif
                    @endif
                    <label class="active" for="txtlinea">
                        Linea Tecnológica 
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtlinea" id="txtlinea-error">
                    </label>
                </div>
                @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">
                            date_range
                        </i>
                        @if(isset($usoinfraestructura->fecha))
                            <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$usoinfraestructura->fecha->format('Y-m-d')}}"/>
                        @else
                            <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$date}}"/>
                        @endif
                        <label for="txtfecha">
                            fecha
                            <span class="red-text">
                                *
                            </span>
                        </label>
                        <label class="error" for="txtfecha" id="txtfecha-error"></label>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">
                            vertical_split
                        </i>
                        
                        
                            @if(isset($usoinfraestructura->actividad->gestor->lineatecnologica))
                                <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$usoinfraestructura->actividad->gestor->lineatecnologica->nombre}}"/>
                            @else
                                <input id="txtlinea" name="txtlinea" readonly="" type="text" value="Por favor seleccione un tipo de uso de infraestructura"/>
                            @endif
                        
                        <label class="active" for="txtlinea">
                            Linea Tecnológica 
                            <span class="red-text">
                                *
                            </span>
                        </label>
                        <label class="error" for="txtlinea" id="txtlinea-error">
                        </label>
                    </div>
                    <div class="input-field col s12 m4 l4">
                    <i class="material-icons prefix">
                        account_circle
                    </i>
                    
                        @if(isset($usoinfraestructura->actividad->gestor->user))
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="{{$usoinfraestructura->actividad->gestor->user->documento}} - {{$usoinfraestructura->actividad->gestor->user->nombres}} {{$usoinfraestructura->actividad->gestor->user->apellidos}}"/>
                        @else
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="Por favor seleccione un tipo de uso de infraestructura"/>
                        @endif
                    
                    <label class="active" for="txtgestor">
                        Gestor a cargo
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtgestor" id="txtgestor-error">
                    </label>
                  
                </div>
                @endif
                
        </div>
        
      
            <div class="row divActividad">
                 <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">
                        library_books
                    </i>
                    @if(isset($usoinfraestructura->actividad->nombre))
                        <input id="txtactividad" name="txtactividad"  type="text" value="{{ isset($usoinfraestructura->actividad->codigo_actividad) ? $usoinfraestructura->actividad->codigo_actividad :  old('txtactividad')}} - {{ isset($usoinfraestructura->actividad->nombre) ? $usoinfraestructura->actividad->nombre : old('txtactividad')}}" readonly />
                        <label for="txtactividad">
                            @if($usoinfraestructura->tipo_usoinfraestructura == App\Models\UsoInfraestructura::IsProyecto())
                                Proyecto
                            @elseif($usoinfraestructura->tipo_usoinfraestructura == App\Models\UsoInfraestructura::IsArticulacion())
                                Articulación
                            @elseif($usoinfraestructura->tipo_usoinfraestructura == App\Models\UsoInfraestructura::IsEdt())
                                Edt
                            @else
                                seleccione un tipo de uso de infraestructura
                            @endif
                            <span class="red-text">
                                *
                            </span>
                        </label>
                    @else
                        <input id="txtactividad" name="txtactividad"  type="text" readonly />
                        <label for="txtactividad">
                                seleccione un tipo de uso de infraestructura
                            <span class="red-text">
                                *
                            </span>
                        </label>
                    @endif
                    
                    <label class="error" for="txtactividad" id="txtactividad-error"></label>
                </div>
            </div>
       
        </fieldset>
    </div>
</div>