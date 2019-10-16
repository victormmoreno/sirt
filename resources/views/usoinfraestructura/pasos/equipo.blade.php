<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Paso 4</b></span>
                    <p>
                        señor(a) ususario, por favor ingrese las horas de asesoria.
                    </p>
                </li>
                <li class="collection-item">
                    <span class="title"><b>Paso 4</b></span>
                    <p>
                        señor(a) ususario, si la asesoria fue acompañada por otro gestor ingrese este en la sección de gestores Asesores.
                    </p>
                </li>
                
            </ul>
        </blockquote>
    </div>

    <div class="col s12 m9 l9">
        <fieldset>
            <legend>Paso 4</legend>
            <p class="center card-title orange-text text-darken-3">
               <b> Equipos</b> 
            </p>
            <div class="divider"></div>
            <div class="row">
                <div class="input-field col s12 m4 l4">

                    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtlineatecnologica" id="txtlineatecnologica" onchange="usoInfraestructuraCreate.getEquipoPorLinea()">
                        <option value="">Seleccione Linea Tecnológica</option>
                        {{-- @forelse($lineastecnologicas as $id => $linea)
                            @if(isset($equipo->lineatecnologicanodo->lineatecnologica->id))
                                <option value="{{$id}}" {{ old('txtlineatecnologica', $equipo->lineatecnologicanodo->lineatecnologica->id) == $id ? 'selected':'' }}>{{$linea}}</option>
                            @else
                                <option value="{{$id}}" {{ old('txtlineatecnologica') == $id ? 'selected':'' }}>{{$linea}}</option>
                            @endif
                        @empty
                            <option value="">No hay información disponible</option>
                        @endforelse --}}
                    </select>
                    <label class="active" for="txtlineatecnologica">
                        Linea Tecnológica
                    </label>
                </div>
                <div class="input-field col s12 m4 l4">
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
                <div class="input-field col s12 m2 l2">
            
                    <input class="validate" id="txttiempouso" name="txttiempouso" type="number">
                        <label for="txttiempouso">
                            Tiempo Uso (Horas)
                        </label>
                    </input>
                </div>
                <div class="input-field col s2 m2 l2">
                    <a class="waves-effect waves-light btn blue m-b-xs btnAgregarEquipo"  onclick="agregarEquipoAusoInfraestructura()">
                        Agregar Equipo
                    </a>
                </div>
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
        </fieldset>
    </div>
</div>