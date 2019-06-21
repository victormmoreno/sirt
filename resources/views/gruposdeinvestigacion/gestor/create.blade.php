@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('grupo')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Grupos de Investigación
        </h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <br>
                <center>
                  <span class="card-title center-align">Nuevo Grupos de Investigación - Red Tecnoparque</span>
                </center>
                <div class="divider"></div>
                <form action="{{route('grupo.store')}}" method="POST" onsubmit="return checkSubmit()">
                  {!! csrf_field() !!}
                  @if($errors->any())
                    <div class="card red lighten-3">
                      <div class="row">
                        <div class="col s12 m12">
                          <div class="card-content white-text">
                            <p><i class="material-icons left"> info_outline</i>  Los datos marcados con * son obligatorios</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="txtcodigo_grupo" id="txtcodigo_grupo" value="{{old('txtcodigo_grupo')}}">
                      <label for="txtcodigo_grupo">Código del Grupo de Investigación <span class="red-text">*</span></label>
                      @error('txtcodigo_grupo')
                        <label id="txtcodigo_grupo-error" class="error" for="txtcodigo_grupo">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="txtnombre" id="txtnombre" value="{{old('txtnombre')}}">
                      <label for="txtnombre">Nombre del Grupo de Investigación <span class="red-text">*</span></label>
                      @error('txtnombre')
                        <label id="txtnombre-error" class="error" for="txtnombre">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="txtemail_entidad" id="txtemail_entidad" value="{{old('txtemail_entidad')}}">
                      <label for="txtemail_entidad">Email del Grupo de Investigación</label>
                      @error('txtemail_entidad')
                        <label id="txtemail_entidad-error" class="error" for="txtemail_entidad">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select id="txtclasificacionclociencias_id" name="txtclasificacionclociencias_id">
                        <option value="" >Seleccione la Clasificación de Col Ciencias</option>
                        @foreach($clasificaciones as $key => $value)
                          <option value="{{$value->id}}" {{ old('txtclasificacionclociencias_id') == $value->id ? 'selected':'' }}>{{$value->nombre}}</option>
                        @endforeach
                      </select>
                      <label for="txtclasificacionclociencias_id">Clasificación de Col Ciencias <span class="red-text">*</span></label>
                      @error('txtclasificacionclociencias_id')
                        <label id="txtclasificacionclociencias_id-error" class="error" for="txtclasificacionclociencias_id">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select id="txttipogrupo" name="txttipogrupo">
                        <option value="">Seleccione el Tipo de Grupo de Investigación</option>
                        <option value="0" {{ old('txttipogrupo') == '0' ? 'selected':'' }}>SENA</option>
                        <option value="1" {{ old('txttipogrupo') == '1' ? 'selected':'' }}>Externo</option>
                      </select>
                      <label for="txttipogrupo">Tipo de Grupo de Investigación <span class="red-text">*</span></label>
                      @error('txttipogrupo')
                        <label id="txttipogrupo-error" class="error" for="txttipogrupo">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input type="text" name="txtinstitucion" id="txtinstitucion" value="{{ old('txtinstitucion') }}">
                      <label for="txtinstitucion" id="labelins">Institución a la que pertenece <span class="red-text">*</span></label>
                      @error('txtinstitucion')
                        <label id="txtinstitucion-error" class="error" for="txtinstitucion">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select class="" id="txtdepartamento" name="txtdepartamento" onchange="GrupoInvestigacionCreate.getCiudad()" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione el departamento</option>
                        @foreach($departamentos as $value)
                          <option value="{{$value->id}}" {{ old('txtdepartamento') == $value->id ? 'selected':'' }}>{{$value->nombre}}</option>
                        @endforeach
                      </select>
                      <label for="txtdepartamento">Departamento de la Empresa <span class="red-text">*</span></label>
                      @error('txtdepartamento')
                        <label id="txtdepartamento-error" class="error" for="txtdepartamento">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select class="" id="txtciudad_id" name="txtciudad_id" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Primero el Departamento</option>
                      </select>
                      <label for="txtciudad_id">Ciudad de la Empresa <span class="red-text">*</span></label>
                      @error('txtciudad_id')
                          <label id="txtciudad_id-error" class="error" for="txtciudad_id">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="divider"></div>
                  <center>
                    <i class="material-icons">person</i>
                  </center>
                  <center>
                    <span class="card-title center-align">Datos del Contacto</span>
                  </center>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="input-field col s12 m4 l4">
                      <input type="text" name="txtnombres_contacto" id="txtnombres_contacto" value="{{old('txtnombres_contacto')}}">
                      <label for="txtnombres_contacto">Nombre del Contacto <span class="red-text"></span></label>
                      @error('txtnombres_contacto')
                          <label id="txtnombres_contacto-error" class="error" for="txtnombres_contacto">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m4 l4">
                      <input type="email" name="txtcorreo_contacto" id="txtcorreo_contacto" value="{{old('txtcorreo_contacto')}}">
                      <label for="txtcorreo_contacto">Email del Contacto </label>
                      @error('txtcorreo_contacto')
                          <label id="txtcorreo_contacto-error" class="error" for="txtcorreo_contacto">{{ $message }}</label>
                      @enderror
                    </div>
                    <div class="input-field col s12 m4 l4">
                      <input type="text" name="txttelefono_contacto" id="txttelefono_contacto" value="{{old('txttelefono_contacto')}}">
                      <label for="txttelefono_contacto">Teléfono/Celular del Contacto </label>
                      @error('txttelefono_contacto')
                          <label id="txttelefono_contacto-error" class="error" for="txttelefono_contacto">{{ $message }}</label>
                      @enderror
                    </div>
                  </div>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                    <a href="{{route('grupo')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
    GrupoInvestigacionCreate.getCiudad();
    @endif
  });

  $('#txttipogrupo').change(function () {
    let idtipo = $('#txttipogrupo').val();
    if (idtipo == '' || idtipo == 1) {
      $('#txtinstitucion').val('');
      $('#labelins').removeClass('active')
    } else if (idtipo == 0) {
      $('#txtinstitucion').val('SENA');
      $('#labelins').addClass('active', true)
    }
  });

  var GrupoInvestigacionCreate = {
    getCiudad:function(){
      let id;
      id = $('#txtdepartamento').val();
      $.ajax({
        dataType:'json',
        type:'get',
        url:'/usuario/getciudad/'+id
      }).done(function(response){
        $('#txtciudad_id').empty();
        $('#txtciudad_id').append('<option value="">Seleccione la Ciudad</option>')
        $.each(response.ciudades, function(i, e) {
          // console.log(e.id);
          $('#txtciudad_id').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
        })
        @if($errors->any())
        $('#txtciudad_id').val({{old('txtciudad_id')}});
        @endif
        $('#txtciudad_id').material_select();
      });
    },
  }
  </script>
@endpush
