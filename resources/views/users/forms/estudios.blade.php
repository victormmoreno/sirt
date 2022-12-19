<div class="row">
    <div class="col s12 m12 l12">
        <div class="divider mailbox-divider"></div>
        <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Último estudio y ocupaciones</h5>
        <div class="col m6 vertical-line">
            <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Último estudio</h5>
            <div class="row">
                <div class="input-field col l6 m10 s12 offset-m1">
                    <input class="validate" id="txtinstitucion" name="txtinstitucion" type="text"  value="{{ isset($user->institucion) ? $user->institucion : old('txtinstitucion')}}">
                    <label for="txtinstitucion">Institución <span class="red-text">*</span></label>

                    <small id="txtinstitucion-error" class="error red-text"></small>
                </div>
                <div class="input-field col l6 m10 s12 offset-m1 ">
                    <select class="" id="txtgrado_escolaridad" name="txtgrado_escolaridad" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione grado de escolaridad</option>
                        @foreach($gradosescolaridad as $value)
                            @if(isset($user->gradoescolaridad_id))
                            <option value="{{$value->id}}" {{old('txtgrado_escolaridad',$user->gradoescolaridad_id) ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                            @else
                                <option value="{{$value->id}}" {{old('txtgrado_escolaridad') ==$value->id ? 'selected':''}}>{{$value->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="txtgrado_escolaridad">Grado Escolaridad <span class="red-text">*</span></label>
                    <small id="txtgrado_escolaridad-error" class="error red-text"></small>
                </div>
            </div>
            <div class="row">
                <div class="input-field col l6 m10 s12 offset-m1">
                    <input class="validate" id="txttitulo" name="txttitulo" type="text"  value="{{ isset($user->titulo_obtenido) ? $user->titulo_obtenido : old('txttitulo')}}">
                    <label for="txttitulo">Titulo Obtenido <span class="red-text">*</span></label>
                    <small id="txttitulo-error" class="error red-text"></small>
                </div>
                <div class="input-field col l6 m10 s12 offset-m1">
                    <input class="validate datepicker" id="txtfechaterminacion" name="txtfechaterminacion" type="text" value="{{ isset($user->fecha_terminacion) ? $user->fecha_terminacion->toDateString() : old('txtfechaterminacion')}}">
                    <label for="txtfechaterminacion">Fecha Terminación <span class="red-text">*</span></label>
                    <small id="txtfechaterminacion-error" class="error red-text"></small>
                </div>
            </div>
        </div>
        <div class="col m6 l6">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="text-primarycolor center-align hand-of-Sean-fonts orange-text text-darken-3">Ocupaciones</h5>
                    <div class="row">
                        <div class="input-field col s12 m10 l8 offset-l3 offset-m-1">
                            <select class="js-states browser-default  selectMultipe" id="txtocupaciones" name="txtocupaciones[]" style="width: 100%" tabindex="-1" multiple onchange="user.getOtraOcupacion(this)">
                                @foreach($ocupaciones as $id => $nombre)
                                @if(isset($user))
                                <option value="{{$id}}" {{collect(old('txtocupaciones',$user->ocupaciones->pluck('id')))->contains($id) ? 'selected' : ''  }} >{{$nombre}}</option>
                                @else
                                    <option {{collect(old('txtocupaciones'))->contains($id) ? 'selected' : ''  }}  value="{{$id}}" >{{$nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                            <label for="txtocupaciones" class="active">Ocupación <span class="red-text">*</span></label>
                            <small id="txtocupaciones-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m8 l8 offset-l3 m-3" id="otraocupacion">
                            <input class="validate" id="txtotra_ocupacion" name="txtotra_ocupacion" type="text"  value="{{ isset($user->otra_ocupacion) ? $user->otra_ocupacion : old('txtotra_ocupacion')}}">
                            <label for="txtotra_ocupacion" class="active">¿Cuál? <span class="red-text">*</span></label>
                            <small id="txtotra_ocupacion-error" class="error red-text"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
