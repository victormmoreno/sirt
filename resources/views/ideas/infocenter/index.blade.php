@extends('layouts.app')

@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <div class="row">
          <div class="col s10 m10 l10">
            <h5 class="left-align">
              <i class="material-icons left">
                lightbulb
              </i>
              Ideas
            </h5>
          </div>
        </div>
        <div class="card ">
          <div class="card-content">
            <div class="row">
              <div class="row">
                <div class="col s12 m12 l10">
                  <div class="center-align">
                    <span class="card-title center-align">
                      Ideas Tecnoparque nodo 
                    </span>
                  </div>
                </div>
                <div class="col s12 l2">
                  <div class="click-to-toggle show-on-large hide-on-med-and-down">
                    <a class="btnregister btn btn-floating btn-large tooltipped green" data-delay="50" data-position="button" data-tooltip="Nueva Linea" href="{{route('lineas.create')}}">
                      <i class="material-icons">
                        dns
                      </i>
                    </a>
                    {{-- <a href="{{route('lineas.create')}}" class="waves-effect green btn"><i class="material-icons right">dns</i>Nueva Linea</a> --}}
                  </div>
                </div>
              </div>
              <div class="divider">
              </div>
              <br>
              <table class="display responsive-table" id="linea_table">
                <thead>
                  <th width="15%">Abreviatura</th>
                  <th width="30%">Linea</th>
                  <th width="40%">Descripcion</th>
                  <th width="15%">Editar</th>
                </thead>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
