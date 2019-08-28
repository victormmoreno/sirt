
{!! csrf_field() !!}
<div class="row">
    <div class="col s12 m3 l3">
        <blockquote>
            <ul class="collection">
                <li class="collection-item">
                    <h5 class="title center">
                        <b>
                            Laboratorios
                        </b>
                    </h5>
                    <p>
                        Por favor ingrese los costos administrativos del laboratorio en porcentaje (%).
                    </p>
                </li>
            </ul>
        </blockquote>
    </div>
    <div class="col s12 m9 l9">
            
            <div class="center">
                <span class="title">
                     <strong>{{ isset($laboratorio->nombre) ? 'Editar laboratorio '. $laboratorio->nombre : 'Nuevo laboratorio'}}</strong>
                </span>
            </div>
            <div class="divider mailbox-divider">
            </div>
            @if ($errors->any())
                <div class="card red lighten-3">
                    <div class="row">
                        <div class="col s12 m12">
                            <div class="card-content white-text">
                                <p>
                                    <i class="material-icons left">
                                        info_outline
                                    </i>
                                    @if(collect($errors->all())->count() > 1)
                                    Tienes {{collect($errors->all())->count()}} errores
                                    @else
                                        Tienes {{collect($errors->all())->count()}} error
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3 m3">
                    <i class="material-icons prefix">
                        local_drink
                    </i>
                    <input class="validate" id="txtnombre" name="txtnombre" type="text" value="{{ isset($laboratorio->nombre) ? $laboratorio->nombre : old('txtnombre')}}"/>
                    <label for="txtnombre">
                        Nombre Laboratorio
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    @error('txtnombre')
                    <label class="error" for="txtnombre" id="txtnombre-error">
                        {{ $message }}
                    </label>
                    @enderror
                    
                </div>
            </div>
            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsAdministrador())
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3 m3">
                    <i class="material-icons prefix">
                        location_city
                    </i>
                    @if(isset($laboratorio->nodo->id))
                        <select class="" id="txtnodo" name="txtnodo" onchange="LaboratorioLineaEdit.getSelectLineaForNodo()"  style="width: 100%; display: none
                        " tabindex="-1" >
                    @else
                        <select class="" id="txtnodo" name="txtnodo" onchange="lineaLaboratorio.getSelectLineaForNodo()"  style="width: 100%; display: none
                        " tabindex="-1" >   
                    @endif
                        <option value="">Seleccione Nodo</option>
                        @foreach($nodos as $nodo)
                                @if(isset($laboratorio->nodo->id))
                                    <option value="{{$nodo->id}}" {{old('txtnodo',$laboratorio->nodo->id) ==  $nodo->id ? 'selected':''}}>{{$nodo->nodos}}</option> 
                                @else
                                    <option value="{{$nodo->id}}" {{old('txtnodo') ==  $nodo->id ? 'selected':''}}>{{$nodo->nodos}}</option>
                                @endif
                                                        
                        @endforeach
                    </select>
                    <label for="txtnodo">
                        Nodo
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    @error('txtnodo')
                    <label class="error" for="txtnodo" id="txtnodo-error">
                        {{ $message }}
                    </label>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3 m3">
                    <i class="material-icons prefix">
                        linear_scale
                    </i>
                    <select class="" id="txtlinea" name="txtlinea" style="width: 100%" tabindex="-1">
                        <option value="">Seleccione Primero el nodo</option>
                    </select>
                    <label for="txtlinea">
                        Linea
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    @error('txtlinea')
                    <label class="error" for="txtlinea" id="txtlinea-error">
                        {{ $message }}
                    </label>
                    @enderror
                </div>
            </div>
            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsDinamizador())
                <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3 m3">
                    <i class="material-icons prefix">
                        linear_scale
                    </i>
                    <select class="" id="txtlinea" name="txtlinea"  style="width: 100%; display: none
                        " tabindex="-1" >
                        <option value="">Seleccione Linea</option>
                        @foreach($lineas as $id => $nombre)
                                @if(isset($laboratorio->lineatecnologica->id))
                                    <option value="{{$id}}" {{old('txtlinea',$laboratorio->lineatecnologica->id) ==  $id ? 'selected':''}}>{{$nombre}}</option> 
                                @else
                                    <option value="{{$id}}" {{old('txtlinea') ==  $id ? 'selected':''}}>{{$nombre}}</option> 
                                @endif
                                                       
                        @endforeach
                    </select>

                    <label for="txtlinea">
                        Linea
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    @error('txtlinea')
                    <label class="error" for="txtlinea" id="txtlinea-error">
                        {{ $message }}
                    </label>
                    @enderror
                </div>
            </div>
            @endif
            <div class="row">
                <div class="input-field col s12 m6 l6 offset-l3 m3">
                    <i class="material-icons prefix">
                        done_all
                    </i>
                    <input class="validate" id="txtcostos" name="txtcostos" type="text" value="{{ isset($laboratorio->participacion_costos) ? $laboratorio->participacion_costos : old('txtcostos')}}"/>
                    <label for="txtcostos">
                        Costos Administrativos (%)
                        <span class="red-text">
                            *
                        </span>
                    </label>
                    @error('txtcostos')
                    <label class="error" for="txtcostos" id="txtcostos-error">
                        {{ $message }}
                    </label>
                    @enderror
                    <div class="center-align">
                        <small class="black-text">
                            Debe proporcionar el porcentaje, ejemplo: <b>17.3</b>
                        </small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12 offset-l5 m5 s5">
                    <div class="switch m-b-md">
                      <i class="material-icons prefix">toggle_off</i>
                      <label class="active">Estado Laboratorio <span class="red-text">*</span></label>
                        <label>
                            Habilitado
                            @if(isset($laboratorio->estado))
                            <input type="checkbox" id="txtestado" name="txtestado" {{$laboratorio->estado != 1 ? 'checked' : old('txtestado')}}>
                            @else
                            <input type="checkbox" id="txtestado" name="txtestado" {{old('txtestado') == 'on' ? 'checked' : ''}}>
                            @endif
                            <span class="lever"></span>
                            Inhabilitado
                        </label>
                    </div>
                </div>
            </div>
            <div class="divider mailbox-divider">
            </div>
            <div class="row">
                <center>
                    <button class="waves-effect cyan darken-1 btn center-aling" type="submit">
                        <i class="material-icons right">
                            done_all
                        </i>
                        {{isset($btnText) ? $btnText : 'Guardar'}}
                    </button>
                    <a class="btn waves-effect red lighten-2 center-aling" href="{{route('laboratorio.index')}}">
                        <i class="material-icons right">
                            backspace
                        </i>
                        Cancelar
                    </a>
                </center>
            </div>
        </br>
    </div>
</div>