@extends('layouts.app')
@section('meta-title', 'Caracterización')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="material-icons left">bookmark</i>Caracterización</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m8 l8">
                      <div class="center-align">
                        <span class="card-title center-align">Caracterización de Tecnoparque</span>
                      </div>
                    </div>
                    @can('create', App\Models\Tag::class)
                      <div class="col s12 m4 l4">
                        <a href="{{route('tag.create')}}" class="waves-effect waves-grey bg-secondary white-text btn-flat search-tabs-button right show-on-large hide-on-med-and-down">Nueva etiqueta</a>
                      </div>
                    @endcan
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="input-field col m12 l12 s12">
                        <select style="width: 100%" class="js-states" id="selectType" name="selectType" onchange="consultarTags(this.value)">
                            <option value="">Seleccione el tipo de caracterización</option>
                            @forelse ($types as $id => $type)
                            <option value="{{$type}}">{{class_basename($type)}}</option>
                            @empty
                            <option value="">No hay información disponible</option>
                            @endforelse
                        </select>
                    </div>
                  </div>
                  @include('tags.table')
                </div>
              </div>
            </div>
          </div>
        </div>
        @can('create', App\Models\Tag::class)
          <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
            <a href="{{route('tag.create')}}"  class="btn tooltipped btn-floating btn-large green" data-position="left" data-delay="50" data-tooltip="Nueva etiqueta">
              <i class="material-icons">markbook</i>
            </a>
          </div>
        @endcan
      </div>
    </div>
  </main>
@endsection
@push('script')
<script>
  function consultarTags(value) {
      let type = value;
      consultarTagsTecnoparque(type);
  }
</script>
@endpush
