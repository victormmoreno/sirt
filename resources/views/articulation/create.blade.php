@extends('layouts.app')
@section('meta-title', __('Accompaniments'))
@section('content')
@php
  $year = Carbon\Carbon::now()->year;
@endphp
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="left left-align">
                <h5 class="left-align orange-text text-darken-3">
                    <i class="material-icons left">
                        autorenew
                    </i>
                    {{__('Accompaniments')}}
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li class="active"><a href="{{route('articulation.accompaniments')}}">{{__('Accompaniments')}}</a></li>
                    <li class="active">{{__('New Accompaniment')}}</li>
                </ol>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card mailbox-content">
                <div class="card-content">
                    {{-- <div class="row no-m-t no-m-b">
                        <div class="col s12 m12 l12">
                            <div class="mailbox-options">
                                <ul>
                                    <li class="text-mailbox active">Inicio</li>
                                    <li class="text-mailbox">Ejecución</li>
                                    <li class="text-mailbox">Cierre</li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                    <form id="articulation-form" action="#">
                        <div>
                            <h3>Tipo Acompañamiento</h3>
                            <section>
                                <div class="wizard-content">
                                    <div class="row">
                                        <div class="col m12">
                                            <div class="row valign-wrapper center-align">
                                                <div class="input-field col s12 m6 offset-m3 valign-wrapper center-align">

                                                    <div class="row m-t-lg">
                                                        <h5><b>Selecciona el tipo de acompañamiento</b></h5>
                                                        <div class="container-error center">
                                                            <p class="p-v-xs">
                                                                <input name="accompaniment_type" type="radio"  id="accompaniment_type_pbt" class="required validate" />
                                                                <label for="accompaniment_type_pbt">PBT</label>
                                                            </p>
                                                            <p class="p-v-xs">
                                                                <input name="accompaniment_type" type="radio" id="accompaniment_type_company" class="required validate"/>
                                                                <label for="accompaniment_type_company">Empresas</label>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <h3>Información Básica</h3>
                            <section>
                                <div class="wizard-content">
                                    <div class="row search-tabs-row search-tabs-header">
                                        <div class="col m12">
                                            <h5><b>Ingresa la Información requerida</b></h5>
                                            <div class="row">
                                                <div class="input-field col m12 s12">
                                                    <label for="name_accompaniment">Nombre</label>
                                                    <input id="name_accompaniment" name="name_accompaniment" type="text" class="required validate">
                                                </div>
                                                <div class="input-field col m12 s12">
                                                    <label for="description_accompaniment">Descripción (Opcional)</label>
                                                    <textarea id="description_accompaniment" name="description_accompaniment" type="text" class="materialize-textarea validate"></textarea>
                                                </div>
                                                <div class="input-field col m12 s12">
                                                    <label for="scope_accompaniment">Alcance</label>
                                                    <textarea id="scope_accompaniment" name="scope_accompaniment" type="text" class="materialize-textarea required validate"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row search-tabs-row search-tabs-header">
                                        <h5><b>Seleccione el Proyecto</b></h5>
                                        <div class="input-field col s12 m12 l4">
                                            <input type="text" id="filter_code" name="filter_code" class="autocomplete">
                                            <label for="filter_code">Código proyecto</label>
                                        </div>
                                        <div class="input-field col s12 m12 l8 right">
                                            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_project_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
                                            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_code_project"><i class="material-icons">search</i>Buscar</a>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="row search-tabs-row search-tabs-container grey lighten-4">
                                            <div class="col s12 m6 l6">
                                                <div class="mailbox-options grey lighten-4">
                                                    <ul class="grey lighten-4">
                                                        <li class="text-mailbox">Proyectos en fases de Ejecución, Cierre y finalizados</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col s12 m6 l6 right-align search-stats">
                                                <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response">
                                        <div class="row">
                                            <div class="col s12 m12 l12">
                                                <div class="card card-transparent p f-12">

                                                    <div class="card-content">
                                                        <span class="card-title p f-12">PBT-202234563234 - Sistema de integración agronomo</span>
                                                        <div class="position-top-right p f-12 mail-date hide-on-med-and-down"> Fecha cierre: 25 mayo 2021</div>
                                                        <p>Descripcion del proyecto</p>
                                                        <input type="hidden" name="txtpbt" value=""/>
                                                    </div>
                                                    <div class="card-action">
                                                    <a class="orange-text text-darken-1" target="_blank" href="">Ver más</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row search-tabs-row search-tabs-header">
                                        <h5><b>Seleccione el talento Interlocutor</b></h5>
                                        <div class="input-field col s12 m12 l4">
                                        <input type="number" id="txtsearch_user" name="txtsearch_user" class="autocomplete">
                                        <label for="txtsearch_user">Número de documento</label>
                                        </div>
                                        <div class="col s12 m12 l8 right">
                                            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_talents_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
                                            <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="search_talent"><i class="material-icons">search</i>Buscar</a>
                                        </div>
                                    </div>
                                    <div class="row search-tabs-row search-tabs-container grey lighten-4">
                                        <div class="col s12 m6 l6"></div>
                                        <div class="col s12 m6 l6 right-align search-stats">
                                            <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
                                        </div>
                                    </div>
                                    <div class="row search-tabs-row search-tabs-container white lighten-2 result-talents">
                                        <div class="row card-talent">
                                            <div class="col s12 m12 l12">
                                                <div class="card bs-dark ">
                                                    <div class="card-content ">

                                                        <span class="card-title p-h-lg  p f-12"> 232456326 - Pedro Jimenez</span>
                                                        <input type="hidden" name="talentos[]" value="}"/>
                                                        <div class="p-h-lg">
                                                            <label for ="radioInterlocutor">Talento Interlocutor</label>
                                                        </div>
                                                        <div class="position-top-right p f-12 mail-date hide-on-med-and-down no-m-b">  Acceso al sistema: SI</div>

                                                        <p class="hide-on-med-and-down no-m-b"> Miembro desde 24 abril 2019</p>
                                                    </div>
                                                    <div class="card-action">
                                                        <a target="_blank"  class="waves-effect waves-red btn-flat m-b-xs orange-text" href=""><i class="material-icons left"> link</i>Ver más</a>

                                                        <a class="waves-effect waves-red btn-flat m-b-xs red-text"><i class="material-icons left"> delete_sweep</i>Eliminar</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>
                            <h3>Terminos &amp; Condiciones</h3>
                            <section>
                                <div class="wizard-content">
                                    <div class="wizardTerms ">
                                        <div class="row search-tabs-row search-tabs-header">
                                            <div>
                                                <ul class="collection with-header">
                                                    <li class="collection-header">El articulador se compromete a:</li>
                                                    <li class="collection-item">Acompañar a talento en la recolección de información y procesos pertinentes para cumplir los requisitos de la postulación según el acompañamiento a ejecutar.</li>
                                                    <li class="collection-item">Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.</li>
                                                </ul>
                                            </div>
                                            <div>
                                                <ul class="collection with-header">
                                                    <li class="collection-header">El talento se compromete a:</li>
                                                    <li class="collection-item">Guardar confidencialidad y compromiso de la información susceptible del proyecto, la empresa y/o emprendimiento.</li>
                                                    <li class="collection-item">Brindar la información necesaria para realizar seguimiento acompañamiento de la articulación y/o articulaciones.</li>
                                                    <li class="collection-item">Estar atento a las fechas de la postulación, convenio o participación.</li>
                                                    <li class="collection-item">Facilitar la información al Articulador para cargar en plataforma los documentos donde se evidencie la participación y realizar aprobación de fases en los momentos que se requieran.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-tabs-row search-tabs-header">
                                        <div class="file-field input-field">
                                            <div class="btn orange lighten-1">
                                                <span>Formato confidencial</span>
                                                <input type="file" value="" placeholder="Formato confidencial">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <p class="search-tabs-row search-tabs-header">¡Al hacer clic en Siguiente, ambos actores aceptan los Términos y condiciones!</p>
                                </div>
                            </section>
                            <h3>Finish</h3>
                            <section>
                                <div class="wizard-content">
                                    Congratulations! You got the last step.
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
$( document ).ready(function() {
    var form = $("#articulation-form");
    var validator = $("#articulation-form").validate({
        rules: {
            confirm: {
                equalTo: "#password"
            },
            accompaniment_type:{ required:true }
        },

        messages:
        {
            accompaniment_type:
            {
                required:"</br>Por favor selecciona el tipo de acompañamiento<br/>"
            }
        },
        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.container-error') );
            }
            else
            { // This is the default behavior
                element.after(error);
            }
        }
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "fade",
        labels: {
            cancel: "Cancelar",
            current: "current step:",
            pagination: "Paginación",
            finish: "Guardar",
            next: "Siguiente",
            previous: "Anterior",
            loading: "Cargando ..."
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");
        }
    });

    $(".wizard .actions ul li a").addClass("waves-effect waves-blue btn-flat");
    $(".wizard .steps ul").addClass("tabs z-depth-1");
    $(".wizard .steps ul li").addClass("tab");
    $('ul.tabs').tabs();
    $('select').material_select();
    $('.select-wrapper.initialized').prev( "ul" ).remove();
    $('.select-wrapper.initialized').prev( "input" ).remove();
    $('.select-wrapper.initialized').prev( "span" ).remove();
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
    });
});
</script>
@endpush
