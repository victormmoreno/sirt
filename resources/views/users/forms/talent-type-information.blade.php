<div class="{{ (Route::is('usuario.change-role-node') ? 'card grey lighten-4 p': 'card')}}">
    <div class="card-content">
        @if(Route::is('usuario.change-role-node'))
            <span class="card-title grey-text text-darken-4 center-align">Información {{ App\User::IsTalento() }}</span>
        @endif
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <select
                    class="js-states browser-default select2 select2-hidden-accessible"
                    id="talent_type" name="talent_type" style="width: 100%"
                    onchange="tipoTalento.getSelectTipoTalento(this)"
                    tabindex="-1">
                        <option value="">Seleccione tipo de talento</option>
                        @foreach($tipotalentos as $id => $nombre)
                            @if(!is_null($user->informacion_user) && isset($user->informacion_user['talento']['tipo_talento']))
                            <option
                            value="{{$id}}"
                                {{$user->informacion_user['talento']['tipo_talento'] == $nombre ? 'selected':''}}
                        >{{$nombre}}
                        </option>
                            @else
                            <option
                                value="{{$id}}"
                                {{old('talent_type') == $id ? 'selected':''}}
                            >{{$nombre}}
                            </option>
                            @endif

                        @endforeach
                </select>
                <label for="talent_type" class="active">Tipo Talento <span
                        class="red-text">*</span></label>
                <small id="talent_type-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row regional_centro" style="display:none">
            <div class="input-field col s12 m8 l6 ">
                <select
                    class=" js-states browser-default select2 select2-hidden-accessible"
                    id="regional" name="regional"
                    style="width: 100%" tabindex="-1"
                    onchange="tipoTalento.getCentroFormacion()"
                >
                    <option value="">Seleccione regional</option>
                        @foreach($regionales as $id => $nombre)
                            @if(isset($user->informacion_user['talento']['regional']))
                                <option
                                    value="{{$id}}" {{old('regional',$user->informacion_user['talento']['regional']) ==$nombre ? 'selected':''}}>{{$nombre}}</option>
                            @else
                                <option
                                    value="{{$id}}" {{old('regional') ==$id ? 'selected':''}}>{{$nombre}}</option>
                            @endif
                        @endforeach
                </select>
                <label for="regional" class="active">Regional <span
                        class="red-text">*</span></label>
                <small id="regional-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m6 l6" >
                <select
                    class="js-states browser-default select2 select2-hidden-accessible"
                    id="training_center"
                    name="training_center" style="width: 100%"
                    tabindex="-1">
                    <option value="">Seleccione Primero la regional</option>
                </select>
                <label for="training_center" class="active">Centro
                    de formación <span class="red-text">*</span></label>
                <small id="training_center-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row programa" style="display:none">
            <div class="input-field col s12 m12 l12">
                <input class="validate" id="training_program"
                        name="training_program" type="text"
                        value="{{ isset($user->informacion_user['talento']['programa_formacion']) ? $user->informacion_user['talento']['programa_formacion'] : old('training_program')}}">
                <label for="training_program">Programa de Formación
                    <span class="red-text">*</span></label>
                <small id="training_program-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row dependencia" style="display:none">
            <div class="input-field col s12 m12 l12">
                <input class="validate" id="dependency"
                        name="dependency" type="text"
                        value="{{ isset($user->informacion_user['talento']['dependencia']) ? $user->informacion_user['talento']['dependencia'] : old('dependency')}}">
                <label for="dependency">Dependencia
                    <span class="red-text">*</span></label>
                <small id="dependency-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row tipo_formacion" style="display:none">
            <div class="input-field col s12 m12 l12 ">
                <select class="" id="formation_type" name="formation_type"
                        style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Tipo Formación</option>
                        @foreach($tipoformaciones as $id => $nombre)
                            @if(isset($user->informacion_user['talento']['tipo_formacion']))
                                <option
                                    value="{{$id}}" {{old('formation_type',$user->informacion_user['talento']['tipo_formacion']) ==$nombre ? 'selected':''}}>{{$nombre}}</option>
                            @else
                                <option
                                    value="{{$id}}" {{old('formation_type') ==$id ? 'selected':''}}>{{$nombre}}</option>
                            @endif
                        @endforeach
                </select>
                <label for="formation_type">Tipo Formación
                    <span class="red-text">*</span>
                </label>
                <small id="formation_type-error" class="error red-text"></small>
            </div>


        </div>
        <div class="row empresa" style="display:none">
            <div class="input-field col s12 m12 l12">
                <input class="validate" id="company"
                        name="company" type="text"
                        value="{{ isset($user->informacion_user['talento']['empresa']) ? $user->informacion_user['talento']['empresa'] : old('company')}}">
                <label for="company">Empresa
                    <span class="red-text">*</span></label>
                <small id="company-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row tipo_estudio_universidad_carrera" style="display:none">
            <div class="input-field col s12 m12 l12">
                <select class="" id="study_type" name="study_type"
                        style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Tipo Estudio</option>
                        @foreach($tipoestudios as $id => $nombre)
                            @if(isset($user->informacion_user['talento']['tipo_estudio']))
                                <option
                                    value="{{$id}}" {{ old('study_type',$user->informacion_user['talento']['tipo_estudio']) == $nombre ? 'selected':''}}>{{$nombre}}</option>
                            @else
                                <option
                                    value="{{$id}}" {{old('study_type') == $id ? 'selected':''}}>{{$nombre}}</option>
                            @endif
                        @endforeach
                </select>
                <label for="study_type">Tipo Estudio <span class="red-text">*</span></label>
                <small id="study_type-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <input class="validate" id="university"
                       name="university" type="text"
                       value="{{ isset($user->informacion_user['talento']['universidad']) ? $user->informacion_user['talento']['universidad'] : old('university')}}">
                <label for="university">Universidad <span
                        class="red-text">*</span></label>
                <small id="university-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l12">
                <input class="validate" id="career" name="career"
                       type="text"
                       value="{{ isset($user->informacion_user['talento']['carrera']) ? $user->informacion_user['talento']['carrera'] : old('career')}}">
                <label for="career">Nombre de la Carrera <span
                        class="red-text">*</span></label>
                <small id="career-error" class="error red-text"></small>
            </div>
        </div>
    </div>
</div>
