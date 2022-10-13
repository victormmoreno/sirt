{!! csrf_field() !!}
<div class="row center">
    <div class="col s12 m12 l12">
        <p class="p-v-xs text-center">
            <label align="justify" for="txttalento" class="black-text text-black">
                Se realizo la postulación al convenio, convocatoria y/o instrumento:
            </label>

            <input class="txttipopostulacion" id="txtno" name="postulation" type="radio" value="no" onchange="articulacionCierre.checkedTypePostulacion()" @if(isset($articulation) && $articulation->postulation == 0) checked @endif/>
            <label align="justify" for="txtno" class="black-text text-black">
                No
            </label>
            <input  class="txttipopostulacion" id="txtsi" name="postulation" type="radio" value="si" onchange="articulacionCierre.checkedTypePostulacion()" @if(isset($articulation) && $articulation->postulation == 1) checked @endif/>
            <label align="justify" for="txtsi" class="black-text text-black">
                Si
            </label>
        </p>
        <small id="postulation-error" class="error red-text"></small>
    </div>
</div>
<div class="row r-no">
    <div class="input-field col s12 m12 l12">
        <div class="col s6 m6 l6">
            <p class="p-v-xs">
                <input type="checkbox" {{ $articulation->justified_report == 1 ? 'checked' : '' }}
                id="txtpdfjustificado" name="txtpdfjustificado" value="1">
                <label for="txtpdfjustificado">
                    PDF justificativo firmado por el Talento
                </label>
                <small id="txtpdfjustificado-error"  class="error red-text"></small>
            </p>
        </div>
    </div>
    <div class="input-field col s12 m12 l12">
        @if(isset($articulation))
            <textarea  name="txtjustificacion"  class="materialize-textarea" length="3500" maxlength="3500" id="txtjustificacion">{{$articulation->justification}}</textarea>
        @else
            <textarea name="txtjustificacion" class="materialize-textarea" length="3500" maxlength="3500" id="txtjustificacion"></textarea>
        @endif

        <label for="txtjustificacion">Justificación<span class="red-text">*</span></label>
        <small id="txtjustificacion-error" class="error red-text"></small>
    </div>
</div>
<div class="row r-si">
    <div class="col s12 m12 l12">
        <div class="row center">
            <div class="col s12 m12 l12">
                <p class="p-v-xs text-center">
                    <input  class="txtaprobacion" id="txtaprobado" name="txtaprobacion" type="radio" value="aprobado" onchange="articulacionCierre.checkedAprobacion()" {{ $articulation->approval_document == 1 ? 'checked' : '' }}/>
                    <label align="justify" for="txtaprobado" class="black-text text-black">
                        Aprobado
                    </label>
                    <input class="txtaprobacion" id="txtnoaprobado" name="txtaprobacion" type="radio" value="noaprobado" onchange="articulacionCierre.checkedAprobacion()" {{ $articulation->approval_document == 0 ? 'checked' : '' }}/>
                    <label align="justify" for="txtnoaprobado" class="black-text text-black" >
                        No aprobado
                    </label>
                </p>
                <small id="txtaprobacion-error" class="error red-text"></small>
            </div>
        </div>
        <div class="row r-aprobado">
            <div class="input-field col s12 m12 l6">
                @if(isset($articulation))
                    <input   id="txtrecibira" name="txtrecibira" type="text" class="validate" value="{{$articulation->receive}}">
                @else
                    <input id="txtrecibira" name="txtrecibira" type="text" class="validate">
                @endif
                <label for="txtrecibira">Qué recibirá</label>
                <small id="txtrecibira-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l6">
                @if(isset($articulation))
                    <input id="txtcuando" name="txtcuando" type="text" class="datepicker picker__input" value="{{$articulation->received_date}}">
                @else
                    <input id="txtcuando" name="txtcuando" type="text" class="datepicker picker__input">
                @endif

                <label for="txtcuando">Cuando <span class="red-text">*</span></label>
                <small id="txtcuando-error" class="error red-text"></small>
            </div>
            <div class="input-field col s12 m12 l6">
                <p class="p-v-xs">
                    <input type="checkbox" {{ $articulation->approval_document == 1 ? 'checked' : '' }}
                    id="txtpdfaprobacion" name="txtpdfaprobacion" value="1"/>
                    <label for="txtpdfaprobacion">
                        PDF de aprobación
                    </label>
                    <small id="txtpdfaprobacion-error"  class="error red-text"></small>
                </p>
            </div>
        </div>
        <div class="row r-no-aprobado">
            <div class="input-field col s12 m12 l6">
                <p class="p-v-xs">
                    <input type="checkbox"  {{ $articulation->non_approval_document == 1 ? 'checked' : '' }}
                    id="txtpdfnoaprobacion" name="txtpdfnoaprobacion" value="0">
                    <label for="txtpdfnoaprobacion">
                        PDF de no aprobación
                    </label>
                    <br>
                    <small id="txtpdfnoaprobacion-error"  class="error red-text"></small>
                </p>
            </div>
            <div class="input-field col s12 m12 l6">
                <p class="p-v-xs">
                    <input type="checkbox" {{ $articulation->postulation_document == 1 ? 'checked' : '' }}
                    id="txtdoc_postulacion" name="txtdoc_postulacion" value="1"/>
                    <label for="txtdoc_postulacion">
                        PDF de documentos de postulación
                    </label>
                    <small id="txtdoc_postulacion-error"  class="error red-text"></small>
                </p>
            </div>
            <div class="input-field col s12 m12 l12">
                @if(isset($articulation))
                    <textarea  @i name="txtinforme" class="materialize-textarea" length="3500" maxlength="3500" id="txtinforme">{{$articulation->report}}</textarea>
                @else
                    <textarea name="txtinforme" class="materialize-textarea" length="3500" maxlength="3500" id="txtinforme"></textarea>
                @endif

                <label for="txtinforme">Informe <span class="red-text">*</span></label>
                <small id="txtinforme-error" class="error red-text"></small>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l12">
        @if(isset($articulation))
            <textarea name="txtlecciones" class="materialize-textarea" length="3500" maxlength="3500" id="txtlecciones">{{$articulation->learned_lessons}}</textarea>
        @else
            <textarea name="txtlecciones" class="materialize-textarea" length="3500" maxlength="3500" id="txtlecciones"></textarea>
        @endif
        <label for="txtlecciones">Lecciones aprendidas<span class="red-text">*</span></label>
        <small id="txtlecciones-error" class="error red-text"></small>
    </div>
</div>
<div class="row">
    <div class="card-panel teal">
        <div class="dropzone" id="fase_cierre_articulacion"></div>
    </div>
</div>

