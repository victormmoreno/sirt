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
            <p class="center card-title cyan-text text-darken-4">
               <b> <i class="medium material-icons center">info_outline</i> Seleccione a que se le hará el uso de infraestructura</b> 
            </p>
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

@if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
<div class="divider">
</div>
<div class="row">
    {{-- <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Paso 2</b></span>
                    <p>
                        Si no se van a registrar horas de asesorias dejar el campo vacío
                    </p>
                </li>
                
            </ul>
        </blockquote>
    </div> --}}

    <div class="col s12 m12 l12">
        <fieldset>
            <legend>Paso 2</legend>
            <p class="center card-title cyan-text text-darken-4">
               <b> <i class="medium material-icons center">info_outline</i> Gestor A cargo</b> 
            </p>
            <div class="row">
                <div class="col s12 m8 l8 offset-l2 m2">
                    {{-- <center>
                        <p class="center-aling">
                            Detalle Uso de Equipos
                        </p>
                    </center> --}}
                    <table class="striped centered responsive-table" id="tbldetallegestores">
                        <thead>
                            <tr>
                                <th>
                                    Linea Tecnológica
                                </th>
                                <th>
                                   Gestor
                                </th>
                                <th>
                                    Asesoria Directa (Horas)
                                </th>
                                <th>
                                  Asesoria Indirecta (Horas)
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody id="detallesGestores">
                            @if(isset($usoinfraestructura->usoequipos))
                                @forelse ($usoinfraestructura->usoequipos as $key => $equipo)
                                        
                                        <tr id="filaGestor{{$equipo->id}}">
                                            <td>
                                                <input type="hidden" name="equipo[]" value="{{$equipo->id}}"/>{{$equipo->nombre}}
                                            </td>
                                            <td>
                                                <input type="hidden" name="tiempouso[]" value="{{$equipo->pivot->tiempo}}"/>
                                                {{$equipo->pivot->tiempo}}
                                            </td>
                                            <td>
                                                <a class="waves-effect red lighten-3 btn" onclick="eliminarEquipo({{$equipo->id}});">
                                                    <i class="material-icons">delete_sweep</i>
                                                </a>
                                            </td>
                                        </tr>
                                @empty
                                    <td>
                                        No se encontraron resultados
                                    </td>
                                    <td></td>
                                    <td></td>
                                @endforelse
                            @endif
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Seleccione primero el tipo de uso de infraestructura.</td>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="divider"></div>
            <p class="center card-title cyan-text text-darken-4">
               <b> <i class="medium material-icons center">info_outline</i> Gestores Asesores</b> 
            </p>
            <div class="row">
                <div class="input-field col s12 m4 l5">
                    <select class="js-states browser-default select2"  id="txtgestorasesor" name="txtgestorasesor" style="width: 100%" tabindex="-1">
                        <option value="">
                                Seleccione Gestor
                            </option>
                        @if(isset($usoinfraestructura->actividad->articulacion_proyecto->talentos))
                            
                            @foreach($usoinfraestructura->actividad->articulacion_proyecto->talentos as $talento)
                            <option value="{{$talento->id}}">
                                {{$talento->user->documento}} - {{$talento->user->nombres}} {{$talento->user->apellidos}}
                            </option>
                            @endforeach
                        @else
                           
                                @foreach($gestores as $gestor)
                                <option value="{{$gestor->id}}">
                                    {{$gestor->user->documento}} - {{$gestor->user->nombres}} {{$gestor->user->apellidos}} / {{$gestor->lineatecnologica->nombre}}
                                </option>
                                @endforeach
                        @endif
                        
                    </select>
                    <label class="active" for="txtgestorasesor">
                        Gestores
                    </label>
                </div>
                <div class="input-field col s12 m3 l3">
                    <i class="material-icons prefix">
                        book
                    </i>
                    @if(isset($usoinfraestructura->asesoria_directa))
                        <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="text"  value="{{ isset($usoinfraestructura->asesoria_directa) ? $usoinfraestructura->asesoria_directa :  old('txtasesoriadirecta')}}" />
                    @else
                         <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="text" value="0" />
                    @endif
                    <label class="active" for="txtasesoriadirecta">
                        Asesoria Directa (Horas)
                    </label>
                    <label class="error" for="txtasesoriadirecta" id="txtasesoriadirecta-error"></label>
                </div>
                <div class="input-field col s12 m3 l3">
                    <i class="material-icons prefix">
                        bookmark
                    </i>
                    @if(isset($usoinfraestructura->asesoria_indirecta))
                        <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="text" value="0" /> 
                    @else
                        <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="text"  value="0" />
                    @endif
                    <label class="active" for="txtasesoriaindirecta">
                        Asesoria Indirecta (Horas)
                    </label>
                    <label class="error" for="txtasesoriaindirecta" id="txtasesoriaindirecta-error"></label>
                </div>
                <div class="input-field col s2 m2 l1">
                   
                        
                    
                        <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped btnAgregarGestorAsesor" data-delay="50" data-position="button" data-tooltip="Agregar Gestor" onclick="addGestoresAUso()">
                            <i class="material-icons">
                                add
                            </i>
                        </a>
                    
                    
                </div>
                <div class="row">
                    <div class="col s12 m8 l8 offset-l2 m2">
                        
                        <table class="striped centered responsive-table" id="tbldetallegestorAsesor">
                            <thead>
                                <tr>
                                    
                                    <th>
                                       Gestor
                                    </th>
                                    <th>
                                        Asesoria Directa (Horas)
                                    </th>
                                    <th>
                                      Asesoria Indirecta (Horas)
                                    </th>
                                    <th>
                                        Eliminar
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="detallesGestoresAsesores">
                                @if(isset($usoinfraestructura->usoequipos))
                                    @forelse ($usoinfraestructura->usoequipos as $key => $equipo)
                                            
                                            <tr id="filaGestorAsesor{{$equipo->id}}">
                                                <td>
                                                    <input type="hidden" name="equipo[]" value="{{$equipo->id}}"/>{{$equipo->nombre}}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="tiempouso[]" value="{{$equipo->pivot->tiempo}}"/>
                                                    {{$equipo->pivot->tiempo}}
                                                </td>
                                                <td>
                                                    <a class="waves-effect red lighten-3 btn" onclick="eliminarEquipo({{$equipo->id}});">
                                                        <i class="material-icons">delete_sweep</i>
                                                    </a>
                                                </td>
                                            </tr>
                                    @empty
                                        <td>
                                            No se encontraron resultados
                                        </td>
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                    

            </div>
            <div class="row">
                
                {{-- <div class="input-field col s12 m4 l4">
                    <i class="material-icons prefix">
                        account_circle
                    </i>
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())

                        @if(isset($usoinfraestructura->actividad->gestor->user))
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="{{$usoinfraestructura->actividad->gestor->user->documento}} - {{$usoinfraestructura->actividad->gestor->user->nombres}} {{$usoinfraestructura->actividad->gestor->user->apellidos}}"/>
                        @else
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="Por favor seleccione un tipo de uso de infraestructura"/>
                        @endif
                    
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        @if(isset($usoinfraestructura->actividad->gestor->user))
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="{{$usoinfraestructura->actividad->gestor->user->documento}} - {{$usoinfraestructura->actividad->gestor->user->nombres}} {{$usoinfraestructura->actividad->gestor->user->apellidos}}"/>
                        @else
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="Por favor seleccione un tipo de uso de infraestructura"/>
                        @endif
                    @endif
                    <label class="active" for="txtgestor">
                        Gestor Asesor
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtgestor" id="txtgestor-error">
                    </label>
                  
                </div> --}}
                
                
            </div>
            <div class="divider"></div>
            <div class="row">
                <div class="input-field col s12 m12 l8 offset-l2">
                    <i class="material-icons prefix">
                        create
                    </i>
                    @if(isset($usoinfraestructura->descripcion))
                        <textarea class="materialize-textarea" id="txtdescripcion" length="2000" name="txtdescripcion">
                            {{$usoinfraestructura->descripcion}}
                        </textarea>
                    @else
                        <textarea class="materialize-textarea" id="txtdescripcion" length="2000" name="txtdescripcion">
                        </textarea>
                    @endif
                    <label for="txtdescripcion">
                        Descripción
                    </label>
                    <label class="error" for="txtdescripcion" id="txtdescripcion-error"></label>
                </div>
            </div>
        </fieldset>
    </div>
</div>
@endif

<div class="divider">
</div>

<div class="card-content">
    <span class="red-text text-darken-2">
        Para registrar el uso de un equipo o la asistencia de un talento dar click en el boton
        <a class="btn-floating waves-effect waves-light blue">
            <i class="material-icons">
                add
            </i>
        </a>
    </span>
    <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
        <li>
            <div class="collapsible-header active blue-grey lighten-1">
                <i class="material-icons">
                    domain
                </i>
                Seleccione detalle uso infraestructura
            </div>
            <p>
                <i class="material-icons left">
                    info_outline
                </i>
                Si no se van a registrar equipos y tiempo de uso, por favor no agregue al detalle de uso de infraestructura.
            </p>
            <div class="collapsible-body">
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col s10 m10 l11">
                            <select class="js-states browser-default select2" {{isset($usoinfraestructura->tipo_usoinfraestructura) && $usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt() ? 'disabled' : ''}}   id="txttalento" name="txttalento" style="width: 100%" tabindex="-1">

                                @if(isset($usoinfraestructura->actividad->articulacion_proyecto->talentos))
                                    <option value="">
                                        Seleccione Talento
                                    </option>
                                    @foreach($usoinfraestructura->actividad->articulacion_proyecto->talentos as $talento)
                                    <option value="{{$talento->id}}">
                                        {{$talento->user->documento}} - {{$talento->user->nombres}} {{$talento->user->apellidos}}
                                    </option>
                                    @endforeach
                                @else
                                    @if(isset($usoinfraestructura->tipo_usoinfraestructura) && $usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt())
                                        <option value="">
                                            No se encontraron resultados
                                        </option>
                                    @else
                                        <option value="">
                                            Seleccione primero el tipo de uso de infraestructura
                                        </option>
                                    @endif
                                    
                                @endif
                                
                            </select>
                            <label class="active" for="txttalento">
                                Talento
                            </label>
                        </div>
                        <div class="input-field col s2 m2 l1">
                            @if(isset($usoinfraestructura->tipo_usoinfraestructura) && $usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt())
                                <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped btnAgregarTalento" data-delay="50" data-position="button" data-tooltip="Agregar Talento" disabled>
                                    <i class="material-icons">
                                        add
                                    </i>
                                </a>
                            @else
                                <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped btnAgregarTalento" data-delay="50" data-position="button" data-tooltip="Agregar Talento" onclick="addTalentoAUso()">
                                    <i class="material-icons">
                                        add
                                    </i>
                                </a>
                            @endif
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="input-field col s12 m4 l4">
       
                            <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" onchange="usoInfraestructuraCreate.getEquipoPorLinea()">
                    <option value="">Seleccione Linea Tecnológica</option>
                    @forelse($lineastecnologicas as $id => $linea)
                        @if(isset($equipo->lineatecnologicanodo->lineatecnologica->id))
                            <option value="{{$id}}" {{ old('txtlineatecnologica', $equipo->lineatecnologicanodo->lineatecnologica->id) == $id ? 'selected':'' }}>{{$linea}}</option>
                        @else
                            <option value="{{$id}}" {{ old('txtlineatecnologica') == $id ? 'selected':'' }}>{{$linea}}</option>
                        @endif
                    @empty
                        <option value="">No hay información disponible</option>
                    @endforelse
                </select>
                            <label class="active" for="txtlineatecnologica">
                                Linea Tecnológica
                            </label>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <!-- <i class="material-icons prefix">local_drink</i> -->
                            <select class="js-states browser-default select2" id="txtequipo" name="txtequipo" style="width: 100%" tabindex="-1">
                                @if(isset($usoinfraestructura->actividad->gestor->lineatecnologica->lineastecnologicasnodos))
                                    <option value="">
                                        Seleccione el equipo
                                    </option>
                                    @foreach($usoinfraestructura->actividad->gestor->lineatecnologica->lineastecnologicasnodos as $equipos)
                                        @foreach($equipos->equipos as $equipo)
                                        <option value="{{$equipo->id}}">
                                            {{$equipo->nombre}}
                                        </option>
                                        @endforeach
                                    @endforeach
                                @else
                                    <option value="">
                                        Seleccione primero el tipo de uso de infraestructura
                                    </option>
                                @endif
                            </select>
                            <label class="active" for="txtequipo">
                                Equipo
                            </label>
                        </div>
                        <div class="input-field col s12 m2 l3">
                            <i class="material-icons prefix">
                                av_timer
                            </i>
                            <input class="validate" id="txttiempouso" name="txttiempouso" type="number">
                                <label for="txttiempouso">
                                    Tiempo Uso (Horas)
                                </label>
                            </input>
                        </div>
                        <div class="col s2 m2 l1">
                            <a class="btn-floating btn-large waves-effect waves-light blue lighten-1 tooltipped btnAgregartimelaboratorio" data-delay="50" data-position="button" data-tooltip="Agregar Uso"  onclick="agregarEquipoAusoInfraestructura()">
                                <i class="material-icons">
                                    add
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <div class="card ">
                                <center>
                                    <p class="center-aling">
                                        Detalle Talentos
                                    </p>
                                </center>
                               
                                <table class="striped centered responsive-table" id="tbldetallelineas">
                                    <thead>
                                        <tr>
                                            <th>
                                                Talentos
                                            </th>
                                            <th>
                                                Eliminar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="detalleTalento">
                                        @if(isset($usoinfraestructura->usotalentos))
                                            @forelse ($usoinfraestructura->usotalentos as $key => $talento)
                                                    
                                                    <tr id="filaTalento{{$talento->id}}">
                                                        <td>
                                                            <input type="hidden" name="talento[]" value="{{$talento->id}}"/>
                                                            {{$talento->user->documento}} - {{$talento->user->nombres}} {{$talento->user->nombres}}
                                                        </td>
                                                        <td>
                                                            <a class="waves-effect red lighten-3 btn" onclick="eliminarTalento({{$talento->id}});">
                                                                <i class="material-icons">delete_sweep</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            @empty
                                                <tr>
                                                    <td>
                                                        No se encontraron resultados
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <div class="card ">
                                <center>
                                    <p class="center-aling">
                                        Detalle Uso de Equipos
                                    </p>
                                </center>
                                <table class="striped centered responsive-table" id="tbldetallelineas">
                                    <thead>
                                        <tr>
                                            <th>
                                                Equipo
                                            </th>
                                            <th>
                                                Tiempo Uso
                                            </th>
                                            <th>
                                                Eliminar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="detallesUsoInfraestructura">
                                        @if(isset($usoinfraestructura->usoequipos))
                                            @forelse ($usoinfraestructura->usoequipos as $key => $equipo)
                                                    
                                                    <tr id="filaEquipo{{$equipo->id}}">
                                                        <td>
                                                            <input type="hidden" name="equipo[]" value="{{$equipo->id}}"/>{{$equipo->nombre}}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="tiempouso[]" value="{{$equipo->pivot->tiempo}}"/>
                                                            {{$equipo->pivot->tiempo}}
                                                        </td>
                                                        <td>
                                                            <a class="waves-effect red lighten-3 btn" onclick="eliminarEquipo({{$equipo->id}});">
                                                                <i class="material-icons">delete_sweep</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            @empty
                                                <td>
                                                    No se encontraron resultados
                                                </td>
                                                <td></td>
                                                <td></td>
                                            @endforelse
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
<center>
   
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>{{isset($btnText) ? $btnText : 'Guardar'}}</button> 
    <a class="btn waves-effect red lighten-2 center-aling" href="{{route('usoinfraestructura.index')}}">
        <i class="material-icons right">
            backspace
        </i>
        Cancelar
    </a>
</center>