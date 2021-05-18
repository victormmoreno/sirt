<li class="no-padding {{setActiveRoute('idea')}}">
    <a href="{{route('idea.index')}} " class="{{setActiveRouteActivePage('idea')}}" rel="canonical" title="Ideas">
      <i class="material-icons {{setActiveRouteActiveIcon('idea')}}">lightbulb</i>Ideas
    </a>
</li>
<li class="no-padding {{setActiveRoute('entrenamientos')}}">
    <a href="{{route('entrenamientos')}}" class="{{setActiveRouteActivePage('entrenamientos')}}" rel="canonical" title="Taller de Fortalecimiento">
      <i class="material-icons {{setActiveRouteActiveIcon('entrenamientos')}}">library_books</i>Taller de Fortalecimiento
    </a>
</li>
<li class="no-padding {{setActiveRoute('charla')}}">
  <a href="{{route('charla')}}" class="{{setActiveRouteActivePage('charla')}}" rel="canonical" title="Charlas Informativas">
    <i class="material-icons {{setActiveRouteActiveIcon('charla')}}">record_voice_over</i>Charlas Informativas
  </a>
</li>
<li class="no-padding {{setActiveRoute('empresa')}}">
  <a class="waves-effect waves-grey {{setActiveRouteActivePage('empresa')}}" href="{{route('empresa')}}" rel="canonical" title="Empresas">
    <i class="material-icons {{ setActiveRouteActiveIcon('empresa') }}">business_center</i>Empresas
  </a>
</li>