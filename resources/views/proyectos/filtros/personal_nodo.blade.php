<div class="row">
  <div class="col s12 m12 l12">
    <ul class="tabs" style="width: 100%;">
      <li class="tab col s3"><a href="#proyectos_por_nodo" class="active">Proyectos del nodo</a></li>
      <li class="tab col s3"><a class="" href="#proyectos_por_gestor">Proyectos por experto</a></li>
      <div class="indicator" style="right: 580.5px; left: 0px;"></div>
    </ul>
    <br>
  </div>
</div>
<div id="proyectos_por_nodo">
  <div class="row">
    <div class="col s12 m12 l12">
      <div class="input-field col s12 m12 l12">
        <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorNodoYAnho" name="anho_proyectoPorNodoYAnho" onchange="consultarProyectosUnNodoPorAnho();">
          {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
          @for ($i=2016; $i <= $year; $i++)
            <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
          @endfor
        </select>
        <label for="anho_proyectoPorNodoYAnho">Seleccione el Año</label>
      </div>
    </div>
  </div>
</div>
<div id="proyectos_por_gestor">
  <span>
    Para consultar los proyectos de un gestor, debes seleccionar el año (de la fecha de cierre de los proyectos), luego un gestor del nodo y por último presionar el
    botón <b>"Consultar proyectos"</b>.
  </span>
  <br><br>
  <div class="row">
    <div class="input-field col s12 m6 l6">
      <select class="js-states"  tabindex="-1" style="width: 100%" id="anho_proyectoPorAnhoGestorNodo" name="anho_proyectoPorAnhoGestorNodo">
        {!! $year = Carbon\Carbon::now(); $year = $year->isoFormat('YYYY'); !!}
        @for ($i=2016; $i <= $year; $i++)
          <option value="{{$i}}" {{ $i == Carbon\Carbon::now()->isoFormat('YYYY') ? 'selected' : '' }}>{{$i}}</option>
        @endfor
      </select>
      <label for="anho_proyectoPorAnhoGestorNodo">Seleccione el Año</label>
    </div>
    <div class="input-field col s12 m6 l6">
      <select id="txtgestor_id" name="txtgestor_id" style="width: 100%" tabindex="-1">
        @foreach($gestores as $id => $experto)
          <option value="{{$experto->id}}">{{$experto->nombres}} {{$experto->apellidos}}</option>
        @endforeach
      </select>
      <label for="txtgestor_id">Experto</label>
    </div>
  </div>
  <div class="row center">
    <div class="col s12 m4 l4 offset-l4">
        <a onclick="consulta();" href="javascript:void(0)">
        <div class="card bg-secondary white-text">
            <div class="card-content center flow-text">
            <i class="left material-icons white-text small">search</i>
            <span class="white-text">Consultar Proyectos</span>
            </div>
        </div>
        </a>
    </div>
</div>

</div>
@include('proyectos.table')
@push('script')
    <script>
    function consulta() {
      let anho = $('#anho_proyectoPorAnhoGestorNodo').val();
      let gestor = $('#txtgestor_id').val();
      if (gestor == "") {
        Swal.fire({
          title: 'Error!',
          text: "Debes seleccionar un experto!",
          type: 'warning',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok'
        })
      } else {
        $('#tblProyectos_Master').dataTable().fnDestroy();
        $('#tblProyectos_Master').DataTable({
          language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          "lengthChange": false,
          ajax:{
          url: host_url + "/proyecto/datatableProyectosDelGestorPorAnho/"+gestor+"/"+anho,
          data: function (d) {
              d.codigo_proyecto = $('#codigo_proyecto_tblProyectos_Master').val(),
              d.gestor = $('#gestor_tblProyectos_Master').val(),
              d.nombre = $('#nombre_tblProyectos_Master').val(),
              d.sublinea_nombre = $('#sublinea_nombre_tblProyectos_Master').val(),
              d.nombre_fase = $('#estado_nombre_tblProyectos_Master').val(),
              d.search = $('input[type="search"]').val()
            }
            },
            columns: [
            {
                width: '15%',
                data: 'codigo_proyecto',
                name: 'codigo_proyecto',
            },
            {
                data: 'gestor',
                name: 'gestor',
            },
            {
                data: 'nombre',
                name: 'nombre',
            },
            {
                data: 'sublinea_nombre',
                name: 'sublinea_nombre',
            },
            {
                data: 'nombre_fase',
                name: 'nombre_fase',
            },
            {
                width: '8%',
                data: 'info',
                name: 'info',
                orderable: false
            },
            {
                width: '8%',
                data: 'proceso',
                name: 'proceso',
                orderable: false
            },
            ],
        });
      }
    }
    </script>
@endpush