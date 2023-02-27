<div class="row">
    <div class="col s12 m12 l12">
        <div class="mailbox-view-header">
            <div class="center">
                <h5 class="center-align primary-text text-darken-3">Información talento</h5>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m4 l4 ">
                <select class="js-states browser-default select2 select2-hidden-accessible" id="txttipotalento" name="txttipotalento" style="width: 100%" tabindex="-1" onchange="tipoTalento.getSelectTipoTalento(this)">
                    <option value="">Seleccione tipo de talento</option>
                    @foreach($tipotalentos as $id => $nombre)
                        @if(isset($user->talento->tipotalento->id))
                        <option value="{{$id}}" {{old('txttipotalento',$user->talento->tipotalento->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                        @else
                            <option value="{{$id}}" {{old('txttipotalento') ==$id ? 'selected':''}}>{{$nombre}}</option>
                        @endif
                    @endforeach
                </select>
                <label for="txttipotalento" class="active">Tipo Talento <span class="red-text">*</span></label>
                <small id="txttipotalento-error"  class="error red-text"></small>
            </div>
            <div class="input-field col s12 m8 l8" >
                <div class="row">
                    <div class="input-field col s12 m12 l12 valign-wrapper selecttipotalento" style="display:block">
                        <h5>Selecciona un tipo de talento</h5>
                    </div>
                </div>
                <div class="row aprendizSena" style="display:none">
                    <div class="input-field col s12 m12 l12"  >
                        <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_aprendiz" name="txtregional_aprendiz" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionAprendiz()" >
                            <option value="">Seleccione regional</option>
                            @foreach($regionales as $id => $nombre)
                                @if(isset($user->talento->entidad->centro->regional->id))
                                    <option value="{{$id}}" {{old('txtregional_aprendiz',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                @else
                                    <option value="{{$id}}" {{old('txtregional_aprendiz') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="txtregional_aprendiz" class="active">Regional <span class="red-text">*</span></label>
                        <small id="txtregional_aprendiz-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12">
                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_aprendiz" name="txtcentroformacion_aprendiz" style="width: 100%" tabindex="-1" >
                            <option value="">Seleccione Primero la regional</option>
                        </select>
                        <label for="txtcentroformacion_aprendiz" class="active">Centro de formación <span class="red-text">*</span></label>
                        <small id="txtcentroformacion_aprendiz-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12 ">

                        <input class="validate" id="txtprogramaformacion_aprendiz" name="txtprogramaformacion_aprendiz" type="text"  value="{{ isset($user->talento->programa_formacion) ? $user->talento->programa_formacion : old('txtprogramaformacion_aprendiz')}}" >
                        <label for="txtprogramaformacion_aprendiz">Programa de Formación <span class="red-text">*</span></label>
                        <small id="txtprogramaformacion_aprendiz-error"  class="error red-text"></small>
                    </div>
                </div>
                <div class="row egresadoSena" style="display:none">
                    <div class="input-field col s12 m12 l12" >
                        <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_egresado" name="txtregional_egresado" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionEgresadoSena()">
                            @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                @if(isset($user->talento->entidad->centro->regional->id))
                                    <option value="{{$user->talento->entidad->centro->regional->id}}" selected="">{{$user->talento->entidad->centro->regional->nombre}}</option>
                                @else
                                    <option value="">No se encontraron resultados</option>
                                @endif
                            @else
                                <option value="">Seleccione regional</option>
                                @foreach($regionales as $id => $nombre)
                                    @if(isset($user->talento->entidad->centro->regional->id))
                                        <option value="{{$id}}" {{old('txtregional_egresado',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @else
                                        <option value="{{$id}}" {{old('txtregional_egresado') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <label for="txtregional_egresado" class="active">Regional <span class="red-text">*</span></label>
                        <small id="txtregional_egresado-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12">

                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_egresado" name="txtcentroformacion_egresado" style="width: 100%" tabindex="-1" >
                            <option value="">Seleccione Primero la regional</option>
                        </select>
                        <label for="txtcentroformacion_egresado" class="active">Centro de formación <span class="red-text">*</span></label>
                        <small id="txtcentroformacion_egresado-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12 ">

                        <input class="validate" id="txtprogramaformacion_egresado" name="txtprogramaformacion_egresado" type="text"  value="{{ isset($user->talento->programa_formacion) ? $user->talento->programa_formacion : old('txtprogramaformacion_egresado')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                        <label for="txtprogramaformacion_egresado">Programa de Formación <span class="red-text">*</span></label>
                        <small id="txtprogramaformacion_egresado-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12 ">
                        <select class="" id="txttipoformacion" name="txttipoformacion" style="width: 100%" tabindex="-1" >
                            @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                @if(isset($user->talento->tipoformacion->id))
                                    <option value="{{$user->talento->tipoformacion->id}}" selected="">{{$user->talento->tipoformacion->nombre}}</option>
                                @else
                                    <option value="">No se encontraron resultados</option>
                                @endif
                            @else
                                <option value="">Seleccione Tipo Formación</option>
                                @foreach($tipoformaciones as $id => $nombre)
                                    @if(isset($user->talento->tipoformacion->id))
                                        <option value="{{$id}}" {{old('txttipoformacion',$user->talento->tipoformacion->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @else
                                    <option value="{{$id}}" {{old('txttipoformacion') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <label for="txttipoformacion">Tipo Formación <span class="red-text">*</span></label>
                        <small id="txttipoformacion-error"  class="error red-text"></small>
                    </div>
                </div>

                <div class="row funcionarioSena" style="display:none">
                    <div class="input-field col s12 m12 l12" >
                        <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_funcionarioSena" name="txtregional_funcionarioSena" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionFuncionarioSena()" >
                            @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                @if(isset($user->talento->entidad->centro->regional->id))
                                    <option value="{{$user->talento->entidad->centro->regional->id}}" selected="">{{$user->talento->entidad->centro->regional->nombre}}</option>
                                @else
                                    <option value="">No se encontraron resultados</option>
                                @endif
                            @else
                                <option value="">Seleccione regional</option>
                                @foreach($regionales as $id => $nombre)
                                    @if(isset($user->talento->entidad->centro->regional->id))
                                        <option value="{{$id}}" {{old('txtregional_funcionarioSena',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @else
                                        <option value="{{$id}}" {{old('txtregional_funcionarioSena') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <label for="txtregional_funcionarioSena" class="active">Regional <span class="red-text">*</span></label>
                        <small id="txtregional_funcionarioSena-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12">
                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_funcionarioSena" name="txtcentroformacion_funcionarioSena" style="width: 100%" tabindex="-1" >
                            <option value="">Seleccione Primero la regional</option>
                        </select>
                        <label for="txtcentroformacion_funcionarioSena" class="active">Centro de formación <span class="red-text">*</span></label>
                        <small id="txtcentroformacion_funcionarioSena-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12">

                        <input class="validate" id="txtdependencia" name="txtdependencia" type="text"  value="{{ isset($user->talento->dependencia) ? $user->talento->dependencia : old('txtdependencia')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>

                        <label for="txtdependencia">Dependencia</label>
                        <small id="txtdependencia-error"  class="error red-text"></small>
                    </div>
                </div>
                <div class="row instructorSena" style="display:none">
                    <div class="input-field col s12 m12 l12" >
                        <select class=" js-states browser-default select2 select2-hidden-accessible" id="txtregional_instructorSena" name="txtregional_instructorSena" style="width: 100%" tabindex="-1" onchange="tipoTalento.getCentroFormacionInstructorSena()" >
                            @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                @if(isset($user->talento->entidad->centro->regional->id))
                                    <option value="{{$user->talento->entidad->centro->regional->id}}" selected="">{{$user->talento->entidad->centro->regional->nombre}}</option>
                                @else
                                    <option value="">No se encontraron resultados</option>
                                @endif
                            @else
                                <option value="">Seleccione regional</option>
                                @foreach($regionales as $id => $nombre)
                                    @if(isset($user->talento->entidad->centro->regional->id))
                                        <option value="{{$id}}" {{old('txtregional_instructorSena',$user->talento->entidad->centro->regional->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @else
                                        <option value="{{$id}}" {{old('txtregional_instructorSena') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <label for="txtregional_instructorSena" class="active">Regional <span class="red-text">*</span></label>
                        <small id="txtregional_instructorSena-error"  class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m12 l12">

                        <select class="js-states browser-default select2 select2-hidden-accessible" id="txtcentroformacion_instructorSena" name="txtcentroformacion_instructorSena" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione Primero la regional</option>
                        </select>
                        <label for="txtcentroformacion_instructorSena" class="active">Centro de formación <span class="red-text">*</span></label>
                        <small id="txtcentroformacion_instructorSena-error"  class="error red-text"></small>
                    </div>

                </div>
                <div class="row otherUser"></div>
                    <div class="row universitario" style="display:none">
                        <div class="input-field col s12 m12 l12" >
                            <select class="" id="txttipoestudio" name="txttipoestudio" style="width: 100%" tabindex="-1" >
                                @if(session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador())
                                    @if(isset($user->talento->tipoestudio->id))
                                        <option value="{{$user->talento->tipoestudio->id}}" selected="">{{$user->talento->tipoestudio->nombre}}</option>
                                    @else
                                        <option value="">No se encontraron resultados</option>
                                    @endif
                                @else
                                    <option value="">Seleccione Tipo Estudio</option>
                                    @foreach($tipoestudios as $id => $nombre)
                                        @if(isset($user->talento->tipoestudio->id))
                                        <option value="{{$id}}" {{old('txttipoestudio',$user->talento->tipoestudio->id) ==$id ? 'selected':''}}>{{$nombre}}</option>
                                        @else
                                            <option value="{{$id}}" {{old('txttipoestudio') ==$id ? 'selected':''}}>{{$nombre}}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            <label for="txttipoestudio">Tipo Estudio <span class="red-text">*</span></label>
                            <small id="txttipoestudio-error"  class="error red-text"></small>
                        </div>

                        <div class="input-field col s12 m12 l12" >
                            <input class="validate" id="txtuniversidad" name="txtuniversidad" type="text"  value="{{ isset($user->talento->universidad) ? $user->talento->universidad : old('txtuniversidad')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                            <label for="txtuniversidad">Universidad <span class="red-text">*</span></label>
                            <small id="txtuniversidad-error"  class="error red-text"></small>
                        </div>

                        <div class="input-field col s12 m12 l12" >
                            <input class="validate" id="txtcarrera" name="txtcarrera" type="text"  value="{{ isset($user->talento->carrera_universitaria) ? $user->talento->carrera_universitaria : old('txtcarrera')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                            <label for="txtcarrera">Nombre de la Carrera <span class="red-text">*</span></label>
                            <small id="txtcarrera-error"  class="error red-text"></small>
                        </div>
                    </div>
                    <div class="row funcionarioEmpresa" style="display:none">

                        <div class="input-field col s12 m12 l12" >
                            <input class="validate" id="txtempresa" name="txtempresa" type="text"  value="{{ isset($user->talento->empresa) ? $user->talento->empresa : old('txtempresa')}}" {{session()->get('login_role') == App\User::IsAdministrador() || session()->get('login_role') == App\User::IsDinamizador()  ? 'readonly' : ''}}>
                            <label for="txtempresa">Nombre de la Empresa <span class="red-text">*</span></label>
                            <small id="txtempresa-error"  class="error red-text"></small>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>






