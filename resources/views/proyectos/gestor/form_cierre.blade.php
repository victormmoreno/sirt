{!! csrf_field() !!}
<div class="row">
    <div class="input-field col s12 m6 l6">
        <input disabled id="txtgestor" name="txtgestor"
            value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
        <label for="txtgestor" class="">Gestor</label>
    </div>
    <div class="input-field col s12 m6 l6">
        <input disabled id="txtlinea" name="txtlinea" value="{{ auth()->user()->gestor->lineatecnologica->nombre }}"
            type="text">
        <label for="txtlinea" class="">Línea Tecnológica</label>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <div class="col s12 m4 l4">
        <h5>¿TRL obtenido?</h5>
        <div class="input-field col s12 m6 l6">
            <p class="p-v-xs">
                <input id="trl_6" name="trl_obtenido" type="radio" value="0" />
                <label for="trl_6">
                    TRL 6
                </label>
            </p>
            <p class="p-v-xs">
                <input id="trl_7" name="trl_obtenido" type="radio" value="1" />
                <label for="trl_7">
                    TRL 7
                </label>
            </p>
            <p class="p-v-xs">
                <input id="trl_8" name="trl_obtenido" type="radio" value="2" />
                <label for="trl_8">
                    TRL 8
                </label>
            </p>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <span class="black-text text-black">¿Dirigido a área de emprendimiento SENA?</span>
        <div class="switch m-b-md">
            <label>
                No
                <input type="checkbox" name="txtdiri_ar_emp" id="txtdiri_ar_emp" value="1"
                    {{ $btnText == 'Guardar' ? '' : ($proyecto->diri_ar_emp == 0 ? '' : 'checked') }}>
                <span class="lever"></span>
                Si
            </label>
        </div>
    </div>
    <div class="col s12 m4 l4">
        <ul class="collection">
            <li class="collection-item">
                <span class="title cyan-text text-darken-3">
                    Costo Apróximado del Proyecto
                </span>
                <p>
                    $ {{$costo->getData()->costosTotales}}
                </p>
            </li>
        </ul>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <h5 class="center">Objetivos y conclusiones.</h5>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <h5 class="center">Objetivos cumplidos.</h5>
        <p class="p-v-xs">
            <input type="checkbox" name="objetivosAlcanzados[]" id="txtobjetivo1_alcanzado" value="1">
            <label for="txtobjetivo1_alcanzado">{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo }}</label>
        </p>
        <p class="p-v-xs">
            <input type="checkbox" name="objetivosAlcanzados[]" id="txtobjetivo2_alcanzado" value="1">
            <label for="txtobjetivo2_alcanzado">{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo }}</label>
        </p>
        <p class="p-v-xs">
            <input type="checkbox" name="objetivosAlcanzados[]" id="txtobjetivo3_alcanzado" value="1">
            <label for="txtobjetivo3_alcanzado">{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo }}</label>
        </p>
        <p class="p-v-xs">
            <input type="checkbox" name="objetivosAlcanzados[]" id="txtobjetivo4_alcanzado" value="1">
            <label for="txtobjetivo4_alcanzado">{{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo }}</label>
        </p>
    </div>
    <div class="col s12 m6 l6">
        <h5 class="center">Conclusiones y siguiente paso del proyecto</h5>
        <div class="input-field col s12 m12 l12">
            <textarea name="txtconclusiones" class="materialize-textarea" length="1000" maxlength="1000" id="txtconclusiones">{{ $btnText == 'Guardar' ? '' : $proyecto->articulacion_proyecto->actividad->conclusiones }}</textarea>
            <label for="txtconclusiones">Conclusiones y siguiente paso del proyecto <span class="red-text">*</span></label>
            <small id="txtconclusiones-error" class="error red-text"></small>
        </div>
    </div>
</div>
<div class="divider"></div>
<div class="row">
    <h5 class="center">Evidencias TRL</h5>
</div>
<div class="row">
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            <textarea name="txttrl_prototipo" class="materialize-textarea" length="300" maxlength="300" id="txttrl_prototipo">{{ $btnText == 'Guardar' ? '' : $proyecto->trl_prototipo }}</textarea>
            <label for="txttrl_prototipo">Evidencias Prototipo producto <span class="red-text">*</span></label>
            <small id="txttrl_prototipo-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            <textarea name="txttrl_pruebas" class="materialize-textarea" length="300" maxlength="300" id="txttrl_pruebas">{{ $btnText == 'Guardar' ? '' : $proyecto->trl_pruebas }}</textarea>
            <label for="txttrl_pruebas">Evidencias Pruebas documentadas <span class="red-text">*</span></label>
            <small id="txttrl_pruebas-error" class="error red-text"></small>
        </div>
    </div>
    <div class="col s12 m6 l6">
        <div class="input-field col s12 m12 l12">
            <textarea name="txttrl_modelo" class="materialize-textarea" length="300" maxlength="300" id="txttrl_modelo">{{ $btnText == 'Guardar' ? '' : $proyecto->trl_modelo }}</textarea>
            <label for="txttrl_modelo">Evidencias Modelo de negocio <span class="red-text">*</span></label>
            <small id="txttrl_modelo-error" class="error red-text"></small>
        </div>
        <div class="input-field col s12 m12 l12">
            <textarea name="txttrl_normatividad" class="materialize-textarea" length="300" maxlength="300" id="txttrl_normatividad">{{ $btnText == 'Guardar' ? '' : $proyecto->trl_normatividad }}</textarea>
            <label for="txttrl_normatividad">Evidencias Normatividad <span class="red-text">*</span></label>
            <small id="txttrl_normatividad-error" class="error red-text"></small>
        </div>
    </div>
</div>
<div class="divider"></div>
<center>
    <button type="submit" class="waves-effect cyan darken-1 btn center-aling">
        <i class="material-icons right">{{ isset($btnText) ? $btnText == 'Modificar' ? 'done' : 'done_all' : '' }}</i>
        {{isset($btnText) ? $btnText : 'error'}}
    </button>
    <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling">
        <i class="material-icons right">backspace</i>Cancelar
    </a>
</center>