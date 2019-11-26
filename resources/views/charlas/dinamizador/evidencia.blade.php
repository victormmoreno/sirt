@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('meta-content', 'Charlas Informativas')
@section('meta-keywords', 'Charlas Informativas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <h5>
          <a class="footer-text left-align" href="{{route('charla')}}">
            <i class="left material-icons">arrow_back</i>
          </a> Charlas Informativas
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                @include('charlas.infocenter.form_evidencias')
                <center>
                  <a href="{{route('charla')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                </center>
              </div>
            </div>
            @include('charlas.table_evidencias')
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script>
  datatableArchivosDeUnaCharlaInformatva();
  function datatableArchivosDeUnaCharlaInformatva() {
    $('#archivosDeUnaCharlaInformartiva').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: false,
      ajax:{
        url: "{{route('charla.files', $charla->id)}}",
        type: "get",
      },
      columns: [
        { data: 'file', name: 'file', orderable: false },
        { data: 'download', name: 'download', orderable: false }
      ],
    });
  }
</script>
@endpush
