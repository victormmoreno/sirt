{!! csrf_field() !!}
<div class="row">
    <div class="col s12 l3 show-on-large hide-on-med-and-down">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <span class="title"><b>Asesoría y uso</b></span>
                    <p>señor(a) usuario, por favor ingrese la información que se solcita en formulario.</p>
                </li>
                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                    <li class="collection-item">
                        <span class="title"><b>Paso 1</b></span>
                        <p>Por favor seleccione el tipo de asesoría y uso (Proyectos)</p>
                    </li>
                @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsArticulador())
                    <li class="collection-item">
                        <span class="title"><b>Paso 1</b></span>
                        <p>Por favor seleccione el tipo de asesoría y uso</p>
                    </li>
                @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                    <li class="collection-item">
                        <span class="title"><b>Paso 1</b></span>
                        <p>Por favor seleccione el tipo de asesoría y uso (Proyectos)</p>
                    </li>
                @endif
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m12 l9">
        <fieldset>
            <legend>Paso 1</legend>
            <p class="center card-title primary-text"><b> Asesoría y uso</b></p>
            <div class="divider"></div>
            <h5 class="center-align">
                <mark><i class="material-icons">info_outline</i> Seleccione a que se le hará la asesoría y uso</mark>
            </h5>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <p class="center p-v-xs">

                        @if(isset($asesorie->asesorable))
                            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsTalento() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                                <input class="with-gap" id="IsProyecto" name="txttipousoinfraestructura" type="radio" {{$asesorie->asesorable_type == App\Models\Proyecto::class ? 'checked' : old('txttipousoinfraestructura')}}  value="0"/>
                                <label for="IsProyecto">Proyectos</label>
                            @endif
                            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsArticulador()))
                                <input class="with-gap" id="IsArticulacion" name="txttipousoinfraestructura" type="radio" {{$asesorie->asesorable_type == App\Models\Articulation::class ? 'checked' : old('txttipousoinfraestructura')}} value="1"/>
                                <label for="IsIdea">Articulaciones</label>
                                <input class="with-gap" id="IsIdea" name="txttipousoinfraestructura" type="radio" {{$asesorie->asesorable_type == App\Models\Idea::class ? 'checked' : old('txttipousoinfraestructura')}} value="2"/>
                                <label for="IsIdea">Ideas</label>
                            @endif

                        @else
                            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsTalento() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                                <input class="with-gap" id="IsProyecto" name="txttipousoinfraestructura" type="radio" value="0"/>
                                <label for="IsProyecto">Proyectos</label>
                            @endif
                            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsArticulador()))

                                <input class="with-gap" id="IsArticulacion" name="txttipousoinfraestructura" type="radio" value="1"/>
                                <label for="IsArticulacion">Articulaciones</label>
                                <input class="with-gap" id="IsIdea" name="txttipousoinfraestructura" type="radio" value="2"/>
                                <label for="IsIdea">Ideas</label>
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
                @if(isset($asesorie->asesorable->nodo_id))
                    <input type="hidden" name="txtnodo" id="txtnodo" value="{{$asesorie->asesorable->nodo_id}}">
                @else
                    <input type="hidden" name="txtnodo" id="txtnodo">
                @endif
            </div>
            <div class="row">
                @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto() || session()->get('login_role') == App\User::IsArticulador() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                    @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsExperto()))
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">date_range</i>
                            @if(isset($asesorie->fecha))
                                <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$asesorie->fecha->format('Y-m-d')}}"/>
                            @else
                                <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$date}}"/>
                            @endif
                            <label for="txtfecha">fecha<span class="red-text">*</span></label>
                            <label class="error" for="txtfecha" id="txtfecha-error"></label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">vertical_split</i>
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsExperto())
                                @if(isset($asesorie->asesorable->asesor->lineatecnologica))
                                    <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$asesorie->asesorable->asesor->lineatecnologica->nombre}}"/>
                                @else
                                    <input id="txtlinea" name="txtlinea" readonly="" type="text" value="Por favor seleccione un tipo de asesoría y uso"/>
                                @endif
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                                @if(isset($asesorie->asesorable->asesor->lineatecnologica))
                                    <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$asesorie->asesorable->asesor->lineatecnologica->nombre}}"/>
                                @else
                                    <input id="txtlinea" name="txtlinea" readonly="" type="text" value="Por favor seleccione un tipo de asesoría y uso"/>
                                @endif
                            @endif
                            <label class="active" for="txtlinea">Linea Tecnológica<span class="red-text">*</span></label>
                            <label class="error" for="txtlinea" id="txtlinea-error"></label>
                        </div>
                    @endif
                    @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsArticulador() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                        <div class="input-field col s12 m12 l12">
                            <i class="material-icons prefix">date_range</i>
                            @if(isset($asesorie->fecha))
                                <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$asesorie->fecha->format('Y-m-d')}}"/>
                            @else
                                <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$date}}"/>
                            @endif
                            <label for="txtfecha">Fecha <span class="red-text">*</span></label>
                            <label class="error" for="txtfecha" id="txtfecha-error"></label>
                        </div>
                    @endif
                @elseif(session()->has('login_role') && (session()->get('login_role') == App\User::IsTalento() || session()->get('login_role') == App\User::IsApoyoTecnico()))
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">date_range</i>
                        @if(isset($asesorie->fecha))
                            <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$asesorie->fecha->format('Y-m-d')}}"/>
                        @else
                            <input class="datepicker" id="txtfecha" name="txtfecha" type="text" value="{{$date}}"/>
                        @endif
                        <label for="txtfecha"> Fecha<span class="red-text">*</span></label>
                        <label class="error" for="txtfecha" id="txtfecha-error"></label>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">vertical_split</i>
                        @if(isset($asesorie->asesorable->asesor->lineatecnologica))
                            <input id="txtlinea" name="txtlinea" readonly="" type="text" value="{{$asesorie->asesorable->asesor->nombre}}"/>
                        @else
                            <input id="txtlinea" name="txtlinea" readonly="" type="text" value="Por favor seleccione un tipo de asesoría y uso"/>
                        @endif
                        <label class="active" for="txtlinea">Linea Tecnológica<span class="red-text">* </span></label>
                        <label class="error" for="txtlinea" id="txtlinea-error"></label>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">account_circle</i>
                        @if(isset($asesorie->asesorable->asesor))
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="{{$asesorie->asesorable->asesor->documento}} - {{$asesorie->asesorable->asesor->nombres}} {{$asesorie->asesorable->asesor->apellidos}}"/>
                        @else
                            <input id="txtgestor" name="txtgestor" readonly="" type="text" value="Por favor seleccione un tipo de asesoría y uso"/>
                        @endif
                        <label class="active" for="txtgestor">Experto a cargo<span class="red-text">*</span></label>
                        <label class="error" for="txtgestor" id="txtgestor-error"></label>
                    </div>
                @endif
            </div>
            <div class="row divActividad">
                <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">library_books</i>
                    @if(isset($asesorie->asesorable_type) && ($asesorie->asesorable_type == App\Models\Proyecto::class))
                        <input id="txtactividad" name="txtactividad"  type="text" value="{{ isset($asesorie->asesorable->codigo_proyecto) ? $asesorie->asesorable->codigo_proyecto :  old('txtactividad')}} - {{ isset($asesorie->asesorable->nombre) ? $asesorie->asesorable->nombre : old('txtactividad')}}" readonly />
                        <label for="txtactividad">Proyecto</label>
                    @elseif(isset($asesorie->asesorable_type) && ($asesorie->asesorable_type == \App\Models\Articulation::class))
                        <input id="txtactividad" name="txtactividad"  type="text" value="{{ isset($asesorie->asesorable->code) ? $asesorie->asesorable->code :  old('txtactividad')}} - {{ isset($asesorie->asesorable->name) ? $asesorie->asesorable->name : old('txtactividad')}}" readonly />
                        <label for="txtactividad">seleccione un tipo de asesoría y uso<span class="red-text">*</span></label>
                    @elseif(isset($asesorie->asesorable_type) && ($asesorie->asesorable_type == App\Models\Idea::class))
                        <input id="txtactividad" name="txtactividad"  type="text" value="{{ isset($asesorie->asesorable->codigo_idea) ? $asesorie->asesorable->codigo_idea :  old('txtactividad')}} - {{ isset($asesorie->asesorable->nombre_proyecto) ? $asesorie->asesorable->nombre_proyecto : old('txtactividad')}}" readonly />
                        <label for="txtactividad">seleccione un tipo de asesoría y uso<span class="red-text">*</span></label>
                    @else
                        <input id="txtactividad" name="txtactividad"  type="text" readonly />
                        <label class="active" for="txtactividad">
                            @endif

                            <label class="error" for="txtactividad" id="txtactividad-error"></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">create</i>
                    @if(isset($asesorie->descripcion))
                        <textarea class="materialize-textarea" id="txtdescripcion" length="2000" name="txtdescripcion">{{$asesorie->descripcion}}</textarea>
                    @else
                        <textarea class="materialize-textarea" id="txtdescripcion" length="2000" name="txtdescripcion"></textarea>
                    @endif
                    <label for="txtdescripcion">Descripción</label>
                    <label class="error" for="txtdescripcion" id="txtdescripcion-error"></label>
                </div>
            </div>
        </fieldset>
    </div>
</div>

