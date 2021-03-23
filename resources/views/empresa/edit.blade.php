@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <h5>
            <a class="footer-text left-align" href="{{route('empresa')}}">
                <i class="material-icons arrow-l">business_center</i>
            </a> Empresas
            </h5>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <br>
                    <center>
                    <span class="card-title center-align">Modifcar Empresa - Red Tecnoparque</span>
                    </center>
                    <div class="divider"></div>
                    <form id="formEditCompany" action="{{ route('empresa.update', $empresa->id)}}" method="POST" onsubmit="return checkSubmit()">
                    {!! method_field('PUT')!!}
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="txtnit_empresa" id="txtnit_empresa" value="{{old('txtnit_empresa', $empresa->nit)}}">
                            <label for="txtnit_empresa">Nit de la Empresa (Sin puntos ni dígito de verificación) <span class="red-text">*</span></label>
                            <small id="txtnit_empresa-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m5 l5">
                            <input type="text" name="txtcodigo_ciiu_empresa" id="txtcodigo_ciiu_empresa" value="{{old('txtcodigo_ciiu_empresa', $empresa->codigo_ciiu)}}">
                            <label for="txtcodigo_ciiu_empresa">Código CIIU de la Empresa</label>
                            <small id="txtcodigo_ciiu_empresa-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s1 m1 l1">
                            <a href="https://www.ccb.org.co/Inscripciones-y-renovaciones/Todo-sobre-el-Codigo-CIIU" target="_blank"><i class="material-icons left">help</i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4 l4">
                            <input type="text" name="txtnombre_empresa" id="txtnombre_empresa" value="{{old('txtnombre_empresa', $empresa->entidad->nombre)}}">
                            <label for="txtnombre_empresa">Nombre de la Empresa <span class="red-text">*</span></label>
                            <small id="txtnombre_empresa-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <input type="text" name="txtfecha_creacion_empresa" id="txtfecha_creacion_empresa" value="{{old('txtfecha_creacion_empresa', $empresa->fecha_creacion)}}" class="datepicker picker__input">
                            <label for="txtfecha_creacion_empresa">Fecha de creación de la empresa</label>
                            <small id="txtfecha_creacion_empresa-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m4 l4">
                            <select  id="txtsector_empresa" name="txtsector_empresa" style="width: 100%" tabindex="-1">
                            <option>Seleccione el sector</option>
                            @foreach($sectores as $value)
                                @if(isset($empresa->sector))
                                    <option value="{{$value->id}}" {{old('txtsector_empresa',$empresa->sector->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                @else
                                    <option value="{{$value->id}}" {{old('txtsector_empresa') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                @endif
                            @endforeach                            
                            </select>
                            <label for="txtsector_empresa">Sector de la Empresa <span class="red-text">*</span></label>
                            <small id="txtsector_empresa-error" class="error red-text"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="txtemail_entidad" id="txtemail_entidad" value="{{old('txtemail_entidad', $empresa->entidad->email_entidad)}}">
                            <label for="txtemail_entidad">Email de la Empresa</label>
                            <small id="txtemail_entidad-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input type="text" name="txtdireccion_empresa" id="txtdireccion_empresa" value="{{old('txtdireccion_empresa', $empresa->direccion)}}">
                            <label for="txtdireccion_empresa">Dirección de la Empresa</label>
                            <small id="txtdireccion_empresa-error" class="error red-text"></small>
                            </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                        <select class="js-states browser-default select2" id="txtdepartamento_empresa" name="txtdepartamento_empresa" onchange="EmpresaCreate.getCiudad()" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione el departamento</option>
                            @foreach($departamentos as $value)
                                @if(isset($empresa->entidad->ciudad->departamento))
                                    <option value="{{$value->id}}" {{old('txtdepartamento_empresa',$empresa->entidad->ciudad->departamento->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                @else
                                    <option value="{{$value->id}}" {{old('txtdepartamento_empresa') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                @endif
                            @endforeach
                        </select>
                        <label class="active" for="txtdepartamento_empresa">Departamento de la Empresa <span class="red-text">*</span></label>
                        <small id="txtdepartamento_empresa-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m6 l6">
                        <select class="js-states browser-default select2" id="txtciudad_id_empresa" name="txtciudad_id_empresa" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione Primero el Departamento</option>
                        </select>
                        <label class="active" for="txtciudad_id_empresa">Ciudad de la Empresa <span class="red-text">*</span></label>
                        <small id="txtciudad_id_empresa-error" class="error red-text"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6 l6">
                        <select class="" id="txttamanhoempresa_id_empresa" name="txttamanhoempresa_id_empresa" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione el tamaño de la empresa</option>
                            @foreach($tamanhos as $value)
                                @if(isset($empresa->tamanhoempresa))
                                    <option value="{{$value->id}}" {{old('txttamanhoempresa_id_empresa',$empresa->tamanhoempresa->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                @else
                                    <option value="{{$value->id}}" {{old('txttamanhoempresa_id_empresa') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                @endif
                            @endforeach
                        </select>
                        <label for="txttamanhoempresa_id_empresa">Tamaño de la Empresa <span class="red-text">*</span></label>
                        <small id="txttamanhoempresa_id_empresa-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m6 l6">
                        <select class="" id="txttipoempresa_id_empresa" name="txttipoempresa_id_empresa" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione el tipo de la empresa</option>
                            @foreach($tipos as $value)
                                @if(isset($empresa->tipoempresa))
                                    <option value="{{$value->id}}" {{old('txttipoempresa_id_empresa',$empresa->tipoempresa->id) ==  $value->id ? 'selected':''}}>{{$value->nombre}}</option> 
                                @else
                                    <option value="{{$value->id}}" {{old('txttipoempresa_id_empresa') == $value->id  ? 'selected':''}}>{{$value->nombre}}</option> 
                                @endif
                            @endforeach
                        </select>
                        <label for="txttipoempresa_id_empresa">Tipo de Empresa <span class="red-text">*</span></label>
                        <small id="txttipoempresa_id_empresa-error" class="error red-text"></small>
                        </div>
                    </div>
                    <center>
                        <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
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
        $('#txtdepartamento_empresa').val({{old('txtdepartamento')}});
        $('#txtdepartamento_empresa').select2();
        @endif
        EmpresaEdit.getCiudad();
    });

    var EmpresaEdit = {
        getCiudad: function() {
        let id;
        id = $('#txtdepartamento_empresa').val();
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: '/usuario/getciudad/' + id
        }).done(function(response) {
            $('#txtciudad_id_empresa').empty();
            $('#txtciudad_id_empresa').append('<option value="">Seleccione la Ciudad</option>')
            $.each(response.ciudades, function(i, e) {
            // console.log(e.id);
            $('#txtciudad_id_empresa').append('<option  value="' + e.id + '">' + e.nombre + '</option>');
            })
            @if($errors->any())
            $('#txtciudad_id_empresa').val({{old('txtciudad_id_empresa')}});
            @else
            $('#txtciudad_id_empresa').val({{$empresa->entidad->ciudad->id}});
            @endif
            $('#txtciudad_id_empresa').select2();
        });
        },
    }
</script>
@endpush
