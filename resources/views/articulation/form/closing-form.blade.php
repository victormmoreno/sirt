{!! csrf_field() !!}

<div class="col m12">
    <div class="row">
        <div class="col s12 m12 l12">
            <p class="p-v-xs text-center">
                <label align="justify" class="black-text text-black">
                <label align="justify" class="black-text text-black">
                    Se realizo la postulación al convenio, convocatoria y/o instrumento:
                </label>

                <input class="postulation" id="no" name="postulation" type="radio" value="no" onchange="articulationClosing.checkedTypePostulacion()" @if(isset($articulation) && $articulation->postulation == 0) checked @endif/>
                <label align="justify" for="no" class="black-text text-black">
                    No
                </label>
                <input  class="postulation" id="yes" name="postulation" type="radio" value="yes" onchange="articulationClosing.checkedTypePostulacion()" @if(isset($articulation) && $articulation->postulation == 1) checked @endif/>
                <label align="justify" for="yes" class="black-text text-black">
                    Si
                </label>
            </p>
            <small id="postulation-error" class="error red-text"></small>
        </div>
    </div>
</div>
<div class="col m12">
    <div class="row r-no">
        <div class="input-field col s12 m12 l12">
            <div class="col s6 m6 l6">
                <p class="p-v-xs">
                    <input type="checkbox" {{ isset($articulation) && $articulation->justified_report == 1 ? 'checked' : '' }}
                    id="justified_report" name="justified_report" value="1">
                    <label for="justified_report">
                        PDF justificativo firmado por el Talento
                    </label>
                    <small id="justified_report-error"  class="error red-text"></small>
                </p>
            </div>
        </div>
        <div class="input-field col s12 m12 l12">
            <textarea name="justification" class="materialize-textarea" length="3500" maxlength="3500" id="justification">{{isset($articulation) ? $articulation->justification: '' }}</textarea>
            <label for="justification">Justificación<span class="red-text">*</span></label>
            <small id="justification-error" class="error red-text"></small>
        </div>
    </div>
    <div class="row r-si">
        <div class="col s12 m12 l12">
            <div class="row center">
                <div class="col s12 m12 l12">
                    <p class="p-v-xs text-center">
                        <input  class="approval" id="approval" name="approval" type="radio" value="aprobado" onchange="articulationClosing.checkedApproval()" {{ $articulation->approval == 1 ? 'checked' : '' }}/>
                        <label align="justify" for="approval" class="black-text text-black">
                            Aprobado
                        </label>
                        <input class="non-approval" id="on-approval" name="approval" type="radio" value="noaprobado" onchange="articulationClosing.checkedApproval()" {{ $articulation->approval == 0 ? 'checked' : '' }}/>
                        <label align="justify" for="on-approval" class="black-text text-black" >
                            No aprobado
                        </label>
                    </p>
                    <small id="txtaprobacion-error" class="error red-text"></small>
                </div>
            </div>
            <div class="row r-aprobado">
                <div class="input-field col s12 m12 l6">
                    <input id="receive" name="receive" type="text" class="validate" value="{{isset($articulation) ? $articulation->receive: ''}}">
                    <label for="receive">Qué recibirá</label>
                    <small id="receive-error" class="error red-text"></small>
                </div>
                <div class="input-field col s12 m12 l6">
                    <input id="received_date" name="received_date" type="text" class="datepicker_articulation_date" value="{{isset($articulation) ? optional($articulation->received_date)->format('Y-m-d') : ''}}">
                    <label for="received_date">Cuando <span class="red-text">*</span></label>
                    <small id="received_date-error" class="error red-text"></small>
                </div>
                <div class="input-field col s12 m12 l6">
                    <p class="p-v-xs">
                        <input type="checkbox" {{ isset($articulation) && $articulation->approval_document == 1 ? 'checked' : '' }}
                        id="approval_document" name="approval_document" value="1"/>
                        <label for="approval_document">
                            PDF de aprobación
                        </label>
                        <small id="approval_document-error"  class="error red-text"></small>
                    </p>
                </div>
            </div>
            <div class="row r-no-aprobado">
                <div class="input-field col s12 m12 l6">
                    <p class="p-v-xs">
                        <input type="checkbox"  {{ isset($articulation) && $articulation->non_approval_document == 1 ? 'checked' : '' }}
                        id="non_approval_document" name="non_approval_document" value="0">
                        <label for="no_approval_document">
                            PDF de no aprobación
                        </label>
                        <br>
                        <small id="non_approval_document-error"  class="error red-text"></small>
                    </p>
                </div>
                <div class="input-field col s12 m12 l6">
                    <p class="p-v-xs">
                        <input type="checkbox" {{ isset($articulation) && $articulation->postulation_document == 1 ? 'checked' : '' }}
                        id="postulation_document" name="postulation_document" value="1"/>
                        <label for="postulation_document">
                            PDF de documentos de postulación
                        </label>
                        <small id="postulation_document-error"  class="error red-text"></small>
                    </p>
                </div>
                <div class="input-field col s12 m12 l12">
                    <textarea name="report" class="materialize-textarea" length="3500" maxlength="3500" id="report">{{isset($articulation) ? $articulation->report: '' }}</textarea>
                    <label for="report">Informe <span class="red-text">*</span></label>
                    <small id="report-error" class="error red-text"></small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 m12 l12">
            <textarea name="learned_lessons" class="materialize-textarea" length="3500" maxlength="3500" id="learned_lessons">{{isset($articulation) ? $articulation->learned_lessons : '' }}</textarea>
            <label for="learned_lessons">Lecciones aprendidas<span class="red-text">*</span></label>
            <small id="learned_lessons-error" class="error red-text"></small>
        </div>
    </div>

    <div class="row">
        <div class="card card-transparent">
            <div class="dropzone" id="articulation-closing-phase"></div>
        </div>
    </div>
    <div class="row">
        @include('articulation.table-archive-phase', ['fase' => 'Closing'])
    </div>
</div>





