<li class="no-padding {{setActiveRoute('proyecto')}}">
  <a href="{{route('proyecto')}}" class="waves-effect waves-grey {{setActiveRouteActivePage('proyecto')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('proyecto') }}">library_books</i>Proyectos de Base Tecnológica
  </a>
</li>

<li class="no-padding {{setActiveRoute('articulacion')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('articulacion')}}" href="{{route('articulacion')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('articulacion') }}">autorenew</i>Articulaciones
  </a>
</li>
<li class="{!! setActiveRoute('edt') !!}">
  <a class="waves-effect waves-grey {!! setActiveRouteActivePage('edt') !!}" href="{{route('edt')}}">
  <i class="material-icons {!! setActiveRouteActiveIcon('edt') !!}">record_voice_over</i>EDT's
  </a>
</li>
{{-- <li class="no-padding">
  <a href="" class="waves-effect waves-grey">
    <i class="material-icons">supervisor_account</i>Talentos
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">domain</i>Uso de Infraestructura
  </a>
</li> --}}
<li class="no-padding {{setActiveRoute('empresa')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('empresa') }}">business_center</i>Empresas
  </a>
</li>
<li class="no-padding {{setActiveRoute('grupo')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('grupo')}}" href="{{route('grupo')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('grupo')}}">group_work</i>Grupos de Investigación
  </a>
</li>
<li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">attach_money</i>Costos
  </a>
</li>
<li class="no-padding">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('idea')}}" href="{{route('idea.ideas')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('idea') }}">lightbulb</i>Ideas
  </a>
</li>
<li class="no-padding">
  <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}} {{setActiveRouteActivePage('csibt/create')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('csibt')}} {{setActiveRouteActiveIcon('csibt/create')}}">gavel</i>CSIBT's
  </a>
</li>
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">search</i>Seguimiento
  </a>
</li> --}}
{{-- <li class="no-padding">
  <a class="waves-effect waves-grey" href="">
    <i class="material-icons">description</i>Reportes
  </a>
</li> --}}
