@extends('layouts.app')
@section('meta-title', 'Charlas Informativas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><a class="footer-text left-align" href="{{route('charla')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Charlas Informativas </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <center><span class="card-title center-align">Modificar Charla Informativa - {{ $charla->codigo_charla }}</span></center>
                <form method="post" id="formCharlaInformativaEdit" action="{{route('charla.update', $charla->id)}}">
                  {!! method_field('PUT')!!}
                  {!! csrf_field() !!}
                  @include('charlas.infocenter.form', [
                    'btnText' => 'Modificar'
                  ])
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
