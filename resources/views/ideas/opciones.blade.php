@can('postularIdea', $idea)
    <a class="collection-item" href="!#" onclick="confirmacionPostulacion(event)">
        <form action="{{route('idea.enviar', $idea->id)}}" method="POST" id="frmPostularIdea" name="frmPostularIdea">
            {!! method_field('PUT')!!}
            <input type="hidden" value="{{$idea}}" name="txtidea_id">
            @csrf
            <i class="material-icons left">assignment_turned_in</i>
            Postular proyecto al nodo {{$idea->nodo->entidad->nombre}}.
        </form>
    </a>
@endcan
@can('aprobar', $idea)
<a href="!#" class="collection-item" onclick="confirmacionAceptacionPostulacion(event)">
  <form action="{{route('idea.aceptar.postulacion', $idea->id)}}" method="POST" name="frmAceptarPostulacionIdea">
    {!! method_field('PUT')!!}
    @csrf
    <input type="hidden" name="txtobservacionesAceptacion" id="txtobservacionesAceptacion" value="">
    <i class="material-icons left">done</i>
    Aceptar idea de proyecto
  </form>
</a>
<a href="!#" class="collection-item" onclick="confirmacionRechazoPostulacion(event)">
  <form action="{{route('idea.rechazar.postulacion', $idea->id)}}" method="POST" name="frmRechazarPostulacionIdea">
    {!! method_field('PUT')!!}
    @csrf
    <input type="hidden" name="txtmotivosRechazo" id="txtmotivosRechazo" value="">
    <i class="material-icons left">close</i>
    Devolver idea de proyecto
  </form>
</a>
@endcan
@can('update', $idea)
    <a href="{{route('idea.edit', $idea->id)}}" class="collection-item">
        <i class="material-icons left">edit</i>
        Cambiar información de la idea.
    </a>
@endcan
@can('duplicar', $idea)
    <a href="!#" class="collection-item" onclick="confirmacionDuplicacion(event)">
      <form action="{{route('idea.duplicar', $idea->id)}}" method="POST" id="frmDuplicarIdea" name="frmDuplicarIdea">
        {!! method_field('PUT')!!}
        @csrf
        <input type="hidden" value="{{$idea}}" name="txtidea_id">
        <i class="material-icons left">add_box</i>
        Duplicar idea de proyecto.
      </form>
    </a>
@endcan
@can('asignar', $idea)
  <a href="{{route('idea.asignar', $idea->id)}}" class="collection-item">
    <i class="material-icons left">edit</i>
    Asignar experto a la idea.
  </a>
@endcan
@can('inhabilitar', $idea)
  <a class="collection-item" href="!#" onclick="confirmacionInhabilitar(event)">
    <form action="{{route('idea.inhabilitar', $idea->id)}}" method="POST" id="frmInhabilitarIdea" name="frmInhabilitarIdea">
      {!! method_field('PUT')!!}
      <input type="hidden" value="{{$idea}}" name="txtidea_id">
      @csrf
      <i class="material-icons left">delete_sweep</i>
      Inhabilitar idea de proyecto.
    </form>
  </a>
@endcan