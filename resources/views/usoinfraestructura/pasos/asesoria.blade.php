<div class="divider">
</div>
<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Paso 2</b></span>
                    <p>
                        señor(a) ususario, por favor ingrese las horas de asesoria.
                    </p>
                </li>
                <li class="collection-item">
                    <span class="title"><b>Paso 2</b></span>
                    <p>
                        señor(a) ususario, si la asesoria fue acompañada por otro gestor agregue a este en la sección de gestores Asesores, pulsando el boton agregar gestor.
                    </p>
                </li>
                
            </ul>
        </blockquote>
    </div>

    <div class="col s12 m9 l9">
        <fieldset>
            <legend>Paso 2</legend>
            <p class="center card-title orange-text text-darken-3">
               <b> Asesorias</b> 
            </p>
            <div class="divider"></div>
            <div class="row">
                <div class="col s12 m8 l8 offset-l2 m2">
                    
                        <h5 class="center-align">
                            <mark>Gestor A Cargo</mark>
                        </h5>
                
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
                            @if(isset($usoinfraestructura->usogestores))
                                @forelse ($usoinfraestructura->usogestores as $key => $gestor)

                                        <tr id="filaGestor{{$gestor->id}}">
                                            @if($gestor->id == auth()->user()->gestor->id)
                                            
                                                <td>{{$gestor->lineatecnologica->abreviatura}} -  {{$gestor->lineatecnologica->nombre}}</td>
                                                <td>
                                                    <input type="hidden" name="gestor[]" value="{{$gestor->id}}"/>{{$gestor->user->documento}} - {{$gestor->user->nombres}} {{$gestor->user->apellidos}} - Gestor a cargo  
                                                </td>
                                                <td><input type="number" name="asesoriadirecta[]" value="{{$gestor->pivot->asesoria_directa}}"></td>
                                                <td><input type="number" name="asesoriaindirecta[]" value="{{$gestor->pivot->asesoria_indirecta}}"></td>
                                            @endif
                    
                                        </tr>

                                @empty
                                    <td>
                                        No se encontraron resultados
                                    </td>
                                    <td></td>
                                    <td></td>
                                @endforelse
                            @else
                               <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Seleccione primero el tipo de uso de infraestructura.</td>
                                    <td></td>
                                </tr> 
                            @endif
                            
                            
                        </tbody>
                        <tfoot>
                            <td></td>
                            <td></td>
                            <td colspan="2"><small class="center-align red-text text-ligth-3">solo se permite ingresar hasta 99 horas</small></td>
                        </tfoot>
                    </table>
                </div>
                
            </div>
            <div class="divider"></div>
            <h5 class="center-align">
                <mark>Gestores Asesores</mark>
            </h5>
            <div class="row">
                <div class="input-field col s12 m4 l5">
                    <select class="js-states browser-default select2"  id="txtgestorasesor" name="txtgestorasesor" style="width: 100%" tabindex="-1" {{isset($usoinfraestructura->usogestores) ? '' : 'disabled'}} >
                        <option value="">
                                Seleccione Gestor
                            </option>
                        @if(isset($usoinfraestructura->usogestores))
                            
                            @foreach($gestores as $gestor)
                                <option value="{{$gestor->id}}">
                                    {{$gestor->user->documento}} - {{$gestor->user->nombres}} {{$gestor->user->apellidos}} / {{$gestor->lineatecnologica->nombre}}
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
                <div class="input-field col s12 m2 l2">
                    
                    @if(isset($usoinfraestructura->asesoria_directa))
                        <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="text"  value="1" />
                    @else
                         <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="text" value="1" readonly />
                    @endif
                    <label class="active" for="txtasesoriadirecta">
                        Asesoria Directa (Horas)
                    </label>
                    <label class="error" for="txtasesoriadirecta" id="txtasesoriadirecta-error"></label>
                    <small class="center-align red-text text-ligth-3">solo se permite ingresar hasta 99 horas</small>
                </div>
                <div class="input-field col s12 m2 l2">
                    
                    @if(isset($usoinfraestructura->asesoria_indirecta))
                        <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="text" value="1"  /> 
                    @else
                        <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="text"  value="1" readonly />
                    @endif
                    <label class="active" for="txtasesoriaindirecta">
                        Asesoria Indirecta (Horas)
                    </label>
                    <label class="error" for="txtasesoriaindirecta" id="txtasesoriaindirecta-error"></label>
                    <small class="center-align red-text text-ligth-3">solo se permite ingresar hasta 99 horas</small>
                </div>
                <div class="input-field col s2 m3 l3">
                    <a class="waves-effect waves-light btn blue m-b-xs btnAgregarGestorAsesor"  onclick="addGestoresAUso()">
                        Agregar gestor 
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
                                    @forelse ($usoinfraestructura->usogestores as $key => $gestor)
                                            
                                            <tr id="filaGestorAsesor{{$gestor->id}}">
                                                @if($gestor->id != auth()->user()->gestor->id)
                                                <td>
                                                    <input type="hidden" name="gestor[]" value="{{$gestor->id}}"/>{{$gestor->user->documento}} - {{$gestor->user->nombres}} {{$gestor->user->apellidos}} / {{$gestor->lineatecnologica->nombre}}
                                                </td>
                                                <td><input type="number" name="asesoriadirecta[]" value="{{$gestor->pivot->asesoria_directa}}"></td>
                                                <td><input type="number" name="asesoriaindirecta[]" value="{{$gestor->pivot->asesoria_indirecta}}"></td>
                                                <td>
                                                    <a class="waves-effect red lighten-3 btn" onclick="eliminarGestorAsesor({{$gestor->id}});">
                                                        <i class="material-icons">delete_sweep</i>
                                                    </a>
                                                </td>
                                                @endif
                                            </tr>
                                    @empty
                                        <td>
                                            No se encontraron resultados
                                        </td>
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                @else
                                    <td></td>
                                    <td>
                                        No se encontraron resultados
                                    </td>
                                    <td></td>
                                    <td></td>
                                @endif
                                
                            </tbody>
                        </table>
                    </div>
                    
                </div>

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