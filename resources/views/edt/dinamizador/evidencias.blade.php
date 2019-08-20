@extends('layouts.app')
@section('meta-title', 'Eventos de Divulgación Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <h5>
          <a class="footer-text left-align" href="{{route('edt')}}">
            <i class="left material-icons">arrow_back</i>
          </a> Edt
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <form onsubmit="return checkSubmit()" method="post" action="{{ route('edt.update.evidencias', $edt->id) }}">
                  {!! method_field('PUT')!!}
                  {!! csrf_field() !!}
                  @include('edt.gestor.form_entregables')
                  <center>
                    <a href="{{route('edt')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                  </center>
                </form>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <ul class="collapsible" data-collapsible="accordion">
                      <li>
                        <div class="collapsible-header teal lighten-4"><i class="material-icons">filter_drama</i>Pulse aquí para ver las evidencias de la Edt</div>
                        <div class="collapsible-body">
                          <div class="row">
                            <div class="col s12 m12 l12">
                              <table class="display responsive-table datatable-example dataTable" style="width: 100%" id="archivosDeUnaEdt">
                                <thead>
                                  <tr>
                                    <th>Archivo</th>
                                    <th style="width: 10%">Descargar</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
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
  datatableArchivosDeUnaEdt();
  function datatableArchivosDeUnaEdt() {
    $('#archivosDeUnaEdt').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: "{{route('edt.files', $edt->id)}}",
        type: "get",
      },
      columns: [
        {
          data: 'file',
          name: 'file',
          orderable: false,
        },
        {
          data: 'download',
          name: 'download',
          orderable: false,
        },
      ],
    });
  }
</script>
@endpush
