@extends('layouts.app')
@section('meta-title', 'Novedad - ' . $publicacion->codigo_publicacion)

@section('content')

  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <div class="row">
            <div class="col s12 m6 l6">
              <h5 class="left-align hand-of-Sean-fonts orange-text text-darken-3">
                Novedad - {{$publicacion->titulo}}
              </h5>
            </div>
          </div>
          <div class="row">
            <div class="col s12 m12 l12">
              <div class="card mailbox-content">
                <div class="card-content">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
