<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        <span class="title"><b>Paso 5</b></span>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        <span class="title"><b>Paso 4</b></span>
                    @endif
                    <p>
                        señor(a) usuario, para ingresar los materiales de formación a la asesoría y uso debe seleccionar el material e ingresar la cantidad y presionar el boton agregar material.
                    </p>
                </li>
            </ul>
        </blockquote>
    </div>

    <div class="col s12 m9 l9" >
        <fieldset>
            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                <legend>Paso 5</legend>
            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                <legend>Paso 4</legend>
            @endif

            <p class="center card-title orange-text text-darken-3">
               <b> Materiales de Formación</b>
            </p>
            <div class="divider"></div>
            <br><br>
            <div class="row">
                <div class="input-field col s12 m7 l7">

                    @if(isset($usoinfraestructura->actividad->nodo->materiales))
                        <select class="js-states browser-default select2 " tabindex="-1" name="txtmaterial" id="txtmaterial" {{isset($usoinfraestructura->tipo_usoinfraestructura) && ($usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt() ) ? 'disabled' : ''}} onchange="getSelectMaterial()">
                            <option value="">Seleccione Material de  Formación</option>
                            @foreach($usoinfraestructura->actividad->nodo->materiales->where('lineatecnologica_id', $usoinfraestructura->actividad->gestor->lineatecnologica_id) as $material)

                                <option value="{{$material->id}}">
                                     {{$material->codigo_material}} - {{$material->presentacion->nombre}} {{str_limit($material->nombre,70 ,"...")}} x {{$material->medida->nombre}}
                                </option>

                            @endforeach
                        </select>
                    @else
                        <select class="js-states browser-default select2 " tabindex="-1" with="100%" style="width: 100%" name="txtmaterial" id="txtmaterial" {{isset($usoinfraestructura->tipo_usoinfraestructura) && ($usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt() ) ? 'disabled' : ''}} onchange="getSelectMaterial()">
                            <option value="">Seleccione Material de  Formación</option>
                        </select>

                    @endif

                    <label class="active" for="txtmaterial">
                        Matrerial de Formación
                    </label>
                </div>
                <div class="input-field col s12 m2 l2">
                    <input  id="txtcantidad" name="txtcantidad" type="number" min="0" step="0.1" value="1"  {{isset($usoinfraestructura->tipo_usoinfraestructura) && ($usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt()) ? 'disabled' : ''}}/>
                    <label for="txtcantidad">
                        Cantidad que se gasto
                    </label>
                    <label class="error" for="txtcantidad" id="txtcantidad-error"></label>
                </div>
                <div class="input-field col s2 m3 l3">
                    @if(isset($usoinfraestructura->tipo_usoinfraestructura) && ($usoinfraestructura->tipo_usoinfraestructura ==  App\Models\UsoInfraestructura::IsEdt() ))

                        <a class="waves-effect waves-light btn blue m-b-xs btnAgregarMaterial"  disabled>
                            Agregar Material
                        </a>
                    @else
                        <a class="waves-effect waves-light btn blue m-b-xs btnAgregarMaterial"  onclick="addMaterialesAUso()">
                            Agregar Material
                        </a>
                    @endif

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
                            @if(isset($usoinfraestructura->usomateriales))
                                @forelse ($usoinfraestructura->usomateriales as $key => $material)

                                        <tr id="filaMaterial{{$material->id}}">
                                            <td>
                                                <input type="hidden" name="material[]" value="{{$material->id}}"/>{{$material->codigo_material}} - {{$material->presentacion->nombre}} {{$material->nombre}} x {{$material->medida->nombre}}
                                            </td>
                                            <td>
                                                <input type="hidden" name="cantidad[]" value="{{$material->pivot->unidad}}"/>
                                                {{$material->pivot->unidad}}
                                            </td>
                                            <td>
                                                <a class="waves-effect red lighten-3 btn" onclick="eliminarMaterial({{$material->id}});">
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
