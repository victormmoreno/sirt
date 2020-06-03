@extends('spa.layouts.app')

@section('meta-tittle', 'Inicio')
@section('meta-content', 'Inicio')
@section('content-spa')
<main class="mn-inner no-p">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                @if (session()->has('success'))
                <div class="valign-wrapper  col s12 m6 l6 offset-l3 m3">
                    <blockquote>
                        <ul class="collection center-align">
                            <li class="collection-item">
                                <h3 class="center-align">
                                    El SENA te da la bienvenida a su
                                    programa {{config('app.name')}},
                                    pronto nos comunicaremos contigo que presentes tu propuesta ante el comité de ideas. ¡ Entrena para tu pich de 5 minutos !
                                </h3>
                                <h4>El Registro ha sido guardado​ exitosamente.</h4>
                                Regresar al <a href="{{route('/')}}">Inicio</a>
                            </li>
                        </ul>
                    </blockquote>
                </div>
                @else
                <h5>
                    <a class="footer-text left-align" href="{{route('/')}}">
                        <i class="material-icons arrow-l">
                            arrow_back
                        </i>
                    </a>
                    Ideas de Proyecto
                </h5>
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row" method="post">
                            <form class="col s12 m12 l12" method="post" action="{{ route('idea.store') }}" onsubmit="return checkSubmit()">
                                @csrf
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
                                <center>
                                    <p align="center" class="description text-center">
                                        Ingresa tu idea de proyecto aquí debajo.
                                    </p>
                                </center>
                                <center>
                                    <span class="card-title center-align">
                                        Datos del Contacto
                                        <i class="Small material-icons prefix">
                                            contacts
                                        </i>
                                    </span>
                                </center>
                                <div class="divider">
                                </div>
                                <br>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                account_circle
                                            </i>
                                            <input class="validate" id="txtnombres" name="txtnombres" type="text" value="{{ old('txtnombres') }}">
                                            <label for="txtnombres">Nombres  <span class="red-text">*</span></label>
                                            @error('txtnombres')
                                                <label id="txtnombres-error" class="error" for="txtnombres">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                account_circle
                                            </i>
                                            <input class="validate" id="txtapellidos" name="txtapellidos" type="text" value="{{ old('txtapellidos') }}">
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
                                            <input class="validate" id="txtcorreo" name="txtcorreo" type="text" value="{{ old('txtcorreo') }}">
                                            <label for="txtcorreo">Correo Electronico  <span class="red-text">*</span></label>
                                            @error('txtcorreo')
                                                <label id="txtcorreo-error" class="error" for="txtcorreo">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                phone
                                            </i>
                                            <input class="validate" id="txttelefono" name="txttelefono" type="tel" value="{{ old('txttelefono') }}">
                                            <label for="txttelefono">Teléfono / Celular  <span class="red-text">*</span></label>
                                            @error('txttelefono')
                                                <label id="txttelefono-error" class="error" for="txttelefono">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                library_books
                                            </i>
                                            <input class="validate" id="txtnombrep_royecto" name="txtnombre_proyecto" type="text" value="{{ old('txtnombre_proyecto') }}">
                                            <label for="txtnombre_proyecto">Nombre de Proyecto  <span class="red-text">*</span></label>
                                            @error('txtnombre_proyecto')
                                                <label id="txtnombre_proyecto-error" class="error" for="txtnombre_proyecto">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">
                                                 domain
                                            </i>
                                            <select class="" id="txtnodo" name="txtnodo" style="width: 100%" tabindex="-1">
                                                <option value="">Seleccione Nodo</option>
                                                    @foreach($nodos as $nodo)
                                                    <option value="{{$nodo->id}}"  {{ old('txtnodo') == $nodo->id ? 'selected':'' }}>
                                                        {{$nodo->nodos}}
                                                    </option>
                                                    @endforeach
                                            </select>
                                            <label for="txtnodo">Tecnoparque más Cercano <span class="red-text">*</span></label>
                                            @error('txtnodo')
                                                <label id="txtnodo-error" class="error" for="txtnodo">{{ $message }}</label>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 m12 l12 offset-l6 m6 s6">
                                            <div class="switch m-b-md">
                                                <i class="material-icons prefix">
                                                    toggle_on
                                                </i>
                                                <label class="active">
                                                    ¿Es aprendiz SENA?  <span class="red-text">*</span>
                                                </label>
                                                <label>
                                                    No
                                                    <input id="txtaprendiz_sena" name="txtaprendiz_sena" type="checkbox" {{ old('txtaprendiz_sena') == 'on' ? 'checked':'' }} >
                                                        <span class="lever">
                                                        </span>
                                                        Si
                                                    
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                        <center>
                                            <span class="card-title center-align">
                                                Preguntas de Clasificación
                                                <i class="Small material-icons prefix">
                                                    contact_support
                                                </i>
                                            </span>
                                        </center>
                                        <p align="justify">
                                            Por favor lea detenidamente las opciones de repuesta y elija la que más se asemeje a su situación actual. Al finalizar por favor haga clic sobre el botón de "Registrar" para enviar sus respuestas a nuestra base de datos.
                                        </p>
                                        <div class="divider">
                                        </div>
                                        <div class="input-field col s12 m12 l12">
                                            <b>
                                                <label>
                                                    ¿En qué estado se encuentra su propuesta?
                                                    <span class="red-text">*</span>
                                                </label>
                                            </b>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input checked="" class="pregunta1" id="radio1" name="pregunta1" type="radio" value="1" {{ old('pregunta1') == 1 ? 'checked':'' }}/>
                                                    <label align="justify" for="radio1">
                                                        1. Tengo el problema identificado, pero no tengo claro que producto debo desarrollar para resolverlo.
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio2" name="pregunta1" type="radio" value="2" {{ old('pregunta1') == 2 ? 'checked':'' }}/>
                                                    <label align="justify" for="radio2">
                                                        2. Tengo la idea del producto que quiero desarrollar pero no sé cómo hacerlo.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio3" name="pregunta1" type="radio" value="3"/ {{ old('pregunta1') == 3 ? 'checked':'' }}>
                                                    <label align="justify" for="radio3">
                                                        3. Tengo la idea del producto que quiero desarrollar, tengo los conocimientos para hacerlo, pero no se qué pasos seguir para formular el proyecto.
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio4" name="pregunta1" type="radio" value="4"/ {{ old('pregunta1') == 4 ? 'checked':'' }}>
                                                    <label align="justify" for="radio4">
                                                        4. Tengo formulado el proyecto para desarrollar mi producto: tengo claros los objetivos, el alcance, los recursos y las actividades que debo realizar para conseguirlo, entre otros.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio5" name="pregunta1" type="radio" value="5" {{ old('pregunta1') == 5 ? 'checked':'' }}>
                                                        <label align="justify" for="radio5">
                                                            5. Mi proyecto está formulado y ya comencé la ejecución, pero necesito gestionar algunos recursos para poder avanzar.
                                                        </label>
                                                   
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio6" name="pregunta1" type="radio" value="6"/ {{ old('pregunta1') == 6 ? 'checked':'' }}>
                                                    <label align="justify" for="radio6">
                                                        6. Ya tengo un prototipo avanzado de mi producto y requiero gestionar algunos recursos para concluir mi proyecto.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio7" name="pregunta1" type="radio" value="7"/ {{ old('pregunta1') == 7 ? 'checked':'' }}>
                                                    <label align="justify" for="radio7">
                                                        7. Ya tengo un prototipo final, he realizado pruebas y ajustes, tengo planteada la idea de negocio y requiero gestionar algunos recursos para implementarla.
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio8" name="pregunta1" type="radio" value="8"/ {{ old('pregunta1') == 8 ? 'checked':'' }}>
                                                    <label align="justify" for="radio8">
                                                        8. No voy a desarrollar un producto, voy a comercializar un producto de otro fabricante.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta1" id="radio9" name="pregunta1" type="radio" value="9"/ {{ old('pregunta1') == 9 ? 'checked':'' }}>
                                                    <label align="justify" for="radio9">
                                                        9. Quiero desarrollar una página web para promocionar mi negocio actual.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <br>
                                        <div class="input-field col s12 m12 l12">
                                            <b>
                                                <label>
                                                    ¿Cómo está conformado su equipo de trabajo? <span class="red-text">*</span>
                                                </label>
                                            </b>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input  checked="" class="pregunta2" id="rad1" name="pregunta2" type="radio" value="1" {{ old('pregunta2') == 1 ? 'checked':'' }}/>
                                                    <label align="justify" for="rad1">
                                                        1. No tengo equipo de trabajo, yo solo me encargaré de desarrollar el producto..
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta2" id="rad2" name="pregunta2" type="radio" value="2" {{ old('pregunta2') == 2 ? 'checked':'' }}/>
                                                    <label align="justify" for="rad2" {{ old('pregunta2') == 2 ? 'checked':'' }}>
                                                        2. Tengo un equipo de trabajo que cuenta con los conocimientos técnicos mínimos para el desarrollo del producto, pero no contamos con los conocimientos de mercadeo para la implementación de la idea de negocio.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta2" id="rad3" name="pregunta2" type="radio" value="3" {{ old('pregunta2') == 3 ? 'checked':'' }}/>
                                                    <label align="justify" for="rad3">
                                                        3. Tengo un equipo de trabajo que cuenta con los conocimientos de mercadeo mínimos para la implementación de la idea de negocio, pero no contamos con los conocimientos técnicos para desarrollar el producto.
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta2" id="rad4" name="pregunta2" type="radio" value="4"{{ old('pregunta2') == 4 ? 'checked':'' }}/>
                                                    <label align="justify" for="rad4">
                                                        4. Tengo un equipo de trabajo multidisciplinar, que cuenta con los conocimientos técnicos, conocimientos de gestión y conocimientos de mercadeo necesarios para el desarrollo del producto y la implementación de la idea de negocio.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="divider">
                                        </div>
                                        <br>
                                        <div class="input-field col s12 m12 l12">
                                            <b>
                                                <label>
                                                    Marque en cuál de las siguientes categorías clasificaría su propuesta
                                                    <span class="red-text">*</span>
                                                </label>
                                            </b>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input checked="" class="pregunta3" id="r1" name="pregunta3" type="radio" value="1" {{ old('pregunta3') == 1 ? 'checked':'' }}/>
                                                    <label align="justify" for="r1">
                                                        1. Tecnologías Virtuales: desarrollo de software para diferentes dispositivos, animaciones 2D y 3D, creación de contenidos para aplicaciones, animaciones y videojuegos.
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta3" id="r2" name="pregunta3" type="radio" value="2" {{ old('pregunta3') == 2 ? 'checked':'' }}/>
                                                    <label align="justify" for="r2">
                                                        2. Biotecnología: utilización de organismos vivos o sus derivados para el desarrollo de productos y/o procesos en las áreas de ambiente, alimentos y nanotecnología.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta3" id="r3" name="pregunta3" type="radio" value="3" {{ old('pregunta3') == 3 ? 'checked':'' }}/>
                                                    <label align="justify" for="r3">
                                                        3. Electrónica y Telecomunicaciones: Control de procesos, telecomunicaciones, automatización, robótica aplicada, sistemas embebidos, prototipado electrónico y televisión digital.
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta3" id="r4" name="pregunta3" type="radio" value="4" {{ old('pregunta3') == 4 ? 'checked':'' }}/>
                                                    <label align="justify" for="r4">
                                                        4. Ingeniería y Diseño: diseño de productos en las áreas afines a la mecánica y el diseño industrial, como aprovechamiento de energías renovables, máquinas,mobiliario, consumo masivo y empaques.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta3" id="r5" name="pregunta3" type="radio" value="5" {{ old('pregunta3') == 5 ? 'checked':'' }}/>
                                                    <label align="justify" for="r5">
                                                        5. Nanotecnología y nuevos materiales: Modificación de superficies a escala nanométrica, síntesis de nanopartículas, evaluación a escala nanométrica, desarrollo y evaluación de nuevos materiales como materiales compuestos, materiales biodegradables y biopolímeros obtenidos a través de biotecnología.
                                                    </label>
                                                </p>
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <p class="p-v-xs">
                                                    <input class="pregunta3" id="r6" name="pregunta3" type="radio" value="6" {{ old('pregunta3') == 6 ? 'checked':'' }}/>
                                                    <label align="justify" for="r6">
                                                        6. Otros Productos: personalización de productos, productos de moda, alimentos no tradicionales o exóticos, productos artesanales, construcción de infraestructura.
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <div class="divider">
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m6 l6">
                                                <i class="material-icons prefix">
                                                    create
                                                </i>
                                                <textarea class="materialize-textarea" id="txtdescripcion" length="2000" name="txtdescripcion">{{ old('txtdescripcion') }}
                                                </textarea>
                                                <label for="txtdescripcion">
                                                    Descripción del Proyecto <span class="red-text">*</span>
                                                </label>
                                                @error('txtdescripcion')
                                                    <label id="txtdescripcion-error" class="error" for="txtdescripcion">{{ $message }}</label>
                                                @enderror
                                            </div>
                                            <div class="input-field col s12 m6 l6">
                                                <i class="material-icons prefix">
                                                    create
                                                </i>
                                                <textarea class="materialize-textarea" id="txtobjetivo" length="2000" name="txtobjetivo">{{ old('txtobjetivo') }}
                                                </textarea>
                                                <label for="txtobjetivo">
                                                    Objetivo general del Proyecto <span class="red-text">*</span>
                                                </label>
                                                @error('txtobjetivo')
                                                        <label id="txtobjetivo-error" class="error" for="txtobjetivo">{{ $message }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m12 l6 offset-l3 m3 s1">
                                                <i class="material-icons prefix">
                                                    create
                                                </i>
                                                <textarea class="materialize-textarea" id="txtalcance" length="2000" name="txtalcance">
                                                    {{ old('txtalcance') }}
                                                </textarea>
                                                <label for="txtalcance">
                                                    Alcance del Proyecto <span class="red-text">*</span>
                                                </label>
                                                @error('txtalcance')
                                                    <label id="txtalcance-error" class="error" for="txtalcance">{{ $message }}</label>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m8 l8 offset-l4 m-4">
                                                <div class="input-field col s12 m3 l3">
                                                    <label for="txtlinkvideo" class="active">
                                                        ¿La idea viene de una convocatoria? <span class="red-text">*</span>
                                                    </label>
                                                    <select class="" id="txtconvocatoria" name="txtconvocatoria"  style="width: 100%" tabindex="-1" onchange="idea.getSelectConvocatoria()">
                                                        <option value="0" {{old('txtconvocatoria') ==  0 ? 'selected':''}}>No</option>
                                                        <option value="1" {{old('txtconvocatoria') ==  1 ? 'selected':''}}>Si</option>
                                                    </select>
                                                    
                                                    @error('txtconvocatoria')
                                                    <label id="txtconvocatoria-error" class="error" for="txtconvocatoria">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <div class="input-field col s12 m4 l4">
                                                    <label for="txtnombreconvocatoria">
                                                        Nombre de Convocatoria 
                                                    </label>
                                                    <input  class="validate" id="txtnombreconvocatoria" name="txtnombreconvocatoria" type="text" value="{{ old('txtnombreconvocatoria') }}" {{ old('txtnombreconvocatoria'== null ? 'disabled':'') }}>
                                                    @error('txtnombreconvocatoria')
                                                        <label id="txtnombreconvocatoria-error" class="error" for="txtnombreconvocatoria">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                    
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12 m8 l8 offset-l4 m-4">

                                                <div class="input-field col s12 m3 l3">
                                                    <select class="" id="txtservidorvideo" name="txtservidorvideo"  style="width: 100%" tabindex="-1">
                                                    <option value="">Seleccione Servidor de video</option>
                                                        @foreach($servidorVideo as $id => $domain)
                                                                <option value="{{$id}}" {{old('txtservidorvideo') ==  $id ? 'selected':''}}>{{$domain}}</option>

                                                        @endforeach
                                                    </select>
                                                    @error('txtservidorvideo')
                                                    <label id="txtservidorvideo-error" class="error" for="txtservidorvideo">{{ $message }}</label>
                                                @enderror
                                                </div>
                                                <div class="input-field col s12 m4 l4">
                                                    <input placeholder="Ingresa el link del video" class="validate" id="txtlinkvideo" name="txtlinkvideo" type="text" value="{{ old('txtlinkvideo') }}">
                                                    <small>la dirección de debe ser algo similar: <b>https://www.youtube.com/watch?v=J9LSfkVF2K4</b></small><br>
                                                    @error('txtlinkvideo')
                                                        <label id="txtlinkvideo-error" class="error" for="txtlinkvideo">{{ $message }}</label>
                                                    @enderror
                                                </div>
                                                <label for="txtlinkvideo" class="active">
                                                    Link del video <span class="red-text"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <br>
                                            <center>
                                                <button class="waves-effect cyan darken-1 btn center-aling" type="submit">
                                                    <i class="material-icons right">
                                                        done_all
                                                    </i>
                                                    Registrar Idea
                                                </button>
                                                <a class="waves-effect red lighten-2 btn center-aling" href="{{route('/')}}">
                                                    <i class="material-icons right">
                                                        backspace
                                                    </i>
                                                    Cancelar
                                                </a>
                                            </center>
                                        </br>
                                    </br>
                                </br>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
