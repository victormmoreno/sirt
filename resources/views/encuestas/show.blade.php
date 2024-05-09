@extends('layouts.guest')
@section('meta-title', 'Encuesta de satisfacción')
@section('meta-content', 'Encuesta de satisfacción')
@push('style')
    <style>
        /* input[type=radio].with-gap:checked+span:after,
        input[type=radio].with-gap:checked+span:before,
        input[type=radio].with-gap+span:after,
        input[type=radio].with-gap+span:before {
        background-color: transparent !important;
        border-color: transparent !important;
        box-shadow: none !important;
        } */
        /* i.material-icons {
        font-family: initial !important;
        font-weight: initial !important;
        } */
    .stars {
        --s:50px;
        position:relative;
        display:inline-flex;
        background-color: transparent !important;
        border-color: transparent !important;
        box-shadow: none !important;
    }
    .stars input {
        background-color: transparent !important;
        border-color: transparent !important;
        box-shadow: none !important;
        width:var(--s);
        height:var(--s);
        margin:0;
        opacity:0;
        cursor:pointer;
    }
    .stars i {
        font-family: initial !important;
        font-weight: initial !important;
        position:absolute;
        display:grid;
        inset:0 0 calc(var(--s)*0.1);
        pointer-events:none;
        --v1:transparent,#000 0.5deg 108deg,#0000 109deg;
        --v2:transparent,#000 0.5deg  36deg,#0000  37deg;
        -webkit-mask:
        conic-gradient(from 54deg  at calc(var(--s)*0.68) calc(var(--s)*0.57),var(--v1)),
        conic-gradient(from 90deg  at calc(var(--s)*0.02) calc(var(--s)*0.35),var(--v2)),
        conic-gradient(from 126deg at calc(var(--s)*0.5)  calc(var(--s)*0.7) ,var(--v1)),
        conic-gradient(from 162deg at calc(var(--s)*0.5)  0                  ,var(--v2));
        -webkit-mask-size: var(--s) var(--s);
        -webkit-mask-composite: xor,destination-over;
        mask-composite: exclude,add;
        background: #ccc;
    }
    .stars i:before,
    .stars i:after {
        content:"";
        grid-area:1/1;
        margin-inline-end:auto;
    }
    .stars i:before {
        background: gold;
        width:calc(var(--p,0)*var(--s));
    }
    .stars i:after {
        background: rgba(255,0,0,var(--o,0.3));
        width:calc(var(--l,0)*var(--s));
    }

    .stars:focus-within {
        outline:1px solid;
    }

        input:active ~ i{--o:1}

    input:nth-of-type(1):checked ~ i {--p:1}
    input:nth-of-type(2):checked ~ i {--p:2}
    input:nth-of-type(3):checked ~ i {--p:3}
    input:nth-of-type(4):checked ~ i {--p:4}
    input:nth-of-type(5):checked ~ i {--p:5}
    input:nth-of-type(6):checked ~ i {--p:6}
    input:nth-of-type(7):checked ~ i {--p:7}
    input:nth-of-type(8):checked ~ i {--p:8}
    input:nth-of-type(9):checked ~ i {--p:9}
    input:nth-of-type(10):checked ~ i {--p:10}
    /*input:nth-of-type(N):checked ~ i {--p:N}*/

    input:nth-of-type(1):hover ~ i {--l:1}
    input:nth-of-type(2):hover ~ i {--l:2}
    input:nth-of-type(3):hover ~ i {--l:3}
    input:nth-of-type(4):hover ~ i {--l:4}
    input:nth-of-type(5):hover ~ i {--l:5}
    input:nth-of-type(6):hover ~ i {--l:6}
    input:nth-of-type(7):hover ~ i {--l:7}
    input:nth-of-type(8):hover ~ i {--l:8}
    input:nth-of-type(9):hover ~ i {--l:9}
    input:nth-of-type(10):hover ~ i {--l:10}
        /*input:nth-of-type(N):hover ~ i {--l:N}*/
    </style>
@endpush
@section('content')
    <div class="section white">
        <div class="container">
            <div class="row  no-m-t no-m-b">
                <div class="col s12 m12 l12 ">
                    <h3 class="center primary-text">Encuesta de satisfacción al cliente</h3>
                    <h4 class="center primary-text">Proyecto: {{$proyecto->codigo_proyecto}}</h4>
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
                        <form id="formSaveSurvey" method="POST" action="{{ route('encuesta.answer') }}"
                            onsubmit="return checkSubmit()">
                            @csrf
                            @include('encuestas.forms.form')
                            <div class="col s12 center-align m-t-sm">
                                <button type="submit" id="login-btn"
                                    class="waves-effect waves-light btn bg-secondary center-align">
                                    <i class="material-icons left">send</i>
                                    Enviar resultados
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
