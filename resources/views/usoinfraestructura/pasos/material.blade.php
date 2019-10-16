<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Paso 5</b></span>
                    <p>
                        señor(a) ususario, por favor ingrese las horas de asesoria.
                    </p>
                </li>
                <li class="collection-item">
                    <span class="title"><b>Paso 5</b></span>
                    <p>
                        señor(a) ususario, si la asesoria fue acompañada por otro gestor ingrese este en la sección de gestores Asesores.
                    </p>
                </li>
                
            </ul>
        </blockquote>
    </div>

    <div class="col s12 m9 l9">
        <fieldset>
            <legend>Paso 5</legend>
            <p class="center card-title orange-text text-darken-3">
               <b> Materiales de Formación</b> 
            </p>
            <div class="divider"></div>
            <div class="row">
                <div class="input-field col s12 m7 l7">

                    <select class="js-states browser-default select2 " tabindex="-1" style="width: 100%" name="txtmaterial" id="txtmaterial" >
                        <option value="">Seleccione Material de  Formación</option>
                        {{-- @forelse($materiales as $id => $material)
                            @if(isset($equipo->lineatecnologica->id))
                                <option value="{{$id}}" {{ old('txtmaterial', $equipo->lineatecnologica->id) == $id ? 'selected':'' }}>{{$material}}</option>
                            @else
                                <option value="{{$id}}" {{ old('txtmaterial') == $id ? 'selected':'' }}>{{$material}}</option>
                            @endif
                        @empty
                            <option value="">No hay información disponible</option>
                        @endforelse --}}
                    </select>
                    <label class="active" for="txtmaterial">
                        Matrerial de Formación
                    </label>
                </div>
                <div class="input-field col s12 m2 l2">
                    
                    @if(isset($usoinfraestructura->fecha))
                        <input  id="txtcantidad" name="txtcantidad" type="number" value="{{$usoinfraestructura}}"/>
                    @else
                        <input  id="txtcantidad" name="txtcantidad" type="number" value="1" />
                    @endif
                    <label for="txtcantidad">
                        Cantidad
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    <label class="error" for="txtcantidad" id="txtcantidad-error"></label>
                </div>
                <div class="input-field col s2 m3 l3">
                    <a class="waves-effect waves-light btn blue m-b-xs btnAgregarMaterial"  onclick="addMaterialesAUso()">
                        Agregar Material 
                    </a> 
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12 l12">
                    <table class="striped centered responsive-table" id="tbldetallelineas">
                        <thead>
                            <tr>
                                <th>
                                    Material de Formación
                                </th>
                                <th>
                                    Cantidad
                                </th>
                                <th>
                                    Eliminar
                                </th>
                            </tr>
                        </thead>
                        <tbody id="detalleMaterialUso">
                            @if(isset($usoinfraestructura->usoequipos))
                                @forelse ($usoinfraestructura->usoequipos as $key => $equipo)
                                        
                                        <tr id="filaMaterial{{$equipo->id}}">
                                            <td>
                                                <input type="hidden" name="material[]" value="{{$equipo->id}}"/>{{$equipo->nombre}}
                                            </td>
                                            <td>
                                                <input type="hidden" name="cantidad[]" value="{{$equipo->pivot->tiempo}}"/>
                                                {{$equipo->pivot->tiempo}}
                                            </td>
                                            <td>
                                                <a class="waves-effect red lighten-3 btn" onclick="eliminarMaterial({{$equipo->id}});">
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
        </fieldset>
    </div>
</div>