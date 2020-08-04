{!! csrf_field() !!}
<div class="card">
    <div class="card-content">
        <div class="row container">
            @if ($errors->any())
            <div class="card red lighten-3">
                <div class="row">
                    <div class="col s12 m10">
                        <div class="card-content white-text">
                            <p>
                                <i class="material-icons left">
                                    info_outline
                                </i>
                                Los datos marcados con * son obligatorios
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col s12 m12 l12">
                <h4 class="card-title center-align">Datos de contacto</h4>
            </div>
            <div class="divider">
            </div>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        account_circle
                    </i>
                    <input class="validate" id="txtnombres" name="txtnombres" type="text" value="{{ isset($idea->nombres_contacto) ? $idea->nombres_contacto : old('txtnombres')}}">
                    <label for="txtnombres">Nombres  <span class="red-text">*</span></label>
                    @error('txtnombres')
                        <label id="txtnombres-error" class="error" for="txtnombres">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        account_circle
                    </i>
                    <input class="validate" id="txtapellidos" name="txtapellidos" type="text" value="{{ isset($idea->apellidos_contacto) ? $idea->apellidos_contacto : old('txtapellidos')}}">
                    <label for="txtapellidos">Apellidos  <span class="red-text">*</span></label>
                    @error('txtapellidos')
                        <label id="txtapellidos-error" class="error" for="txtapellidos">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        email
                    </i>
                    <input class="validate" id="txtcorreo" name="txtcorreo" type="text" value="{{ isset($idea->correo_contacto) ? $idea->correo_contacto : old('txtcorreo')}}"/>
                    <label for="txtcorreo">Correo Electronico  <span class="red-text">*</span></label>
                    @error('txtcorreo')
                        <label id="txtcorreo-error" class="error" for="txtcorreo">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">
                        phone
                    </i>
                    <input class="validate" id="txttelefono" name="txttelefono" type="tel" value="{{ isset($idea->telefono_contacto) ? $idea->telefono_contacto : old('txttelefono')}}"/>
                    <label for="txttelefono">Teléfono / Celular  <span class="red-text">*</span></label>
                    @error('txttelefono')
                        <label id="txttelefono-error" class="error" for="txttelefono">{{ $message }}</label>
                    @enderror
                </div>
            </div>
         
            <div class="row">
                <div class="input-field col s12 m12 l12 offset-l6 offset-m6 offset-s6  pull-l1 pull-m1 pull-s1">
                    <div class="switch m-b-md">
                        <label class="active">
                            ¿Es aprendiz SENA?  <span class="red-text">*</span>
                        </label>
                        <label>
                            No
                            <input id="txtaprendiz_sena" name="txtaprendiz_sena" type="checkbox"  {{ isset($idea->aprendiz_sena) && $idea->aprendiz_sena == 1 ? 'cheked' : old('txtaprendiz_sena') == 'on' ? 'checked':''}}>
                            <span class="lever"></span>
                            Si
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col s12 m12 l12">
                <h4 class="card-title center-align">Información de la idea</h4>
            </div>
        </div>
        <div class="divider">
        </div>
        <div class="row container">
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    domain
                </i>
                <select class="" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1">
                    <option value="">Seleccione Nodo</option>
                        @foreach($nodos as $nodo)
                            @if(isset($idea->nodo->id))
                                <option value="{{$nodo->id}}" {{old('txtnodo',$idea->nodo->id) ==  $nodo->id ? 'selected':''}}>{{$nodo->nodos}}</option> 
                            @else
                            <option value="{{$nodo->id}}"  {{ old('txtnodo') == $nodo->id ? 'selected':'' }}>
                                {{$nodo->nodos}}
                            </option>
                            @endif
                        @endforeach
                </select>
                <label class="truncate" for="txtnodo">Tecnoparque más cercano a su lugar de residencia <span class="red-text">*</span></label>
                @error('txtnodo')
                    <label id="txtnodo-error" class="error" for="txtnodo">{{ $message }}</label>
                @enderror
            </div>
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    library_books
                </i>
                <input class="validate" id="txtnombrep_royecto" name="txtnombre_proyecto" type="text" value="{{ isset($idea->nombre_proyecto) ? old('txtnombre_proyecto', $idea->nombre_proyecto ): old('txtnombre_proyecto')}}">
                <label for="txtnombre_proyecto">Nombre de la idea  <span class="red-text">*</span></label>
                @error('txtnombre_proyecto')
                    <label id="txtnombre_proyecto-error" class="error" for="txtnombre_proyecto">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row container">
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    create
                </i>
                <textarea class="materialize-textarea" id="txtdescripcion" length="2000" name="txtdescripcion">{{ isset($idea->descripcion) ? old('txtdescripcion', $idea->descripcion ): old('txtdescripcion')}}
                </textarea>
                <label for="txtdescripcion">
                    Descripción de la idea <span class="red-text">*</span>
                </label>
                @error('txtdescripcion')
                    <label id="txtdescripcion-error" class="error" for="txtdescripcion">{{ $message }}</label>
                @enderror
            </div>
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    create
                </i>
                <textarea class="materialize-textarea" id="txtobjetivo" length="2000" name="txtobjetivo">{{ isset($idea->objetivo) ? old('txtobjetivo', $idea->objetivo ): old('txtobjetivo')}}
                </textarea>
                <label for="txtobjetivo">
                    Objetivo general de la idea <span class="red-text">*</span>
                </label>
                @error('txtobjetivo')
                        <label id="txtobjetivo-error" class="error" for="txtobjetivo">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="row container">
            <div class="input-field col s12 m6 l6">
                <i class="material-icons prefix">
                    create
                </i>
                <textarea class="materialize-textarea" id="txtalcance" length="2000" name="txtalcance">
                    {{ isset($idea->alcance) ? old('txtalcance', $idea->alcance ): old('txtalcance')}}
                </textarea>
                <label for="txtalcance">
                    Alcance del Proyecto <span class="red-text">*</span>
                </label>
                @error('txtalcance')
                    <label id="txtalcance-error" class="error" for="txtalcance">{{ $message }}</label>
                @enderror
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="input-field col s12 m3 l3">

                    <select class="" id="txtconvocatoria" name="txtconvocatoria"  style="width: 100%" tabindex="-1" onchange="idea.getSelectConvocatoria()">
                        <option value="0" {{ isset($idea->viene_convocatoria) && $idea->viene_convocatoria == 0 ? 'selected' : old('txtconvocatoria') ==  0 ? 'selected':''}}>No</option>
                        <option value="1" {{ isset($idea->viene_convocatoria) && $idea->viene_convocatoria == 1 ? 'selected' : old('txtconvocatoria') ==  1 ? 'selected':''}}>Si</option>
                    </select>

                    @error('txtconvocatoria')
                    <label id="txtconvocatoria-error" class="error" for="txtconvocatoria">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-field col s12 m9 l9">
                    <label for="txtnombreconvocatoria">
                        Nombre de Convocatoria
                    </label>
                    <input  class="validate" id="txtnombreconvocatoria" name="txtnombreconvocatoria" type="text" value="{{ isset($idea->convocatoria) ? old('txtnombreconvocatoria', $idea->convocatoria ): old('txtnombreconvocatoria')}}" {{isset($idea->viene_convocatoria) && $idea->viene_convocatoria == 0 ? 'disabled' : old('txtnombreconvocatoria'== null ? 'disabled':'') }}>
                    @error('txtnombreconvocatoria')
                        <label id="txtnombreconvocatoria-error" class="error" for="txtnombreconvocatoria">{{ $message }}</label>
                    @enderror
                </div>
                <label for="txtlinkvideo" class="active">
                    ¿La idea viene de una convocatoria? <span class="red-text">*</span>
                </label>
            </div>
        </div>
        <div class="row container">
            <div class="input-field col s12 m12 l12">
                <div class="input-field col s12 m3 l3">
                    <select class="" id="txtavalempresa" name="txtavalempresa"  style="width: 100%" tabindex="-1" onchange="idea.getSelectAvalEmpresa()">
                        <option value="0" {{ isset($idea->aval_empresa) && $idea->aval_empresa == 0 ? 'selected' : old('txtavalempresa') ==  0 ? 'selected':''}}>No</option>
                        <option value="1" {{ isset($idea->aval_empresa) && $idea->aval_empresa == 1 ? 'selected' : old('txtavalempresa') ==  1 ? 'selected':''}}>Si</option>
                    </select>
                    @error('txtavalempresa')
                    <label id="txtavalempresa-error" class="error" for="txtavalempresa">{{ $message }}</label>
                    @enderror
                </div>
                <div class="input-field col s12 m9 l9">
                    <label for="txtempresa">
                        Nombre de empresa que avala
                    </label>
                    <input  class="validate" id="txtempresa" name="txtempresa" type="text" value="{{ isset($idea->empresa) ? old('txtempresa', $idea->empresa ): old('txtempresa')}}" {{isset($idea->aval_empresa) && $idea->aval_empresa == 0 ? 'disabled' : old('txtempresa'== null ? 'disabled':'') }}>
                    @error('txtempresa')
                        <label id="txtempresa-error" class="error" for="txtempresa">{{ $message }}</label>
                    @enderror
                </div>
                <label for="txtempresa" class="active">
                    ¿La idea viene avalada por una empresa  ? <span class="red-text">*</span>
                </label>
            </div>
        </div>
        <div class="row container">
            <div class="input-field col s12 m12 l12 ">
                    <input placeholder="Ingresa el link del video" class="validate" id="txtlinkvideo" name="txtlinkvideo" type="text" value="{{ old('txtlinkvideo') }}" >
                    <small>la dirección de debe ser algo similar: <b>https://www.youtube.com/watch?v=J9LSfkVF2K4</b></small><br>
                    @error('txtlinkvideo')
                        <label id="txtlinkvideo-error" class="error" for="txtlinkvideo">{{ $message }}</label>
                    @enderror
                <label for="txtlinkvideo" class="active">
                    Si tienes un vídeo donde expliques por que tu idea es innovadora, quien es tu equipo de trabajo y por que requiere el apoyo de la Red Tecnoparque SENA.
                </label>
            </div>
        </div>
    </div>
</div>
<div class="card ">
    <div class="card-content">
        <div class="row section">
            <div class="col s12 m12 l12">
                <h4 class="card-title center-align">Preguntas de Clasificación</h4>
            </div>
        </div>
        <div class="divider">
        </div>
        <div class="row container section">
            <div class="col s12 m12 l12">
                <p align="justify">
                    Por favor lea detenidamente las opciones de repuesta y elija la que más se asemeje a su situación actual. Al finalizar por favor haga clic sobre el botón de "Registrar" para enviar sus respuestas a nuestra base de datos.
                </p>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m12 l12">
                <b>
                    <label>
                        ¿En qué estado se encuentra su propuesta?
                        <span class="red-text">*</span>
                    </label>
                    <div class="divider"></div>
                </b>

            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input checked="" class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1" {{ isset($idea->pregunta1) && $idea->pregunta1 == 1 ? 'checked' : old('pregunta1') == 1 ? 'checked':''}}/>
                        <label align="justify" for="radio1">
                            1. Tengo el problema identificado, pero no tengo claro que producto debo desarrollar para resolverlo.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta1" id="radio2" name="pregunta1" type="radio" value="2" {{ isset($idea->pregunta1) && $idea->pregunta1 == 2 ? 'checked' : old('pregunta1') == 2 ? 'checked':''}}/>
                        <label align="justify" for="radio2">
                            2. Tengo la idea del producto que quiero desarrollar pero no sé cómo hacerlo.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta1" id="radio3" name="pregunta1" type="radio" value="3" {{ isset($idea->pregunta1) && $idea->pregunta1 == 3 ? 'checked' : old('pregunta1') == 3 ? 'checked':''}}/>
                        <label align="justify" for="radio3">
                            3. Tengo la idea del producto que quiero desarrollar, tengo los conocimientos para hacerlo, pero no se qué pasos seguir para formular el proyecto.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta1" id="radio4" name="pregunta1" type="radio" value="4"{{ isset($idea->pregunta1) && $idea->pregunta1 == 4 ? 'checked' : old('pregunta1') == 4 ? 'checked':''}}/>
                        <label align="justify" for="radio4">
                            4. Tengo formulado el proyecto para desarrollar mi producto: tengo claros los objetivos, el alcance, los recursos y las actividades que debo realizar para conseguirlo, entre otros.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta1" id="radio5" name="pregunta1" type="radio" value="5" {{ isset($idea->pregunta1) && $idea->pregunta1 == 5 ? 'checked' : old('pregunta1') == 5 ? 'checked':''}}/>
                        <label align="justify" for="radio5">
                            5. Mi proyecto está formulado y ya comencé la ejecución, pero necesito gestionar algunos recursos para poder avanzar.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta1" id="radio6" name="pregunta1" type="radio" value="6" {{ isset($idea->pregunta1) && $idea->pregunta1 == 6 ? 'checked' : old('pregunta1') == 6 ? 'checked':''}}/>
                        <label align="justify" for="radio6">
                            6. Ya tengo un prototipo avanzado de mi producto y requiero gestionar algunos recursos para concluir mi proyecto.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta1" id="radio7" name="pregunta1" type="radio" value="7" {{ isset($idea->pregunta1) && $idea->pregunta1 == 7 ? 'checked' : old('pregunta1') == 7 ? 'checked':''}}/>
                        <label align="justify" for="radio7">
                            7. Ya tengo un prototipo final, he realizado pruebas y ajustes, tengo planteada la idea de negocio y requiero gestionar algunos recursos para implementarla.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta1" id="radio8" name="pregunta1" type="radio" value="8" {{ isset($idea->pregunta1) && $idea->pregunta1 == 8 ? 'checked' : old('pregunta1') == 8 ? 'checked':''}}/>
                        <label align="justify" for="radio8">
                            8. No voy a desarrollar un producto, voy a comercializar un producto de otro fabricante.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                        <p class="p-v-xs">
                        <input class="pregunta1" id="radio9" name="pregunta1" type="radio" value="9" {{ isset($idea->pregunta1) && $idea->pregunta1 == 9 ? 'checked' : old('pregunta1') == 9 ? 'checked':''}}/>
                        <label align="justify" for="radio9">
                            9. Quiero desarrollar una página web para promocionar mi negocio actual.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="section"></div>
        <div class="row container section">
            <div class="input-field col s12 m12 l12">
                <b>
                    <label>
                        ¿Cómo está conformado su equipo de trabajo?
                        <span class="red-text">*</span>
                    </label>
                    <div class="divider"></div>
                </b>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input  checked="" class="pregunta2" id="rad1" name="pregunta2" type="radio" value="1" {{ isset($idea->pregunta2) && $idea->pregunta2 == 1 ? 'checked' : old('pregunta2') == 1 ? 'checked':''}}/>
                        <label align="justify" for="rad1">
                            1. No tengo equipo de trabajo, yo solo me encargaré de desarrollar el producto.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta2" id="rad2" name="pregunta2" type="radio" value="2" {{ isset($idea->pregunta2) && $idea->pregunta2 == 2 ? 'checked' : old('pregunta2') == 2 ? 'checked':''}}/>
                        <label align="justify" for="rad2" {{ old('pregunta2') == 2 ? 'checked':'' }}>
                            2. Tengo un equipo de trabajo que cuenta con los conocimientos técnicos mínimos para el desarrollo del producto, pero no contamos con los conocimientos de mercadeo para la implementación de la idea de negocio.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6 section">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta2" id="rad3" name="pregunta2" type="radio" value="3" {{ isset($idea->pregunta2) && $idea->pregunta2 == 3 ? 'checked' : old('pregunta2') == 3 ? 'checked':''}}/>
                        <label align="justify" for="rad3">
                            3. Tengo un equipo de trabajo que cuenta con los conocimientos de mercadeo mínimos para la implementación de la idea de negocio, pero no contamos con los conocimientos técnicos para desarrollar el producto.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6 ">
                <div class="section ">
                    <p class="p-v-xs">
                        <input class="pregunta2" id="rad4" name="pregunta2" type="radio" value="4" {{ isset($idea->pregunta2) && $idea->pregunta2 == 4 ? 'checked' : old('pregunta2') == 4 ? 'checked':''}}/>
                        <label align="justify" for="rad4">
                            4. Tengo un equipo de trabajo multidisciplinar, que cuenta con los conocimientos técnicos, conocimientos de gestión y conocimientos de mercadeo necesarios para el desarrollo del producto y la implementación de la idea de negocio.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="section"></div>
        <div class="section"></div>
        <div class="row container section">
            <div class="input-field col s12 m12 l12">
                <b>
                    <label>
                        Marque en cuál de las siguientes categorías clasificaría su propuesta
                        <span class="red-text">*</span>
                    </label>
                    <div class="divider"></div>
                </b>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input checked="" class="pregunta3" id="r1" name="pregunta3" type="radio" value="1" {{ isset($idea->pregunta3) && $idea->pregunta3 == 1 ? 'checked' : old('pregunta3') == 1 ? 'checked':''}}/>
                        <label align="justify" for="r1">
                            1. Tecnologías Virtuales: desarrollo de software para diferentes dispositivos, animaciones 2D y 3D, creación de contenidos para aplicaciones, animaciones y videojuegos.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2" {{ isset($idea->pregunta3) && $idea->pregunta3 == 2 ? 'checked' : old('pregunta3') == 2 ? 'checked':''}}/>
                        <label align="justify" for="r2">
                            2. Biotecnología: utilización de organismos vivos o sus derivados para el desarrollo de productos y/o procesos en las áreas de ambiente, alimentos y nanotecnología.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta3" id="r3" name="pregunta3" type="radio" value="3" {{ isset($idea->pregunta3) && $idea->pregunta3 == 3 ? 'checked' : old('pregunta3') == 3 ? 'checked':''}}/>
                        <label align="justify" for="r3">
                            3. Electrónica y Telecomunicaciones: Control de procesos, telecomunicaciones, automatización, robótica aplicada, sistemas embebidos, prototipado electrónico y televisión digital.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta3" id="r4" name="pregunta3" type="radio" value="4" {{ isset($idea->pregunta3) && $idea->pregunta3 == 4 ? 'checked' : old('pregunta3') == 4 ? 'checked':''}}/>
                        <label align="justify" for="r4">
                            4. Ingeniería y Diseño: diseño de productos en las áreas afines a la mecánica y el diseño industrial, como aprovechamiento de energías renovables, máquinas,mobiliario, consumo masivo y empaques.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <div class="row container section">
            <div class="input-field col s12 m6 l6">
                <div class="section">
                    <p class="p-v-xs">
                        <input class="pregunta3" id="r5" name="pregunta3" type="radio" value="5" {{ isset($idea->pregunta3) && $idea->pregunta3 == 5 ? 'checked' : old('pregunta3') == 5 ? 'checked':''}}/>
                        <label align="justify" for="r5">
                            5. Nanotecnología y nuevos materiales: Modificación de superficies a escala nanométrica, síntesis de nanopartículas, evaluación a escala nanométrica, desarrollo y evaluación de nuevos materiales como materiales compuestos, materiales biodegradables y biopolímeros obtenidos a través de biotecnología.
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s12 m6 l6">
                <div class="section">
                        <p class="p-v-xs">
                        <input class="pregunta3" id="r6" name="pregunta3" type="radio" value="6" {{ isset($idea->pregunta3) && $idea->pregunta3 == 6 ? 'checked' : old('pregunta3') == 6 ? 'checked':''}}/>
                        <label align="justify" for="r6">
                            6. Otros Productos: personalización de productos, productos de moda, alimentos no tradicionales o exóticos, productos artesanales, construcción de infraestructura.
                        </label>
                    </p>
                </div>
            </div>
        </div>
        <br><br><br><br><br><br>
        <div class="divider">
        </div>
        <div class="row container section">
            <div class="input-field col s12 m12 l12 offset-l4 offset-m4 offset-s4">
                <button class="waves-effect cyan darken-1 btn center-aling" type="submit">
                    <i class="material-icons right">
                        done_all
                    </i>
                    {{isset($btnText) ? $btnText : 'Guardar'}}
                </button>
                <a class="waves-effect red lighten-2 btn center-aling" href="{{route('/')}}">
                    <i class="material-icons right">
                        backspace
                    </i>
                    Cancelar
                </a>
            </div>

        </div>
    </div>
</div>
    