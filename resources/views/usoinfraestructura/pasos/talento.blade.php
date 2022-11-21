<div class="row">
    <div class="col s12 l3 show-on-large hide-on-med-and-down">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsGestor() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                        <span class="title"><b>Paso 3</b></span>
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        <span class="title"><b>Paso 2</b></span>
                    @endif
                    <p>
                        señor(a) usuario, para ingresar los talentos a la asesoría y uso debe seleccionar el talento y presionar el boton agregar talento.
                    </p>
                </li>
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m12 l9">
        <fieldset>
            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                <legend>Paso 3</legend>
            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                <legend>Paso 2</legend>
            @endif
            <p class="center card-title orange-text text-darken-3">
                <b> Talentos</b>
            </p>
            <div class="divider"></div>
            <div class="row">
                <div class="input-field col s12 m9 l9">
                    <select class="js-states browser-default select2" id="txttalento" name="txttalento" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Talento</option>
                        @if(isset($usoinfraestructura->actividad->articulacion_proyecto->talentos->user))
                            @foreach($usoinfraestructura->actividad->articulacion_proyecto->talentos as $talento)
                                <option value="{{$talento->id}}">
                                    {{$talento->user()->withTrashed()->first()->documento}} - {{$talento->user()->withTrashed()->first()->nombres}} {{$talento->user->apellidos}}
                                </option>

                            @endforeach
                        @elseif(isset($usoinfraestructura->asesorable->talentos))
                            @foreach($usoinfraestructura->asesorable->talentos as $talento)
                                <option value="{{$talento->id}}">
                                    {{$talento->user()->withTrashed()->first()->documento}} - {{$talento->user()->withTrashed()->first()->nombres}} {{$talento->user->apellidos}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <label class="active" for="txttalento">
                        Talento
                    </label>
                </div>
                <div class="input-field col s12 m3 l3 offset-s3">
                    <a class="waves-effect waves-light btn bg-secondary white-text m-b-xs  btnAgregarTalento" onclick="addTalentoAUso()">
                        Agregar Talento
                    </a>
                </div>
            </div>
            <div class="row">
                <table class="striped centered responsive-table" id="tbldetallelineas">
                    <thead>
                        <tr>
                            <th>Talentos</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="detalleTalento">
                        @if(isset($usoinfraestructura->usotalentos))
                        @forelse ($usoinfraestructura->usotalentos as $key => $talento)
                            @if(isset($talento->user()->withTrashed()->first()->id))
                                    <tr id="filaTalento{{$talento->id}}">
                                        <td>
                                            <input type="hidden" name="talento[]" value="{{$talento->id}}"/>
                                            {{$talento->user()->withTrashed()->get()->last()->documento}} - {{$talento->user()->withTrashed()->get()->last()->nombres}} {{$talento->user()->withTrashed()->get()->last()->apellidos}}
                                        </td>
                                        <td>
                                            <a class="waves-effect bg-danger white-text btn" onclick="eliminarTalento({{$talento->id}});">
                                                <i class="material-icons">delete_sweep</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td>No se encontraron resultados</td>
                                    <td></td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
</div>
