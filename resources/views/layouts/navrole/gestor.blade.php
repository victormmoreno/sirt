<li class="no-padding {{setActiveRoute('usuario')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usuario')}}" href="{{route('usuario.index')}}">
    <i class="material-icons {{ setActiveRouteActiveIcon('usuario') }}">supervised_user_circle</i>Usuarios
  </a>
</li>

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
<li class="no-padding {{setActiveRoute('usoinfraestructura.index')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('usoinfraestructura.index')}}" href="{{route('usoinfraestructura.index')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('usoinfraestructura.index')}}">domain</i>Usos de infraestructura
  </a>
</li>
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
  <a href="{{route('csibt')}}" class="{{setActiveRouteActivePage('csibt')}}">
    <i class="material-icons {{setActiveRouteActiveIcon('csibt')}}">gavel</i>CSIBT's
  </a>
</li>
