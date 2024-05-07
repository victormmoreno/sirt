@extends('layouts.app')
@section('meta-title', 'Inicio')
@section('content')
    <main class="mn-inner inner-active-sidebar">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card card-transparent">
                    <div class="card-content">
                        <div class="center-align">
                            <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de
                                    la Red de Tecnoparques Colombia</span>
                            </p>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l10 offset-l1">
                                <img class="materialboxed responsive-img"
                                    src="{{ asset('img/logo-tecnoparque-green.svg') }}" alt="sena | Tecnoparque">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="complete_talent_information" class="modal modal-fixed-footer">
        <form id="complete_talent_information_form" class="d-inline" method="POST"
            action="{{ route('informationtalent.complete') }}">
            @csrf
            {!! method_field('PUT') !!}
            <div class="modal-content">
                <h4 class="center center-aling primary-text">Complete esta información</h4>
                <div class="divider"></div>
                <div class="row talento">
                    <div class="col s12 m12 l12">
                        <div class="card blue lighten-2 white-text">
                            <div class="card-content">
                                Antes de continuar, complete la información solicitada. Recuerde que la información
                                ingresada debe ser veridica y se debe ajustar a su perfil de talento actual.
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l12">
                        @include('users.forms.talent-type-information')
                    </div>
                    <div class="col s12 m12 l12">
                        <div class="row card p-v-md ">
                            <div class="card-content">
                                <div class="input-field col s12 m12 l12">

                                    <select class="js-states browser-default selectMultipe" id="txtocupaciones"
                                        name="txtocupaciones[]" style="width: 100%" tabindex="-1" multiple
                                        onchange="ocupacion.getOtraOcupacion(this)">

                                        @foreach ($ocupaciones as $id => $nombre)
                                            <option value="{{ $id }}"
                                                {{ collect(old('txtocupaciones', $user->ocupaciones->pluck('id')))->contains($id) ? 'selected' : '' }}>
                                                {{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="txtocupaciones" class="active">Ocupación
                                        <span class="red-text">*</span></label>
                                    <small id="txtocupaciones-error" class="error red-text"></small>

                                </div>
                                <div class="input-field col s12 m12 l12" id="otraocupacion">
                                    <input class="validate" id="txtotra_ocupacion" name="txtotra_ocupacion" type="text"
                                        value="{{ isset($user->otra_ocupacion) ? $user->otra_ocupacion : old('txtotra_ocupacion') }}">
                                    <label for="txtotra_ocupacion" class="active">¿Cuál?
                                        <span class="red-text">*</span></label>
                                    <small id="txtotra_ocupacion-error" class="error red-text"></small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer white-text">
                <button type="submit" class="waves-effect waves-primary btn-flat">Guardar información</button>
            </div>
        </form>
    </div>

@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('.selectMultipe').select2({
                language: "es",
            });
            @if (isset($user->informacion_user['talento']['tipo_talento']))
                tipoTalento.getSelectTipoTalento('{{ $user->informacion_user['talento']['tipo_talento'] }}');
            @endif
            @if (isset($user->informacion_user['talento']['regional']))
                tipoTalento.getCentroFormacion();
            @endif
            ocupacion.getOtraOcupacion();
        });
        $('#complete_talent_information').openModal({
            dismissible: false,
            opacity: 0.7,
            startingTop: '20%',
            endingTop: '60%',
        });
        const tipoTalento = {
            getSelectTipoTalento: function(idtipotalento) {
                let nameTalentType = $("#talent_type option:selected").text();
                if ((String(nameTalentType.trim()) == String(
                            '{{ App\Models\TipoTalento::IS_APRENDIZ_SENA_CON_APOYO }}') ||
                        String(nameTalentType.trim()) == String(
                            '{{ App\Models\TipoTalento::IS_APRENDIZ_SENA_SIN_APOYO }}'))) {
                    tipoTalento.showAprendizSena();
                } else if (String(nameTalentType.trim()) == String(
                    '{{ App\Models\TipoTalento::IS_EGRESADO_SENA }}')) {
                    tipoTalento.showEgresadoSena();
                } else if (String(nameTalentType.trim()) == String(
                        '{{ App\Models\TipoTalento::IS_INSTRUCTOR_SENA }}')) {
                    tipoTalento.showInstructorSena();
                } else if (String(nameTalentType.trim()) == String(
                        '{{ App\Models\TipoTalento::IS_FUNCIONARIO_SENA }}')) {
                    tipoTalento.showFuncionarioSena();
                } else if (String(nameTalentType.trim()) == String(
                        "{{ App\Models\TipoTalento::IS_PROPIETARIO_EMPRESA }}")) {
                    tipoTalento.showPropietarioEmpresa();
                } else if (String(nameTalentType.trim()) == String(
                    '{{ App\Models\TipoTalento::IS_EMPRENDEDOR }}')) {
                    tipoTalento.showEmprendedor();
                } else if (String(nameTalentType.trim()) == String(
                        '{{ App\Models\TipoTalento::IS_ESTUDIANTE_UNIVERSITARIO }}')) {
                    tipoTalento.showUniversitario();
                } else if (String(nameTalentType.trim()) == String(
                        '{{ App\Models\TipoTalento::IS_FUNCIONARIO_EMPRESA }}')) {
                    tipoTalento.showFuncionarioEmpresa();
                } else {
                    tipoTalento.showEmprendedor();
                }
            },
            showAprendizSena: function() {
                $(".regional_centro").css("display", "block");
                $(".programa").css("display", "block");
                $(".tipo_formacion").css("display", "none");
                $(".dependencia").css("display", "none");
                $(".empresa").css("display", "none");
                $(".tipo_estudio_universidad_carrera").css("display", "none");
            },
            showEgresadoSena: function() {
                $(".regional_centro").css("display", "block");
                $(".programa").css("display", "block");
                $(".tipo_formacion").css("display", "block");
                $(".dependencia").css("display", "none");
                $(".empresa").css("display", "none");
                $(".tipo_estudio_universidad_carrera").css("display", "none");

            },
            showInstructorSena: function() {
                $(".regional_centro").css("display", "block");
                $(".programa").css("display", "none");
                $(".tipo_formacion").css("display", "none");
                $(".dependencia").css("display", "none");
                $(".empresa").css("display", "none");
                $(".tipo_estudio_universidad_carrera").css("display", "none");
            },
            showFuncionarioSena: function() {
                $(".regional_centro").css("display", "block");
                $(".programa").css("display", "none");
                $(".tipo_formacion").css("display", "none");
                $(".dependencia").css("display", "block");
                $(".empresa").css("display", "none");
                $(".tipo_estudio_universidad_carrera").css("display", "none");
            },
            showPropietarioEmpresa: function() {
                $(".regional_centro").css("display", "none");
                $(".programa").css("display", "none");
                $(".tipo_formacion").css("display", "none");
                $(".dependencia").css("display", "none");
                $(".empresa").css("display", "block");
                $(".tipo_estudio_universidad_carrera").css("display", "none");
            },
            showEmprendedor: function() {
                $(".regional_centro").css("display", "none");
                $(".programa").css("display", "none");
                $(".tipo_formacion").css("display", "none");
                $(".dependencia").css("display", "none");
                $(".empresa").css("display", "none");
                $(".tipo_estudio_universidad_carrera").css("display", "none");
            },
            showUniversitario: function() {
                $(".regional_centro").css("display", "none");
                $(".programa").css("display", "none");
                $(".tipo_formacion").css("display", "none");
                $(".dependencia").css("display", "none");
                $(".empresa").css("display", "none");
                $(".tipo_estudio_universidad_carrera").css("display", "block");
            },
            showFuncionarioEmpresa: function() {
                $(".regional_centro").css("display", "none");
                $(".programa").css("display", "none");
                $(".tipo_formacion").css("display", "none");
                $(".dependencia").css("display", "none");
                $(".empresa").css("display", "block");
                $(".tipo_estudio_universidad_carrera").css("display", "none");
            },
            getCentroFormacion: function() {
                let regional = $('#regional').val();
                if (regional != null || regional != '') {
                    $.ajax({
                        dataType: 'json',
                        type: 'get',
                        url: `${host_url}/centro-formacion/getcentrosregional/${regional}`
                    }).done(function(response) {
                        $('#training_center').empty();
                        $('#training_center').append(
                            '<option value="">Seleccione el centro de formación</option>')
                        $.each(response.centros, function(id, nombre) {
                            @if (isset($user->informacion_user['talento']['centro_formacion']))
                                const selected = String(
                                    "{{ $user->informacion_user['talento']['centro_formacion'] }}"
                                    ) == String(nombre) ? 'selected' : '';
                                $('#training_center').append(
                                    `<option ${selected} value="${id}" >${nombre}</option>`);
                            @else
                                $('#training_center').append(
                                    `<option value="${id}" >${nombre}</option>`);
                            @endif
                        });
                        $('#training_center').material_select();
                    });
                }
            }
        }

        $(document).on('submit', 'form#complete_talent_information_form', function(
        event) { // $('button[type="submit"]').prop("disabled", true);
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            let form = $(this);
            let data = new FormData($(this)[0]);
            let url = form.attr("action");

            $.ajax({
                type: form.attr('method'),
                url: url,
                data: data,
                cache: false,
                contentType: false,
                dataType: 'json',
                processData: false,
                success: function(response) {
                    $('button[type="submit"]').removeAttr('disabled');
                    $('.error').hide();
                    printErrorsForm(response.data);
                    if (!response.data.fail) {
                        setTimeout(function() {
                            window.location.href = response.data.url;
                        }, 1500);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Error: " + errorThrown);
                }
            });
        });

        function printErrorsForm(data) {
            if (data.fail) {
                let errores = "";
                for (control in data.errors) {
                    errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
                    $('#' + control + '-error').html(data.errors[control]);
                    $('#' + control + '-error').show();
                }
            }
        }

        let ocupacion = {
            getOtraOcupacion:function (idocupacion) {
                $('#otraocupacion').hide();
                let id = $(idocupacion).val();
                let nombre = $("#txtocupaciones option:selected").text();
                let resultado = nombre.match(/[A-Z][a-z]+/g);
                @if($errors->any())
                $('#otraocupacion').hide();

                if (resultado != null  && resultado.includes('{{App\Models\Ocupacion::IsOtraOcupacion() }}')) {
                    $('#otraocupacion').show();
                }

                @endif
                if (resultado != null ) {
                    if (resultado.includes('{{App\Models\Ocupacion::IsOtraOcupacion() }}')) {
                        $('#otraocupacion').show();
                    }
                }
            }
        };
    </script>
@endpush
