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
                                                                <input name="accompaniment_type" type="radio"  id="accompaniment_type_pbt" class="required validate" value="pbt"/>
                                                                <label for="accompaniment_type_pbt">PBT</label>
                                                            </p>
                                                            <p class="p-v-xs">
                                                                <input name="accompaniment_type" type="radio" id="accompaniment_type_company" class="required validate" value="empresa"/>
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
                                    <div class="section-project" style="display: none;">
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
                                    </div>
                                    <div class="section-company" style="display: none;">
                                        <div class="row search-tabs-row search-tabs-header">
                                            <h5><b>Seleccione la sede de la empresa</b></h5>
                                            <div class="input-field col s12 m12 l4">
                                                <input type="text" id="filter_nit" name="filter_nit" class="autocomplete">
                                                <label for="filter_nit">Nit Empresa</label>
                                            </div>
                                            <div class="input-field col s12 m12 l8 right">
                                                <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_company_advanced"><i class="material-icons">list</i>Busqueda Avanzada</a>
                                                <a class="waves-effect waves-grey btn-flat search-tabs-button right" id="filter_nit_company"><i class="material-icons">search</i>Buscar</a>
                                            </div>
                                        </div>
                                        <div class="row search-tabs-row search-tabs-container grey lighten-4">
                                            <div class="col s12 m6 l6">
                                                <div class="mailbox-options grey lighten-4">
                                                    <ul class="grey lighten-4">
                                                        <li class="text-mailbox">Sedes de la empresa</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col s12 m6 l6 right-align search-stats">
                                                <span class="m-r-sm">Resultados</span><span class="secondary-stats"></span>
                                            </div>
                                        </div>
                                        <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response-sedes">
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <div class="card card-transparent">
                                                        <div class="card-content">
                                                            <div class="search-result">
                                                                <p class="search-result-description">No se encontraron resultados</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row search-tabs-row search-tabs-container grey lighten-4">
                                            <div class="col s12 m12 l12">
                                                <div class="mailbox-options grey lighten-4 text-white">
                                                    <ul class="grey lighten-4 text-white result-sede">
                                                        <li class="text-mailbox ">Sede que participará en la articulación</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row search-tabs-row search-tabs-container white lighten-4 alert-response-company">
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <div class="card transparent bs-dark">
                                                        <div class="card-content">
                                                            <span class="card-title p-h-lg">Colanta - Medellín Antioquia</span>
                                                            <input type="hidden" name="txtsede" value=""/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section-talent" style="display: none;">
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
                            <h3>Articulaciones</h3>
                            <section>
                                <div class="wizard-content">
                                    <div class="row search-tabs-row search-tabs-header">
                                        <div class="col m12">
                                            <h5><b>¿Desea registrar una articulación?</b></h5>
                                            <div class="row">
                                                <div class="col s12 m12 l12">
                                                    <p class="p-v-xs text-center">
                                                        <label align="justify" class="black-text text-black">
                                                            ¿Desea registrar una articulación?
                                                        </label>
                                                        <input  class="articulation" id="articulation_yes" name="articulation" type="radio" value="si" onchange="articulacionCierre.checkedTypePostulacion()" />
                                                        <label align="justify" for="articulation_yes" class="black-text text-black">
                                                            Si
                                                        </label>
                                                        <input class="articulation" id="articulation_no" name="articulation" type="radio" value="no" checked onchange="articulacionCierre.checkedTypePostulacion()" />
                                                        <label align="justify" for="articulation_no" class="black-text text-black">
                                                            No
                                                        </label>
                                                    </p>
                                                    <small id="articulation-error" class="error red-text"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section-articulation search-tabs-row search-tabs-header" style="display: none;">
                                        <div class="col m12">
                                            <div class="row">
                                                <div class="input-field col m12 s12">
                                                    <div class="radio-buttons">
                                                        <label class="custom-radio">
                                                        <input type="radio" name="radio" checked />
                                                        <span class="radio-btn"
                                                            ><i class="las la-check"></i>
                                                            <div class="hobbies-icon">
                                                            <i class="las la-biking"></i>
                                                            <h3>Biking</h3>
                                                            </div>
                                                        </span>
                                                        </label>
                                                        <label class="custom-radio">
                                                        <input type="radio" name="radio" />
                                                        <span class="radio-btn"
                                                            ><i class="las la-check"></i>
                                                            <div class="hobbies-icon">
                                                            <i class="las la-futbol"></i>
                                                            <h3>Football</h3>
                                                            </div>
                                                        </span>
                                                        </label>
                                                        <label class="custom-radio">
                                                        <input type="radio" name="radio" />
                                                        <span class="radio-btn"
                                                            ><i class="las la-check"></i>
                                                            <div class="hobbies-icon">
                                                            <i class="las la-table-tennis"></i>
                                                            <h3>Table Tennis</h3>
                                                            </div>
                                                        </span>
                                                        </label>
                                                        <label class="custom-radio">
                                                        <input type="radio" name="radio" />
                                                        <span class="radio-btn"
                                                            ><i class="las la-check"></i>
                                                            <div class="hobbies-icon">
                                                            <i class="las la-ellipsis-h"></i>
                                                            <h3>Other</h3>
                                                            </div>
                                                        </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="input-field col m12 s12">
                                                    <label for="name_articulation">Nombre Articulación</label>
                                                    <input id="name_articulation" name="name_articulation" type="text">
                                                </div>
                                                <div class="input-field col m12 s12">
                                                    <label for="description_articulation">Descripción Articulación (Opcional)</label>
                                                    <textarea id="description_articulation" name="description_articulation" type="text" class="materialize-textarea validate"></textarea>
                                                </div>
                                                <div class="input-field col m12 s12">
                                                    <label for="scope_articulation">Alcance Artuculación</label>
                                                    <textarea id="scope_articulation" name="scope_articulation" type="text" class="materialize-textarea"></textarea>
                                                </div>
                                                <div class="input-field col s12 m12 l12">
                                                    @if(isset($articulacion))
                                                        <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtfecha_inicio" name="txtfecha_inicio" type="text" class="datepicker picker__input" value="{{$articulacion->present()->articulacionPbtstartDate()}}">
                                                    @else
                                                        <input id="txtfecha_inicio" name="txtfecha_inicio" type="text" class="datepicker picker__input">
                                                    @endif
                                                    <label for="txtfecha_inicio">Fecha de inicio de la articulación <span class="red-text">*</span></label>
                                                    <small id="txtfecha_inicio-error" class="error red-text"></small>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12 m12 l6">
                                                    <label class="active" for="txt_tipo_articulacion">Tipo Articulación<span class="red-text">*</span></label>
                                                    <select  @if(isset($articulacion) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  name="txt_tipo_articulacion" id="txt_tipo_articulacion">
                                                        <option value="">Seleccione tipo Articulación</option>
                                                        <option value="">SenaInnova</option>
                                                        <option value="">ColInnova</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s12 m12 l6">
                                                    <label class="active" for="txt_alcance_articulacion">Alcance<span class="red-text">*</span></label>
                                                    <select @if( isset($articulacion) && !$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txt_alcance_articulacion" name="txt_alcance_articulacion" style="width: 100%" tabindex="-1">
                                                        <option value="">Seleccione Alcance Articulación</option>
                                                        <option value="">Local</option>
                                                        <option value="">Regional</option>
                                                        <option value="">Nacional</option>
                                                        <option value="">Internacional</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12 m12 l6">
                                                    @if(isset($articulacion))
                                                        <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtname_entidad" type="text" name="txtname_entidad" class="validate" value="{{$articulacion->present()->articulacionPbtEntidad()}}">
                                                    @else
                                                        <input id="txtname_entidad" type="text" name="txtname_entidad" class="validate">
                                                    @endif
                                                    <label for="txtname_entidad">Entidad con la que se realiza la articulación<span class="red-text">*</span></label>
                                                    <small id="txtname_entidad-error" class="error red-text"></small>
                                                </div>
                                                <div class="input-field col s12 m12 l6">
                                                    @if(isset($articulacion))
                                                        <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtname_contact" type="text" name="txtname_contact" class="validate" value="{{$articulacion->present()->articulacionPbtNombreContacto()}}">
                                                    @else
                                                        <input id="txtname_contact" type="text" name="txtname_contact" class="validate">
                                                    @endif
                                                    <label for="txtname_contact">Nombre de contacto<span class="red-text">*</span></label>
                                                    <small id="txtname_contact-error" class="error red-text"></small>
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12 m12 l12">
                                                        @if(isset($articulacion))
                                                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtemail" name="txtemail" type="email" class="validate" value="{{$articulacion->present()->articulacionPbtEmail()}}">
                                                        @else
                                                            <input id="txtemail" name="txtemail" type="email" class="validate">
                                                        @endif
                                                        <label for="txtemail">Correo institucional de la entidad<span class="red-text">*</span></label>
                                                        <small id="txtemail-error" class="error red-text"></small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12 m12 l6">
                                                        @if(isset($articulacion))
                                                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtnombre_convocatoria" name="txtnombre_convocatoria" type="text" class="validate" value="{{$articulacion->present()->articulacionPbtNombreConvocatoria()}}">
                                                        @else
                                                            <input id="txtnombre_convocatoria" name="txtnombre_convocatoria" type="text" class="validate">
                                                        @endif
                                                        <label for="txtnombre_convocatoria">Nombre de convocatoria (Opcional)</label>
                                                        <small id="txtnombre_convocatoria-error" class="error red-text"></small>
                                                    </div>
                                                    <div class="input-field col s12 m12 l6">
                                                        @if(isset($articulacion))
                                                            <input @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  id="txtfecha_esperada" name="txtfecha_esperada" type="text" class="validate datepicker-min-date" value="{{$articulacion->present()->articulacionPbtFechaFinalizacion()}}">
                                                        @else
                                                            <input id="txtfecha_esperada" name="txtfecha_esperada" type="text" class="validate datepicker-min-date">
                                                        @endif

                                                        <label for="txtfecha_esperada">Fecha esperada de finalización <span class="red-text">*</span></label>
                                                        <small id="txtfecha_esperada-error" class="error red-text"></small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-field col s12 m12 l12">
                                                        @if(isset($articulacion))
                                                            <textarea  @if(!$articulacion->present()->articulacionPbtIssetFase(App\Models\Fase::IsInicio())) disabled @endif  name="txtobjetivo" class="materialize-textarea" length="500" maxlength="500" id="txtobjetivo">{{$articulacion->present()->articulacionPbtObjetivo()}}</textarea>
                                                        @else
                                                            <textarea name="txtobjetivo" class="materialize-textarea" length="3500" maxlength="3500" id="txtobjetivo"></textarea>
                                                        @endif

                                                        <label for="txtobjetivo">Objetivo<span class="red-text">*</span></label>
                                                        <small id="txtobjetivo-error" class="error red-text"></small>
                                                    </div>
                                                </div>


                                        </div>
                                    </div>
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

