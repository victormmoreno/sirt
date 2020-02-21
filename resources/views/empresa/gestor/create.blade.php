@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('empresa')}}">
            <i class="left material-icons">arrow_back</i>
          </a> Empresas
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <br>
                <center>
                  <span class="card-title center-align">Nueva Empresa - Red Tecnoparque</span>
                </center>
                <div class="divider"></div>
                <form action="{{route('empresa.store')}}" method="POST" onsubmit="return checkSubmit()">
                  {!! csrf_field() !!}
                  @if($errors->any())
                  <div class="card red lighten-3">
                    <div class="row">
                      <div class="col s12 m12">
                        <div class="card-content white-text">
                          <p><i class="material-icons left"> info_outline</i> Los datos marcados con * son obligatorios</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="nit" id="nit" value="{{ old('nit') }}">
                      <label for="nit">Nit de la Empresa (Sin puntos ni dígito de verificación) <span class="red-text">*</span></label>
                      @error('nit')
                      <label id="nit-error" class="error" for="nit">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="codigo_ciiu" id="codigo_ciiu" value="{{ old('codigo_ciiu') }}">
                      <label for="codigo_ciiu">Código CIIU de la Empresa</label>
                      @error('codigo_ciiu')
                      <label id="codigo_ciiu-error" class="error" for="codigo_ciiu">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m4 l4">
                      <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}">
                      <label for="nombre">Nombre de la Empresa <span class="red-text">*</span></label>
                      @error('nombre')
                      <label id="nombre-error" class="error" for="nombre">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m4 l4">
                      <input type="text" name="fecha_creacion" id="fecha_creacion" value="{{ old('fecha_creacion') }}" class="datepicker picker__input">
                      <label for="fecha_creacion">Fecha de creación de la empresa</label>
                      @error('fecha_creacion')
                      <label id="fecha_creacion-error" class="error" for="fecha_creacion">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m4 l4">
                      <select class="" id="txtsector" name="txtsector" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione el sector</option>
                        @foreach($sectores as $value)
                        <option value="{{$value->id}}" {{ old('txtsector') == $value->id ? 'selected':'' }}>{{$value->nombre}}</option>
                        @endforeach
                      </select>
                      <label for="txtsector">Sector de la Empresa <span class="red-text">*</span></label>
                      @error('txtsector')
                      <label id="txtsector-error" class="error" for="txtsector">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="email_entidad" id="email_entidad" value="{{ old('email_entidad') }}">
                      <label for="email_entidad">Email de la Empresa</label>
                      @error('email_entidad')
                      <label id="email_entidad-error" class="error" for="email_entidad">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}">
                      <label for="direccion">Dirección de la Empresa</label>
                      @error('direccion')
                      <label id="direccion-error" class="error" for="direccion">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select class="js-states browser-default select2" id="txtdepartamento" name="txtdepartamento" onchange="EmpresaCreate.getCiudad()" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione el departamento</option>
                        @foreach($departamentos as $value)
                        <option value="{{$value->id}}" {{ old('txtdepartamento') == $value->id ? 'selected':'' }}>{{$value->nombre}}</option>
                        @endforeach
                      </select>
                      <label class="active" for="txtdepartamento">Departamento de la Empresa <span class="red-text">*</span></label>
                      @error('txtdepartamento')
                      <label id="txtdepartamento-error" class="error" for="txtdepartamento">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select class="js-states browser-default select2" id="txtciudad_id" name="txtciudad_id" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Primero el Departamento</option>
                      </select>
                      <label class="active" for="txtciudad_id">Ciudad de la Empresa <span class="red-text">*</span></label>
                      @error('txtciudad_id')
                      <label id="txtciudad_id-error" class="error" for="txtciudad_id">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select class="" id="txttamanhoempresa_id" name="txttamanhoempresa_id" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione el tamaño de la empresa</option>
                        @foreach($tamanhos as $value)
                        <option value="{{$value->id}}" {{ old('txttamanhoempresa_id') == $value->id ? 'selected':'' }}>{{$value->nombre}}</option>
                        @endforeach
                      </select>
                      <label for="txttamanhoempresa_id">Tamaño de la Empresa <span class="red-text">*</span></label>
                      @error('txttamanhoempresa_id')
                      <label id="txttamanhoempresa_id-error" class="error" for="txttamanhoempresa_id">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select class="" id="txttipoempresa_id" name="txttipoempresa_id" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione el tipo de la empresa</option>
                        @foreach($tipos as $value)
                        <option value="{{$value->id}}" {{ old('txttipoempresa_id') == $value->id ? 'selected':'' }}>{{$value->nombre}}</option>
                        @endforeach
                      </select>
                      <label for="txttipoempresa_id">Tipo de Empresa <span class="red-text">*</span></label>
                      @error('txttipoempresa_id')
                      <label id="txttipoempresa_id-error" class="error" for="txttipoempresa_id">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                    <a href="{{route('empresa')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                  </center>
                </form>
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
  $(document).ready(function() {
    @if($errors->any())
    EmpresaCreate.getCiudad();
    @endif
  });

  var EmpresaCreate = {
    getCiudad: function() {
      let id;
      id = $('#txtdepartamento').val();
      $.ajax({
        dataType: 'json',
        type: 'get',
        url: '/usuario/getciudad/' + id
      }).done(function(response) {
        $('#txtciudad_id').empty();
        $('#txtciudad_id').append('<option value="">Seleccione la Ciudad</option>')
        $.each(response.ciudades, function(i, e) {
          // console.log(e.id);
          $('#txtciudad_id').append('<option  value="' + e.id + '">' + e.nombre + '</option>');
        })
        @if($errors->any())
        $('#txtciudad_id').val({
          {
            old('txtciudad_id')
          }
        });
        @endif
        $('#txtciudad_id').material_select();
      });
    },
  }
</script>
@endpush