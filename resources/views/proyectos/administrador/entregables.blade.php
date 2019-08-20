@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <h5>
          <a class="footer-text left-align" href="{{ route('proyecto') }}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Proyectos
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                @include('proyectos.form_entregables')
                <center>
                  <a href="{{ route('proyecto') }}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                </center>
                @include('proyectos.archivos_table')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script>
    datatableArchivosDeUnProyecto();
    function datatableArchivosDeUnProyecto() {
      $('#archivosDeUnProyecto').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: false,
        ajax:{
          url: "{{route('proyecto.files', $proyecto->id)}}",
          type: "get",
        },
        columns: [
        {
          data: 'file',
          name: 'file',
          orderable: false,
        },
        {
          data: 'fase',
          name: 'fase',
          orderable: false,
        },
        {
          data: 'download',
          name: 'download',
          orderable: false,
        },
        ],
        // initComplete: function () {
          //   this.api().columns().every(function () {
            //     var column = this;
            //     var input = document.createElement("input");
            //     $(input).appendTo($(column.footer()).empty())
            //     .on('change', function () {
              //       column.search($(this).val(), false, false, true).draw();
              //     });
              //   });
              // }
            });
          }
        </script>
      @endpush
