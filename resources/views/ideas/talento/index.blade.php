@extends('layouts.app')
@section('meta-title', 'Ideas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
              <div class="col s8 m8 l9">
                  <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                      <i class="material-icons left">
                          lightbulb
                      </i>
                      Ideas de Proyecto
                  </h5>
              </div>
              <div class="col s4 m4 l3 rigth-align">
                  <ol class="breadcrumbs">
                      <li><a href="{{route('home')}}">Inicio</a></li>
                      <li class="active">Ideas de Proyecto</li>
                  </ol>
              </div>
          </div>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m8 l8">
                    <div class="center-align hand-of-Sean-fonts orange-text text-darken-3">
                      <span class="card-title center-align">Tus ideas de proyectos</span>
                    </div>
                  </div>
                  <div class="col s12 m4 l4">
                    <a href="{{ route('idea.create') }}" class="waves-effect waves-grey light-green btn-flat right"><i class="material-icons left">add</i> Nueva Idea de Proyecto</a>
                  </div>
                </div>
                <div class="divider"></div>
                @include('ideas.table')
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
    consultarIdeasDelTalento();
  </script>
@endpush
