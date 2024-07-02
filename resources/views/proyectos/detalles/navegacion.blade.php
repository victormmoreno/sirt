<div class="divider"></div>
<ul class="tabs">
    <li class="tab col s3"><a class="active" href="#info_proyecto">Información del Proyecto</a></li>
    <li class="tab col s3"><a href="#info_asesorias">Asesorias</a></li>
    <li class="tab col s3"><a href="#info_idea">Idea</a></li>
    <li class="tab col s3"><a href="#info_trazabilidad">Trazabilidad</a></li>
</ul>
<br>
<div id="info_proyecto">
    @include('proyectos.navegacion')
    {{-- @include('proyectos.historial_cambios') --}}
    <div class="mailbox-view mailbox-text">
        <div class="row">
            @if ($proyecto->fase->nombre != $proyecto->IsFinalizado() && $proyecto->fase->nombre != $proyecto->IsSuspendido())
                @include('proyectos.options.options')
            @else
                @include('proyectos.options.options_end')
            @endif
            @include('proyectos.detalles.detalle_general')
        </div>
        @if (isActiveRoute('proyecto/detalle'))
            <div id="inicio" class="col s12 m12 l12">
                @include('proyectos.detalles.detalle_fase_inicio')
            </div>
            <div id="planeacion" class="col s12 m12 l12">
                @include('proyectos.detalles.detalle_fase_planeacion')
            </div>
            <div id="ejecucion" class="col s12 m12 l12">
                @include('proyectos.detalles.detalle_fase_ejecucion')
            </div>
            <div id="cierre" class="col s12 m12 l12">
                @include('proyectos.detalles.detalle_fase_cierre')
            </div>
            @if ($proyecto->fase->nombre == $proyecto->IsSuspendido())
            <div id="cancelado" class="col s12 m12 l12">
                @include('proyectos.detalles.detalle_fase_suspendido')
            </div>
            @endif
        @endif
        @if (isActiveRoute('proyecto/inicio'))
            @include('proyectos.detalles.detalle_fase_inicio')
        @endif
        @if (isActiveRoute('proyecto/planeacion'))
            @include('proyectos.detalles.prorrogas')
            @include('proyectos.detalles.detalle_fase_planeacion')
        @endif
        @if (isActiveRoute('proyecto/ejecucion'))
            @include('proyectos.detalles.prorrogas')
            @include('proyectos.detalles.detalle_fase_ejecucion')
        @endif
        @if (isActiveRoute('proyecto/cierre'))
            @include('proyectos.detalles.detalle_fase_cierre')
        @endif
    </div>
</div>
<div id="info_asesorias">
    @include('proyectos.detalles.detalle_asesorias')
</div>
<div id="info_idea">
    @include('ideas.detalle', ['idea' => $proyecto->idea])
</div>
<div id="info_trazabilidad">
    @include('proyectos.detalles.trazabilidad')
</div>
