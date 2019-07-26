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
                    <div class="col s12 m12 l12">
                      <div class="center-align">
                        <span class="card-title center-align">Visitantes de Red Tecnoparque</span>
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
      </div>
    </div>
  </main>
@endsection
@push('script')
  <script type="text/javascript">
  $(document).ready(function() {
    datatableVisitantesPorNodo_DinamizadorAdministrador();
  });
</script>
@endpush
