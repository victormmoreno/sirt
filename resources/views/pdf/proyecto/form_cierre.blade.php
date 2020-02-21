@extends('pdf.illustrated-layout')
@section('title-file', 'Formulario de inicio '. config('app.name'))
@section('content-pdf')
<center>
  <div class="row">
    <h5>Datos del Proyecto</h5>
  </div>
</center>
<div class="row">
  <div class="column">
    <p>Idea de Proyecto: <span style="text-decoration: underline;">{{$proyecto->idea->codigo_idea}}</span></p>
  </div>
  <div class="column">
    <p>Nombre del Proyecto: <span
        style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->codigo_actividad}}
        {{$proyecto->articulacion_proyecto->actividad->nombre}}</span></p>
  </div>
</div>
<div class="row">
  <div class="column">
    <div class="row">
      <p>Área de Conocmiento: <span style="text-decoration: underline;">{{$proyecto->areaconocimiento->nombre}}</span>
      </p>
    </div>
    @if ($proyecto->areaconocimiento->nombre == 'Otro')
    <div class="row">
      <p>Otro área de conocmiento: <span style="text-decoration: underline;">{{$proyecto->otro_areaconocimiento}}</span>
      </p>
    </div>
    @endif
  </div>
  <div class="column">
    <p>Sublínea: <span style="text-decoration: underline;">{{$proyecto->sublinea->linea->abreviatura}} -
        {{$proyecto->sublinea->nombre}}</span></p>
  </div>
</div>
<div class="row">
  <div class="column">
      @if ($proyecto->trl_obtenido == 0)
      <p>TRL obtenido: <span style="text-decoration: underline;">TRL 6</span></p>
      @elseif($proyecto->trl_obtenido == 1)
      <p>TRL obtenido: <span style="text-decoration: underline;">TRL 7</span></p>
      @else
      <p>TRL obtenido: <span style="text-decoration: underline;">TRL 8</span></p>
      @endif
  </div>
  <div class="column">
    <p>¿Dirigido al área de emprendimiento SENA?: <span
        style="text-decoration: underline;">{{$proyecto->diri_ar_emp == 0 ? 'NO' : 'SI'}}</span></p>
  </div>
</div>
<div class="row">
    <div class="column">
      <p>Costo aproximado del proyecto: <span
          style="text-decoration: underline;">$ {{$costo->getData()->costosTotales}}</span></p>
    </div>
</div>
<h5 style="text-align: center">Objetivos y conclusiones</h5>
<div class="row">
  <div class="column">
      <div class="row">
            <p>Objetivos cumplidos: </p>
            <ul style="list-style-type:disc;">
                <li>
                    {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->objetivo }}
                    <br>
                    ¿Cumplido?
                    <br>
                    <span style="text-decoration: underline;">
                        {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[0]->cumplido == 1 ? 'SI' : 'NO' }}
                    </span>
                </li>
                <li>
                    {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->objetivo }}
                    <br>
                    ¿Cumplido?
                    <br>
                    <span style="text-decoration: underline;">
                        {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[1]->cumplido == 1 ? 'SI' : 'NO' }}
                    </span>
                </li>
                <li>
                    {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->objetivo }}
                    <br>
                    ¿Cumplido?
                    <br>
                    <span style="text-decoration: underline;">
                        {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[2]->cumplido == 1 ? 'SI' : 'NO' }}
                    </span>
                </li>
                <li>
                    {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->objetivo }}
                    <br>
                    ¿Cumplido?
                    <br>
                    <span style="text-decoration: underline;">
                        {{ $proyecto->articulacion_proyecto->actividad->objetivos_especificos[3]->cumplido == 1 ? 'SI' : 'NO' }}
                    </span>
                </li>
              </ul>
    </div>
</div>
    <div class="column">
        <p>Conclusiones y siguiente paso del proyecto: 
            <span style="text-decoration: underline;">{{$proyecto->articulacion_proyecto->actividad->conclusiones}}</span>
        </p>
      </div>
  </div>
</div>
<h5 style="text-align: center">Evidencias TRL</h5>
<div class="row">
  <div class="column">
    <p>Evidencias Prototipo producto: 
        <span style="text-decoration: underline;">{{$proyecto->trl_prototipo}}</span>
    </p>
  </div>
  <div class="column">
    <p>Evidencias Pruebas documentadas: 
        <span style="text-decoration: underline;">{{$proyecto->trl_pruebas}}</span>
    </p>
  </div>
</div>
<div class="row">
  <div class="column">
    <p>Evidencias Modelo de negocio: 
        <span style="text-decoration: underline;">{{$proyecto->trl_modelo}}</span>
    </p>
  </div>
  <div class="column">
    <p>Evidencias Normatividad: 
        <span style="text-decoration: underline;">{{$proyecto->trl_normatividad}}</span>
    </p>
  </div>
</div>
<br>
<br>
<br>
<br>
<div class="row">
  <div class="column">
    <p>______________________________</p>
    <small>Firma del gestor(a): {{$proyecto->articulacion_proyecto->actividad->gestor->user->nombres}}
      {{$proyecto->articulacion_proyecto->actividad->gestor->user->apellidos}}</small>
  </div>
  <div class="column">
    <p>______________________________</p>
    <small>Firma del talento interlocutor</small>
  </div>
</div>