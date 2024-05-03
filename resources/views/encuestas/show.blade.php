@extends('layouts.guest')
@section('meta-title', 'Registro para usuarios nuevos')
@section('meta-content', 'Registro para usuarios nuevos')
@section('content')
    <div class="section white">
        <div class="container">
            <div class="row  no-m-t no-m-b">
                <div class="col s12 m12 l12 ">
                    <h3 class="center primary-text">Encuesta de satifascción al cliente</h3>
                    <div class="card-panel">
                        <h5>Estimado Talento.</h5>
                        <p>
                            Le agradecemos sinceramente su participación en esta encuesta de satisfacción confidencial, 
                            diseñada para evaluar su experiencia y percepción del Tecnoparque que ha acompañado su proceso. 
                            Su retroalimentación es fundamental para ayudarnos a comprender mejor sus necesidades, 
                            identificar áreas de mejora y fortalecer nuestro compromiso con el desempeño eficiente en la 
                            realización de proyectos.
                        </p>
                        <br>
                        <p>
                            Su participación en esta encuesta es completamente confidencial y 
                            sus respuestas, serán utilizadas únicamente con fines de análisis interno. 
                            Por favor, responda con honestidad y franqueza, ya que sus comentarios son esenciales para 
                            ayudarnos a mejorar continuamente en nuestros procesos de innovación, desarrollo tecnológico e 
                            investigación.
                        </p>
                        <br>
                        <p>
                            Agradecemos sinceramente su tiempo y contribución a este importante esfuerzo. 
                        </p>
                        <br>
                        <p>
                            ¡Gracias por ser parte de la Red Tecnoparque Colombia! 
                        </p>
                        <p>
                            Atentamente, 
                            <br>
                            Dirección de Formación Profesional - SENA. 
                        </p>
                    </div>
                    <div class="content">
                        <form id="formRegisterUser" method="POST" action="{{ route('register.request') }}"
                            onsubmit="return checkSubmit()">
                            @csrf
                            @include('encuestas.forms.form')
                            <div class="col s12 center-align m-t-sm">
                                <button type="submit" id="login-btn"
                                    class="waves-effect waves-light btn bg-secondary center-align">
                                    <i class="material-icons left">send</i>
                                    Enviar
                                </button>
                                <button type="reset" id="login-btn"
                                    class="modal-action modal-open waves-effect bg-danger btn center-align">
                                    <i class="material-icons left">backspace</i>
                                    Regresar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        divInfocenter = $('#infocenter_content');
        divDinamizador = $('#dinamizador_content');
        divArticulador = $('#articulador_content');
        divArticuladorAcompanamiento = $('#articulador_acompanamiento_content');
        divCredenciales = $('#credenciales_content');
        divAlcanzaObjetivo = $('#alcanza_objetivo_content');
        divOtrosServicios = $('#otros_servicios_content');
        divInfocenter.hide();
        divDinamizador.hide();
        divArticulador.hide();
        divArticuladorAcompanamiento.hide();
        divCredenciales.hide();
        divAlcanzaObjetivo.show();
        divOtrosServicios.hide();
    });

    // let softSlider = document.getElementById('infocenter_amabilidad');

    // noUiSlider.create(softSlider, {
    //     start: 2,
    //     range: {
    //         min: 1,
    //         max: 3
    //     },
    //     pips: {
    //         mode: 'values',
    //         values: [1, 2, 3],
    //         density: 4
    //     }
    // });
    function showInput_Infocenter() {
        if ($('#conoce_infocenter').is(':checked')) {
            divInfocenter.show();
        } else {
            divInfocenter.hide();
        }
    }

    function showInput_Dinamizador() {
        if ($('#conoce_dinamizador').is(':checked')) {
            divDinamizador.show();
        } else {
            divDinamizador.hide();
        }
    }

    function showInput_Articulador() {
        if ($('#conoce_articulador').is(':checked')) {
            divArticulador.show();
        } else {
            divArticulador.hide();
        }
    }

    function showInput_CompartirCredenciales() {
        if ($('#comparte_credenciales').is(':checked')) {
            divCredenciales.show();
        } else {
            divCredenciales.hide();
        }
    }

    function showInput_AlcanzaObjetivos() {
        if (!$('#alcanza_objetivos').is(':checked')) {
            divAlcanzaObjetivo.show();
        } else {
            divAlcanzaObjetivo.hide();
        }
    }

    function showInput_OtrosServicios() {
        if ($('#usa_otros_servicios').is(':checked')) {
            divOtrosServicios.show();
        } else {
            divOtrosServicios.hide();
        }
    }
</script>
@endpush
