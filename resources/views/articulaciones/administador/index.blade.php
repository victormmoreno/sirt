@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="material-icons">autorenew</i>Articulaciones</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m10 l10">
                <div class="center-align">
                  <span class="card-title center-align">Articulaciones de Tecnoparque</span>
                </div>
              </div>
            </div>
            <div class="divider"></div>
            @include('articulaciones.table')
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@include('articulaciones.modals')
@endsection
