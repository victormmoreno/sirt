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
                <span class="card-title center-align"><b>Nueva Idea de Proyecto - {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="card-panel red lighten-3">
                <div class="card-content white-text">
                  <a class="btn-floating red"><i class="material-icons left">info_outline</i></a>
                  <span>Los elementos con (*) son obligatorios</span>
                </div>
              </div>
              <br/>
              <form id="frmIdea_Inicio" action="{{ route('idea.store') }}" method="POST">
              @include('ideas.talento.form_inicio', [
              'btnText' => 'Guardar'])
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
      });
    </script>
@endpush
