<div class="row card card-panel teal lighten-5">
    <h6>Recordar que se están mostrando las metas del año actual.</h6>
    <table class="responsive-table striped">
        <thead>
          <tr>
              <th>Tecnoparque</th>
              <th>Meta de PBTs finalizados</th>
              <th>Articulaciones</th>
              <th>Meta de TRL6</th>
              <th>Meta de TRL7 y TRL8</th>
              <th>Progreso PBTs del nodo</th>
          </tr>
        </thead>

        <tbody>
            @foreach ($metas as $meta)
                <tr>
                    <td>{{$meta->nodo->entidad->nombre}}</td>
                    <td>{{$meta->trl6 + $meta->trl7_trl8}}</td>
                    <td>{{$meta->articulaciones}}</td>
                    <td>{{$meta->trl6}}</td>
                    <td>{{$meta->trl7_trl8}}</td>
                    <td>{{$meta->nodo->ProyectosFinalizadosTrl6('2021', $meta->nodo_id)->count()}}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
</div>
