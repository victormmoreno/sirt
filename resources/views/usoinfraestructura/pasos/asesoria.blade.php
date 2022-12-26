
<div class="row">
    <div class="col s12 l3 show-on-large hide-on-med-and-down">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Paso 2</b></span>
                    <p>
                        señor(a) usuario, por favor ingrese las horas de asesoria.
                    </p>
                </li>
                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto()))
                <li class="collection-item">
                    <span class="title"><b>Paso 2</b></span>
                    <p>Señor(a) usuario, si la asesoria fue acompañada por otro experto agregue a este en la sección de expertos Asesores, pulsando el boton agregar experto.</p>
                </li>
                @endif
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m12 l9">
        <fieldset>
            <legend>Paso 2</legend>
            <p class="center card-title orange-text text-darken-3"><b> Asesorias</b></p>
            <div class="divider"></div>
            <div class="row">
                <div class="col s12 m8 l8 offset-l2 m2">
                    <table class="striped centered responsive-table" id="tbldetallegestores">
                        <thead>
                            <tr>
                                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto()))
                                    <th>
                                        Linea Tecnológica
                                    </th>
                                @endif
                                <th>
                                    Asesor
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
                                @forelse ($usoinfraestructura->usogestores as $key => $user)
                                    @if($user->id === auth()->user()->id)
                                        <tr id="filaGestor{{$user->id}}">
                                            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto()))
                                                <td>{{$user->gestor->lineatecnologica->abreviatura}} -  {{$user->gestor->lineatecnologica->nombre}}</td>
                                            @endif
                                            <td>
                                                <input type="hidden" name="gestor[]"  value="{{$user->id}}" min="0" />{{$user->documento}} - {{$user->present()->userFullName()}}
                                            </td>
                                            <td><input type="number" name="asesoriadirecta[]" min="0" step="0.1" value="{{$user->pivot->asesoria_directa}}"></td>
                                            <td><input type="number" name="asesoriaindirecta[]" min="0" step="0.1" value="{{$user->pivot->asesoria_indirecta}}"></td>
                                        </tr>
                                    @endif
                                @empty
                                <tr id="filaGestor{{$usoinfraestructura->asesorable->asesor_id}}">
                                    @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto()))
                                        <td>{{$usoinfraestructura->asesorable->asesor->lineatecnologica->abreviatura}} -  {{$usoinfraestructura->asesorable->asesor->lineatecnologica->nombre}}</td>
                                    @endif
                                    <td>
                                        <input type="hidden" name="gestor[]" value="{{$usoinfraestructura->asesorable->asesor_id}}" min="0" />{{$usoinfraestructura->present()->expertoEncargado()}}- Asesor a cargo
                                    </td>
                                    <td><input type="number" name="asesoriadirecta[]" value="0" step="0.1" min="0"></td>
                                    <td><input type="number" name="asesoriaindirecta[]" value="0" step="0.1" min="0"></td>
                                </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Seleccione primero el tipo de asesoría y uso.</td>
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
            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto()))
            <br>
            <div class="divider"></div>
            <h5 class="center-align"><mark>Expertos Asesores</mark></h5>
            <br><br>
            <div class="row">
                <div class="input-field col s12 m4 l5">
                    <select class="js-states browser-default select2"  id="txtgestorasesor" name="txtgestorasesor" style="width: 100%" tabindex="-1" {{isset($usoinfraestructura->usogestores) ? '' : 'disabled'}} >
                        <option value="">Seleccione Experto</option>
                        @if(isset($usoinfraestructura->usogestores))
                            @foreach($gestores as $gestor)
                                <option value="{{$gestor->user->id}}">
                                    {{$gestor->user()->withTrashed()->first()->documento}} - {{$gestor->user()->withTrashed()->first()->nombres}} {{$gestor->user()->withTrashed()->first()->apellidos}} / {{$gestor->lineatecnologica->nombre}}
                                </option>
                            @endforeach
                        @else
                            @foreach($gestores as $gestor)
                            <option value="{{$gestor->user->id}}">
                                {{$gestor->user()->withTrashed()->first()->documento}} - {{$gestor->user()->withTrashed()->first()->nombres}} {{$gestor->user()->withTrashed()->first()->apellidos}} / {{$gestor->lineatecnologica->nombre}}
                            </option>
                            @endforeach
                        @endif
                    </select>
                    <label class="active" for="txtgestorasesor">Expertos</label>
                </div>
                <div class="input-field col s12 m2 l2">
                    @if(isset($usoinfraestructura->asesoria_directa))
                        <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="number"  min="0" step="0.1" value="0" />
                    @else
                        <input id="txtasesoriadirecta" name="txtasesoriadirecta" type="number" min="0" step="0.1" value="0" readonly />
                    @endif
                    <label class="active" for="txtasesoriadirecta">
                        Asesoria Directa (Horas)
                    </label>
                    <label class="error" for="txtasesoriadirecta" id="txtasesoriadirecta-error"></label>
                    <small class="center-align red-text text-ligth-3">solo se permite ingresar hasta 99 horas</small>
                </div>
                <div class="input-field col s12 m2 l2">
                    @if(isset($usoinfraestructura->asesoria_indirecta))
                        <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="number" min="0" step="0.1" value="0"  />
                    @else
                        <input id="txtasesoriaindirecta" name="txtasesoriaindirecta" type="number" min="0" step="0.1"  value="0" readonly />
                    @endif
                    <label class="active" for="txtasesoriaindirecta">
                        Asesoria Indirecta (Horas)
                    </label>
                    <label class="error" for="txtasesoriaindirecta" id="txtasesoriaindirecta-error"></label>
                    <small class="center-align red-text text-ligth-3">solo se permite ingresar hasta 99 horas</small>
                </div>
                <div class="input-field col s12 m3 l3 offset-s3">
                    <a class="waves-effect waves-light btn bg-secondary white-text m-b-xs btnAgregarGestorAsesor"  onclick="addGestoresAUso()">Agregar Experto</a>
                </div>
                <div class="row">
                    <div class="col s12 m8 l8 offset-l2 m2">
                        <table class="striped centered responsive-table" id="tbldetallegestorAsesor">
                            <thead>
                                <tr>
                                    <th>
                                        Experto
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
                                @if(isset($usoinfraestructura->usogestores))
                                    @forelse ($usoinfraestructura->usogestores as $key => $user)
                                            <tr id="filaGestorAsesor{{$user->id}}">
                                                @if($user->id != auth()->user()->id)
                                                    <td>
                                                        <input type="hidden" name="gestor[]" value="{{$user->id}}"/>{{$user->present()->userDocumento()}} - {{$user->present()->userFullName()}} / {{$user->gestor->lineatecnologica->nombre}}
                                                    </td>
                                                    <td><input type="number" name="asesoriadirecta[]" value="{{$user->pivot->asesoria_directa}}"></td>
                                                    <td><input type="number" name="asesoriaindirecta[]" value="{{$user->pivot->asesoria_indirecta}}"></td>
                                                    <td>
                                                        <a class="waves-effect bg-danger white-text btn" onclick="eliminarGestorAsesor({{$user->id}});">
                                                            <i class="material-icons">delete_sweep</i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                    @empty
                                        <td>No se encontraron resultados</td>
                                        <td></td>
                                        <td></td>
                                    @endforelse
                                @else
                                    <td></td>
                                    <td>No se encontraron resultados</td>
                                    <td></td>
                                    <td></td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </fieldset>
    </div>
</div>
