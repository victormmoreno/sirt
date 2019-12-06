@extends('layouts.app')
@section('meta-title', 'Publicaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><i class="left material-icons">event</i>Publicaciones</h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m10 l10">
                      <div class="center-align">
                        <span class="card-title center-align">Publicaciones de Tecnoparque</span>
                      </div>
                    </div>
                    <div class="col s12 m2 l2">
                      <a href="{{ route('publicacion.create') }}">
                        <div class="card green">
                          <div class="card-content center">
                            <i class="left material-icons white-text">add</i>
                            <span class="white-text">Nueva Publicación</span>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    @include('publicaciones.table', [
                      'id' => 'tblnovedades_Desarrollador',
                      'rol' => \Session::get('login_role')
                    ])
                    {{-- <div class="right material-icons">
                      <a onclick="generarExcelDeProyectosDelGestorPorAnho()">
                        <img class="btn btn-flat" src="https://img.icons8.com/color/48/000000/ms-excel.png">
                      </a>
                    </div> --}}
                    {{-- @include('proyectos.table') --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('proyectos.modals')
  </main>
@endsection
@push('script')
  <script>
  function updateEstadoPublicacion(id, estado, e) {
    let msg = '';
    if (estado == 1) {
      msg = '¿Estás seguro de habilitar esta publicación?';
    } else {
      msg = '¿Estás seguro de inhabilitar esta publicación?';
    }

    Swal.fire({
      title: msg,
      // text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Sí!'
    }).then((result) => {
      if (result.value) {
        modificarPublicacion(id, estado, e);
      }
    })

  }

  function modificarPublicacion(id, estado, e) {
    $.ajax({
      dataType:'json',
      type:'get',
      url:"/publicacion/updateEstado/"+id+"/"+estado,
      success: function (data) {
        console.log(data);
        let msg = '';
        let type = '';
        if (data) {
          msg = 'El estado de la publicación se ha cambiado!';
          type = 'success';
        } else {
          msg = 'El estado de la publicación no se ha cambiado!';
          type = 'error';
        }
        Swal.fire({
          title: msg,
          type: type,
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Ok!'
        })
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      }
    })
  }
  </script>
@endpush
