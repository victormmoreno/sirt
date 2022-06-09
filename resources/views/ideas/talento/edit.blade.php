@extends('layouts.app')
@section('meta-title', 'Ideas de Proyecto')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('idea.index')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Ideas de Proyecto
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <br>
              <center>
                <span class="card-title center-align"><b>Modificar idea de proyecto - {{ $idea->codigo_idea }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="card-panel red lighten-3">
                <div class="card-content white-text">
                  <a class="btn-floating red"><i class="material-icons left">info_outline</i></a>
                  <span>Los elementos con (*) son obligatorios</span>
                </div>
              </div>
              <br/>
              <form id="frmIdea_Update" name="frmIdea_Update" action="{{ route('idea.update', $idea) }}" method="POST">
                {!! method_field('PUT')!!}
              @include('ideas.talento.form_inicio', [
              'btnText' => 'Modificar'])
              <div class="divider"></div>
                <center>
                  <button type="submit" class="waves-effect cyan darken-1 btn center-aling" onclick="modalOpcionesFormularioModificar(event)">
                    <i class="material-icons right">done_all</i>
                      Modificar
                  </button>
                  <a href="{{route('idea.index')}}" class="waves-effect red lighten-2 btn center-aling">
                    <i class="material-icons right">backspace</i>Cancelar
                  </a>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('ideas.modals')
</main>
@endsection
@push('script')
    <script>
      $(document).ready(function () {
        $('#modalRecordatorioDeRegistroDeIdea').openModal();
        @if($idea->sede_id != null)
        consultarEmpresaTecnoparque();
        asociarSedeAIdeaProyecto({{$idea->sede_id}});
        @endif
      });
      function getCiudadSede() {
        let id;
        id = $('#txtdepartamento_sede').val();
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: host_url + '/usuario/getciudad/' + id
        }).done(function(response) {
            $('#txtciudad_id_sede').empty();
            $('#txtciudad_id_sede').append('<option value="">Seleccione la Ciudad</option>')
            $.each(response.ciudades, function(i, e) {
                $('#txtciudad_id_sede').append('<option value="' + e.id + '">' + e.nombre + '</option>');
            })
            $('#txtciudad_id_sede').material_select();
            });
        }
    </script>
@endpush