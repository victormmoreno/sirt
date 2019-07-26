@extends('layouts.app')
@section('meta-title', 'Visitantes')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>Visitantes</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m12 l10">
                      <div class="center-align">
                        <span class="card-title center-align">Visitantes de Red Tecnoparque</span>
                      </div>
                    </div>
                    <div class="col s12  l2">
                      <div class="click-to-toggle show-on-large hide-on-med-and-down">
                        <a href="{{route('visitante.create')}}" class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Visitante">
                          <i class="material-icons">supervisor_account</i>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  @include('visitante.table')
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
          <a href="{{route('visitante.create')}}" class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nuevo Visitante">
            <i class="material-icons">supervisor_account</i>
          </a>
        </div>
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script type="text/javascript">
  $(document).ready(function() {
    datatableVisitantesPorNodo_Ingreso();
  });
</script>
@endpush
