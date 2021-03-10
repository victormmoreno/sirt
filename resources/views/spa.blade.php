@extends('spa.layouts.app')
@section('meta-title', 'Red Tecnoparque Colombia')
@section('meta-content', 'Inicio')
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Estilos.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/EstilosTablet.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/EstilosMovil.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('fontAwesome/css/all.min.css') }}">
@endpush
@section('content-spa')
<main class="mn-inner no-p">
    <div class="content">
    <!---Home-->
    <section id="home">
        <div class="conte-home-escritorio">
            <div class="bacg-home nodo1"></div>
            <div class="bacg-home nodo2"></div>
            <div class="bacg-home nodo3"></div>
            <div class="bacg-home nodo4"></div>
            <div class="bacg-home nodo5"></div>
        </div>
        <div class="bacg-home-celular">
            <ul id="Cel-home-slider">
                <li>
                    <img src="{{ asset('img/nodo-cucuta-hori.jpg') }}" id="home-cucuta">
                </li>
                <li>
                    <img src="{{ asset('img/nodo-ocaña.jpg') }}" id="home-ocaña">
                </li>
                <li id="nodo-img-3"></li>
                <li id="nodo-img-4"></li>
                <li id="nodo-img-5"></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <div class="logo-tecno">
            <h1 class="tex-logo red-textl">RED</h1>
            <h1 class="tex-logo tecno">TECNOPARQUE</h1>
            <h1 class="tex-logo colom">COLOMBIA</h1>
        </div>
        <div class="logo-tecno-cel">
            <h1 class="tex-logo-cel red-cel">RED</h1>
            <h1 class="tex-logo-cel tecno-cel">TECNOPARQUE</h1>
            <h1 class="tex-logo-cel colom-cel">COLOMBIA</h1>
        </div>
    </section>
    <!--------------------------------------------------------->
    <!--- ¿Qué es tecnoparques? -->
    <section id="slideshow">
        <ul class="slider-escritorio">
            <li>
                <img src="{{ asset('img/QueEsTecnoparque.jpg') }}" alt="QueEsTecnoparque" id="img-1">
            </li>
            <li>
                <img src="{{ asset('img/NuestrosServicios.jpg') }}" alt="ServiciosTecnoparque" id="img-2">
            </li>
            <li>
                <img src="{{ asset('img/objetivos.jpg') }}" alt="ObjetivosTecnoparque" id="img-3">
            </li>
        </ul>
        <ol class="paginacion">
        </ol>
    </section>
    <section id="slideshow-tab">
        <ul class="slider-tab">
            <li>
                <img src="{{ asset('img/objetivos.jpg') }}" alt="ObjetivosTecnoparque" id="img-3">
            </li>
            <li>
                <img src="{{ asset('img/NuestrosServicios.jpg') }}" alt="ServiciosTecnoparque" id="img-2">
            </li>
            <li>
                <img src="{{ asset('img/QueEsTecnoparque.jpg') }}" alt="QueEsTecnoparque" id="img-1">
            </li>
        </ul>
        <ol class="paginacion-tab">
        </ol>
    </section>
    <section id="slideshow-cel">
        <ul class="slider-cel">
            <li>
                <img src="{{ asset('img/QueEsTecnoparque-cel.jpg') }}" alt="QueEsTecnoparque" id="img-1">
            </li>
            <li>
                <img src="{{ asset('img/NuestrosServiciosMovil.jpg') }}" alt="ServiciosTecnoparque" id="img-2">
            </li>
            <li>
                <img src="{{ asset('img/objetivos-cel.jpg') }}" alt="ObjetivosTecnoparque" id="img-3">
            </li>
        </ul>
        <ol class="paginacion-cel">
        </ol>
    </section>
    <!--------------------------------------------------------->
    <!--Charla informativa-->
    <section id="video">
        <div id="fondo-titulo-video">
            <h1 id="titulo-seccion-video">Charla informativa</h1>
        </div>
        <iframe id="charla" width="560" height="315" src="//www.youtube.com/embed/7kmYdTS9rro" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </section>
    <!--------------------------------------------------------->
    <!--Lineas-->
    <section id="lineas">
        <div id="caja-texto">
            <div id="caja-texto-2">
                <div id="lineas-texto">
                    <h1>líneas</h1>
                    <hr>
                    <p>Tecnoparque se especializa en 4 líneas sustentadas en tecnologías emergentes, en las oportunidades del sector productivo y la política del gobierno. <br> Los usuarios pueden acceder gratuitamente a asesoría especializada de gestores
                        expertos en las 4 líneas tecnológicas además de acceso a infraestructura y laboratorios con equipos de alta tecnología, convirtiendo a Tecnoparque en un actor clave en los ecosistemas de Ciencia Tecnología e Innovación en el país.
                    </p>
                </div>
            </div>
        </div>
        <div id="caja-iconos">
            <div id="iconos">
                <div id="caja-icono1" class="w-cajas-iconos">
                    <div id="icono1" class="iconos-blancos"></div>
                </div>
                <div id="descripcion-linea1" class="w-descripcion-lineas">
                    <div class="caja-descripcion-text">
                        <h5 id="titulo-descripcion-linea1" class="titulos-descripcion-lineas">Biotecnología y Nanotecnología</h5>
                        <hr>
                        <p class="descripcion-lineas-p"> • Biotecnología industrial</p>

                        <p class="descripcion-lineas-p"> • Microbiología agrícola y pecuaria</p>

                        <p class="descripcion-lineas-p"> • Biotecnología animal</p>

                        <p class="descripcion-lineas-p"> • Biotecnología vegetal</p>

                        <p class="descripcion-lineas-p"> • Bioinformática</p>

                        <p class="descripcion-lineas-p"> • Medio ambiente</p>

                        <p class="descripcion-lineas-p"> • Nuevos materiales</p>

                        <p class="descripcion-lineas-p"> • Energías verdes y biocombustibles</p>

                        <p class="descripcion-lineas-p"> • Agroindustria alimentaria</p>

                        <p class="descripcion-lineas-p"> • Agroindustria no alimentaria</p>

                        <p class="descripcion-lineas-p"> • Nanotecnología</p>
                    </div>
                </div>
                <div id="caja-icono2" class="w-cajas-iconos">

                    <div id="icono2" class="iconos-naranjas"></div>

                </div>

                <div id="descripcion-linea2" class="w-descripcion-lineas">

                    <div class="caja-descripcion-text">

                        <h5 id="titulo-descripcion-linea2" class="titulos-descripcion-lineas">Electrónica y Telecomunicaciones</h5>

                        <hr>

                        <p class="descripcion-lineas-p"> • Automatización e instrumentación</p>

                        <p class="descripcion-lineas-p"> • Redes inteligentes</p>

                        <p class="descripcion-lineas-p"> • Robótica</p>

                        <p class="descripcion-lineas-p"> • Sistemas embebidos</p>

                        <p class="descripcion-lineas-p"> • Agroelectrónica</p>

                        <p class="descripcion-lineas-p"> • Análisis de señales y protocolos</p>

                        <p class="descripcion-lineas-p"> • Infraestructura, redes y antenas</p>

                        <p class="descripcion-lineas-p"> • Diseño electrónico</p>

                        <p class="descripcion-lineas-p"> • Telemática</p>

                        <p class="descripcion-lineas-p"> • Internet de las cosas (IoT)</p>

                    </div>

                </div>

                <div id="caja-icono3" class="w-cajas-iconos">

                    <div id="icono3" class="iconos-blancos"></div>

                </div>

                <div id="descripcion-linea3" class="w-descripcion-lineas">

                    <div class="caja-descripcion-text">

                        <h5 id="titulo-descripcion-linea3" class="titulos-descripcion-lineas">Tecnologías Virtuales</h5>

                        <hr>

                        <p class="descripcion-lineas-p"> • Aplicaciones móviles</p>

                        <p class="descripcion-lineas-p"> • Inteligencia artificial y Big-Data</p>

                        <p class="descripcion-lineas-p"> • Realidad virtual y simulación</p>

                        <p class="descripcion-lineas-p"> • Realidad aumentada</p>

                        <p class="descripcion-lineas-p"> • Animación digital</p>

                        <p class="descripcion-lineas-p"> • Diseño y desarrollo de videojuegos</p>

                        <p class="descripcion-lineas-p"> • Ingeniería de software</p>

                        <p class="descripcion-lineas-p"> • Desarrollo de contenidos multimediales</p>

                        <p class="descripcion-lineas-p"> • Geotecnología</p>

                    </div>

                </div>

                <div id="caja-icono4" class="w-cajas-iconos">

                    <div id="icono4" class="iconos-naranjas"></div>

                </div>

                <div id="descripcion-linea4" class="w-descripcion-lineas">

                    <div class="caja-descripcion-text">

                        <h5 id="titulo-descripcion-linea4" class="titulos-descripcion-lineas">Ingeniería y Diseño</h5>

                        <hr>

                        <p class="descripcion-lineas-p">• Productos y procesos</p>

                        <p class="descripcion-lineas-p">• Diseño de concepto y detalles</p>

                        <p class="descripcion-lineas-p">• Análisis y simulación</p>

                        <p class="descripcion-lineas-p">• Ingeniería inversa</p>

                        <p class="descripcion-lineas-p">• Mecanizado</p>

                        <p class="descripcion-lineas-p">• Diseño estratégico</p>

                        <p class="descripcion-lineas-p">• Biomecánica</p>

                        <p class="descripcion-lineas-p">• Materiales</p>

                        <p class="descripcion-lineas-p">• Tecnificación de procesos agrícolas</p>

                        <p class="descripcion-lineas-p">• Aplicación de energías renovables</p>

                        <p class="descripcion-lineas-p">• Sistemas del aprovechamiento de recursos hídricos</p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!---------------------------------------------------------------------------------------------------------------------------------->

    <!---Noticia-->

    <section id="noticia">
    <?php
    use App\Noticias;
    ?>
    <img src="{!! asset('img/menu-ahmburguesa.png') !!}" class="not-cel">
    <div class="presentNoti">
        <div class="boton-escritorio">
            @foreach (Noticias::orderBy('id','DESC')->limit('1')->get('Titulo') as $item1)
                <button class="titulo1" onclick="titulo1();">{!! $item1->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(1)->take(1)->get('Titulo') as $item2)
                <button class="titulo2" onclick="titulo2();">{!! $item2->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(2)->take(1)->get('Titulo') as $item3)
                <button class="titulo3" onclick="titulo3();">{!! $item3->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(3)->take(1)->get('Titulo') as $item4)
                <button class="titulo4" onclick="titulo4();">{!! $item4->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(4)->take(1)->get('Titulo') as $item5)
                <button class="titulo5" onclick="titulo5();">{!! $item5->Titulo !!}</button>
            @endforeach
        </div>
        <div class="botones">
            @foreach (Noticias::orderBy('id','DESC')->limit('1')->get('Titulo') as $item1)
                <button class="titulo1" onclick="titulo1();">{!! $item1->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(1)->take(1)->get('Titulo') as $item2)
                <button class="titulo2" onclick="titulo2();">{!! $item2->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(2)->take(1)->get('Titulo') as $item3)
                <button class="titulo3" onclick="titulo3();">{!! $item3->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(3)->take(1)->get('Titulo') as $item4)
                <button class="titulo4" onclick="titulo4();">{!! $item4->Titulo !!}</button>
            @endforeach
            @foreach (Noticias::orderBy('id','DESC')->skip(4)->take(1)->get('Titulo') as $item5)
                <button class="titulo5" onclick="titulo5();">{!! $item5->Titulo !!}</button>
            @endforeach
        </div>
        <div class="contenedor-principal">

            @foreach (Noticias::orderBy('id','DESC')->limit('1')->get() as $item1)
            <div id="contenido1" class="conte-general">
                <div class="cont-tituloNoticia">
                    <h3>{!! $item1->Titulo !!}</h3>
                </div>
                <img src="{{ asset('storage').'/'.$item1->Imagen }}" class="img-thumbnail img-fluid">
                <div class="cont-textNoticia">
                    <p>{!! $item1->Descripcion !!}</p>
                </div>
            </div>
            @endforeach

            @foreach (Noticias::orderBy('id','DESC')->skip(1)->take(1)->get() as $item2)
            <div id="contenido2" class="contenidoOculto conte-general">
                <div class="cont-tituloNoticia">
                    <h3>{!! $item2->Titulo !!}</h3>
                </div>
                <img src="{{ asset('storage').'/'.$item2->Imagen }}" class="img-thumbnail img-fluid">
                <div class="cont-textNoticia">
                    <p>{!! $item2->Descripcion !!}</p>
                </div>
            </div>
            @endforeach

            @foreach (Noticias::orderBy('id','DESC')->skip(2)->take(1)->get() as $item3)
            <div id="contenido3" class="contenidoOculto conte-general">
                <div class="cont-tituloNoticia">
                    <h3>{!! $item3->Titulo !!}</h3>
                </div>
                <img src="{{ asset('storage').'/'.$item3->Imagen }}" class="img-thumbnail img-fluid">
                <div class="cont-textNoticia">
                    <p>{!! $item3->Descripcion !!}</p>
                </div>
            </div>
            @endforeach

            @foreach (Noticias::orderBy('id','DESC')->skip(3)->take(1)->get() as $item4)
            <div id="contenido4" class="contenidoOculto conte-general">
                <div class="cont-tituloNoticia">
                    <h3>{!! $item4->Titulo !!}</h3>
                </div>
                <img src="{{ asset('storage').'/'.$item4->Imagen }}" class="img-thumbnail img-fluid">
                <div class="cont-textNoticia">
                    <p>{!! $item4->Descripcion !!}</p>
                </div>
            </div>
            @endforeach

            @foreach (Noticias::orderBy('id','DESC')->skip(4)->take(1)->get() as $item5)
            <div id="contenido5" class="contenidoOculto conte-general">
                <div class="cont-tituloNoticia">
                    <h3>{!! $item5->Titulo !!}</h3>
                </div>
                <img src="{{ asset('storage').'/'.$item5->Imagen }}" class="img-thumbnail img-fluid">
                <div class="cont-textNoticia">
                    <p>{!! $item5->Descripcion !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </section>

    <!-------------------------------------------------------------------------------------------------------------------------------------------->
<!---Nodos-->

<section id="Nodos">
    <div id="cont-nodos">
        <div class="caja-mapa">
            <div class="mapa">
                <div class="circulo-nodos cirnodo1 antioq"></div>
                <div class="circulo-nodos cirnodo2 DC"></div>
                <div class="circulo-nodos cirnodo3 cesar"></div>
                <div class="circulo-nodos cirnodo4 cauca"></div>
                <div class="circulo-nodos cirnodo5 risaralda"></div>
                <div class="circulo-nodos cirnodo6 caldas"></div>
                <div class="circulo-nodos cirnodo7 tolima"></div>
                <div class="circulo-nodos cirnodo8 vall-cauca"></div>
                <div class="circulo-nodos cirnodo9 huila"></div>
                <div class="circulo-nodos cirnodo10 nort-santander"></div>
                <div class="circulo-nodos cirnodo11 santander"></div>
                <div class="circulo-nodos cirnodo12 atlantico"></div>
            </div>
            <div class="nodo17">

            </div>
        </div>


        <div class="caja-InfoNodos">

            <div class="Info-nodos medellin">
                <h3>Medellín</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Carrera 46 # 56-11. <br>Edificio TecnoParque, Piso 6-7</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+034) 5760000 <br>ext 42852</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.081938605611!2d-75.56509915033787!3d6.252934427963699!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4428f9fc984135%3A0x26cb935662b70fe6!2sTecnoparque%2C%20Cra.%2046%20%23%2356-11%2C%20Medell%C3%ADn%2C%20Antioquia!5e0!3m2!1ses!2sco!4v1604523737194!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos antioquia1"></div>
                    <div class="opcionNodos antioquia2"></div>
                </div>
            </div>

            <div class="Info-nodos rionegro">
                <h3>Rionegro</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Calle 41 Nº 50A – 324</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+034) 5311856</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.8101669316065!2d-75.41799270033815!3d6.156173879012142!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e469e8c0c9bc861%3A0xc299568dcf141f84!2sTecnoParque%20Nodo%20Rionegro!5e0!3m2!1ses!2sco!4v1604524108543!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos antioquia1"></div>
                    <div class="opcionNodos antioquia2"></div>
                </div>
            </div>

            <div class="Info-nodos bogota">
                <h3>Bogotá Dc</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Calle 54 No 10 – 39</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+031) 5461500</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.740541940642!2d-74.06691985034114!3d4.640307443455449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9a3a0d0f8081%3A0x7f6796e93ed81430!2sSENA%20Tecnoparque!5e0!3m2!1ses!2sco!4v1604524460255!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos cundinamarca1"></div>
                    <div class="opcionNodos cundinamarca2"></div>
                </div>
            </div>
            <div class="Info-nodos Cazuca">
                <h3>Cazucá</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Autopista Sur Transversal 7
                            <BR>No 8 – 40.TecnoParque Central</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+031) 5461600</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.0077270600086!2d-74.19345405034123!3d4.592635343849162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9e4bad9214db%3A0x8f5115bb30158afc!2sTecnoParque%20SENA%20Cazuc%C3%A1!5e0!3m2!1ses!2sco!4v1604524579866!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos cundinamarca1"></div>
                    <div class="opcionNodos cundinamarca2"></div>
                </div>
            </div>

            <div class="Info-nodos valledupar">
                <h3>Valledupar</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Carrera 19 entre Calles 14 y 15</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+035) 5842455</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31387.77702188882!2d-73.27220771897672!3d10.46339775758587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5400161f23447ac7!2sRed%20De%20Tecnoparques%20Sena!5e0!3m2!1ses!2sco!4v1604524699047!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

            </div>

            <div class="Info-nodos Popayan">
                <h3>Popayán</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Calle 5 # 26-00</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+032) 7621468</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1020461.8375583054!2d-77.1814625!3d2.4473781!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e30033e8846ea19%3A0x60b53b7d5c39a2fa!2sBiblioteca%20Parque%20Inform%C3%A1tico%20de%20Ciencia%2C%20Arte%20y%20Tecnolog%C3%ADa!5e0!3m2!1ses-419!2sco!4v1610571016722!5m2!1ses-419!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

            </div>

            <div class="Info-nodos pereira">
                <h3>Pereira</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Carrera 8 No. 26 - 79</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+036) 3135800</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3975.742967373967!2d-75.70282865034092!3d4.8141373419884586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e388747c893ad05%3A0xd5dbbc9ef6f29d!2sTecnoparque%20SENA%20-%20Nodo%20Pereira!5e0!3m2!1ses!2sco!4v1604525067733!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

            </div>

            <div class="Info-nodos manizales">
                <h3>Manizales</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Kilómetro 10 Vía al Magdalena</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+036) 8931720</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3974.4341501872063!2d-75.4524164503406!3d5.033125440070523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4765f44a450491%3A0x5f219cd95fae0516!2sTECNOPARQUE%20SENA%20NODO%20MANIZALES!5e0!3m2!1ses!2sco!4v1604525171461!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

            </div>

            <div class="Info-nodos lagranja">
                <h3>La Granja</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Km 5 Vía Espinal - Ibagué</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+038) 2709600</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.2348368006647!2d-74.92769615034152!3d4.174182547146813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3ed3e7f32bc353%3A0x17c49f902cb02ef7!2sCentro%20Agropecuario%20La%20granja%20Sena!5e0!3m2!1ses!2sco!4v1604525522906!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

            </div>

            <div class="Info-nodos cali">
                <h3>Calí</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Carrera 5 No. 11-68, <br>Plaza de Caicedo Centro de Cali</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+032) 4315800</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.5814419959147!2d-76.53443735034175!3d3.451456252171622!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e30a665ce24e9a5%3A0x91ec224dfd550379!2sTecnoparque%20Sena!5e0!3m2!1ses!2sco!4v1604525619358!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

            </div>

            <div class="Info-nodos angostura">
                <h3>Angostura</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>km 38 vía al sur de Neiva</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+034) 8380191</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d813.4815898505594!2d-75.3615997!3d2.6127947!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b3f4b1c54ddc5%3A0x6a0d5a458d5d190d!2sCentro%20de%20Formaci%C3%B3n%20Agroindustrial%20La%20Angostura!5e1!3m2!1ses-419!2sco!4v1606343813427!5m2!1ses-419!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos huila1"></div>
                    <div class="opcionNodos huila2"></div>
                    <div class="opcionNodos huila3"></div>
                </div>
            </div>

            <div class="Info-nodos neiva">
                <h3>Neiva</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Diagonal 20 Nº 38 -16</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+038) 8757154</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.5633854382395!2d-75.26448515034166!3d2.940982355208341!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b743cf7063ce1%3A0x2e36a406a1af90c3!2sTecnoparque%20SENA%20Neiva!5e0!3m2!1ses!2sco!4v1604525989274!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos huila1"></div>
                    <div class="opcionNodos huila2"></div>
                    <div class="opcionNodos huila3"></div>
                </div>
            </div>

            <div class="Info-nodos pitalito">
                <h3>Pitalito</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Km 7 vía Pitalito,<br> vereda Aguaduas</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+038) 8365960</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.6427630880576!2d-76.09256925034046!3d1.892195760114839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e2572d5f6b3dd1f%3A0x10e75cc78a354f15!2sTecnoparque%207%20Agroecol%C3%B3gico%20Yamboro!5e0!3m2!1ses!2sco!4v1604526043866!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos huila1"></div>
                    <div class="opcionNodos huila2"></div>
                    <div class="opcionNodos huila3"></div>
                </div>
            </div>
            <div class="Info-nodos Cucuta">
                <h3>Cúcuta</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Calle 2N avenida 4 y 5 Pescadero</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+037) 5899990</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.938539721015!2d-72.50548375033188!3d7.901490107775649!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e66456e853423bd%3A0x6bd4a033f6ad90de!2sSENA!5e0!3m2!1ses!2sco!4v1604526121626!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos nor-santa1"></div>
                    <div class="opcionNodos nor-santa2"></div>
                </div>
            </div>
            <div class="Info-nodos Ocaña">
                <h3>Ocaña</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Transversal 30 N° 7-110 La Primavera</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+57) 3187305118</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                        <div class="tex-lienas">
                            <p></p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.4550838067826!2d-73.36102745033021!3d8.2574175028414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e677b9d3b165feb%3A0xd29509ced014fdd0!2sTecnoparque%20Colombia%20Nodo%20Oca%C3%B1a%20-%20SENA!5e0!3m2!1ses!2sco!4v1604526230738!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos nor-santa1"></div>
                    <div class="opcionNodos nor-santa2"></div>
                </div>
            </div>

            <div class="Info-nodos Bucaramanga">
                <h3>Bucaramanga</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Carrera 23 No 39 - 38 Bucaramanga</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+037) 6800600</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.066749550133!2d-73.12118595033506!3d7.118263517914365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e683f57b7db02a9%3A0x2451bd9419408f8b!2sTecnoparque%20Nodo%20Bucaramanga!5e0!3m2!1ses!2sco!4v1604526314470!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos santa1"></div>
                    <div class="opcionNodos santa2"></div>
                </div>
            </div>
            <div class="Info-nodos Socorro">
                <h3>Socorro</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>Calle 16 No. 14-28</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>(+037) 7296851</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>-Electrónica Y Telecomunicaciones</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Tecnologías Virtuales</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>-Biotecnología Y Nanotecnología</p>
                        </div>
                        <div class="tex-lienas">
                            <p>-Ingeniería Y Diseño</p>
                        </div>
                    </div>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.398113747465!2d-73.26326725033722!3d6.471149925543726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e69c2a428797543%3A0xd6755136b807ecce!2sTecnoparque%20Nodo%20SOCORRO!5e0!3m2!1ses!2sco!4v1604526418536!5m2!1ses!2sco"
                    width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                <div class="contenedor-circulos">
                    <div class="opcionNodos santa1"></div>
                    <div class="opcionNodos santa2"></div>
                </div>
            </div>
            <div class="Info-nodos atlanti">
                <h3>Próximamente</h3>
                <div class="dire-telf">
                    <div class="direc">
                        <h5>Dirección</h5>
                        <p>......</p>
                    </div>
                    <div class="telf">
                        <h5>Teléfono</h5>
                        <p>......</p>
                    </div>
                </div>
                <h5>Líneas</h5>
                <div class="caja-lineas">
                    <div class="lineas-1">
                        <div class="tex-lienas">
                            <p>....</p>
                        </div>
                        <div class="tex-lienas">
                            <p>....</p>
                        </div>
                    </div>

                    <div class="lineas-2">
                        <div class="tex-lienas">
                            <p>....</p>
                        </div>
                        <div class="tex-lienas">
                            <p>....</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h1 class="TEX-NODOS">18 NODOS</h1>

    <!---------------------------------------------Nodos Movil----------------------------------->

    <section id="nodos-movil">


        <h1 id="titulo-nodos-movil">Nodos Tecnoparque</h1>

        <!---------------------------------------------------------Regional Antioquia--------------------------------------------------------->

        <h2 id="titulo-regional-antioquia" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Antioquia</h2>

        <!--------------------------Nodo Medellin-------------------------->

        <h3 id="nodo-medellin" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Medellín</h3>

        <div id="contenido-nodo-medellin" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Carrera 46 # 56-11. <br>Edificio TecnoParque, Piso 6-7</p>

                <h5>Teléfono</h5>

                <p>(+57) 3136161591</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.081938605611!2d-75.56509915033787!3d6.252934427963699!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4428f9fc984135%3A0x26cb935662b70fe6!2sTecnoparque%2C%20Cra.%2046%20%23%2356-11%2C%20Medell%C3%ADn%2C%20Antioquia!5e0!3m2!1ses!2sco!4v1604523737194!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!--------------------------Nodo Rionegro-------------------------->

        <h3 id="nodo-rionegro" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Rionegro</h3>

        <div id="contenido-nodo-rionegro" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Calle 41 Nº 50A – 324</p>

                <h5>Teléfono</h5>

                <p>(+034) 5311856</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.8101669316065!2d-75.41799270033815!3d6.156173879012142!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e469e8c0c9bc861%3A0xc299568dcf141f84!2sTecnoParque%20Nodo%20Rionegro!5e0!3m2!1ses!2sco!4v1604524108543!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Atlantico--------------------------------------------------------->

        <h2 id="titulo-regional-atlantico" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Atlántico</h2>

        <h3 id="nodo-proximamente" class="titulos-ciudades-nodos-movil"> Próximamente</h3>

        <!---------------------------------------------------------Regional Caldas--------------------------------------------------------->

        <h2 id="titulo-regional-caldas" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Caldas</h2>

        <!--------------------------Nodo Manizales-------------------------->

        <h3 id="nodo-manizales" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Manizales</h3>

        <div id="contenido-nodo-manizales" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Kilómetro 10 Vía al Magdalena</p>

                <h5>Teléfono</h5>

                <p>(+036) 8931720</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3974.4341501872063!2d-75.4524164503406!3d5.033125440070523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4765f44a450491%3A0x5f219cd95fae0516!2sTECNOPARQUE%20SENA%20NODO%20MANIZALES!5e0!3m2!1ses!2sco!4v1604525171461!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Cauca--------------------------------------------------------->

        <h2 id="titulo-regional-cauca" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Cauca</h2>

        <!--------------------------Nodo Popayan-------------------------->

        <h3 id="nodo-popayan" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Popayán</h3>

        <div id="contenido-nodo-popayan" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Calle 5 # 26-00</p>

                <h5>Teléfono</h5>

                <p>(+032) 7621468</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.1896772932128!2d-76.61511715034123!3d2.4438025577578535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3003172ee1b737%3A0x2846201d404c9acd!2sCasa%20Rosada%20-%20E.S.E.%20Popay%C3%A1n!5e0!3m2!1ses!2sco!4v1604524920972!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Cesar--------------------------------------------------------->

        <h2 id="titulo-regional-cesar" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Cesar</h2>

        <!--------------------------Nodo Valledupar-------------------------->

        <h3 id="nodo-valledupar" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Valledupar</h3>

        <div id="contenido-nodo-valledupar" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Carrera 19 entre Calles 14 y 15</p>

                <h5>Teléfono</h5>

                <p>(+035) 5842455</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31387.77702188882!2d-73.27220771897672!3d10.46339775758587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5400161f23447ac7!2sRed%20De%20Tecnoparques%20Sena!5e0!3m2!1ses!2sco!4v1604524699047!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Cundinamarca--------------------------------------------------------->

        <h2 id="titulo-regional-cundinamarca" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Cundinamarca</h2>

        <!--------------------------Nodo Bogota-------------------------->

        <h3 id="nodo-bogota" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Bogotá DC</h3>

        <div id="contenido-nodo-bogota" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Calle 54 No 10 – 39</p>

                <h5>Teléfono</h5>

                <p>(+031) 5461500</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.740541940642!2d-74.06691985034114!3d4.640307443455449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9a3a0d0f8081%3A0x7f6796e93ed81430!2sSENA%20Tecnoparque!5e0!3m2!1ses!2sco!4v1604524460255!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!--------------------------Nodo Cazuca-------------------------->

        <h3 id="nodo-cazuca" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Cazucá</h3>

        <div id="contenido-nodo-cazuca" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Autopista Sur Transversal 7
                    <br>No 8 – 40.TecnoParque Central</p>

                <h5>Teléfono</h5>

                <p>(+031) 5461600</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3977.0077270600086!2d-74.19345405034123!3d4.592635343849162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9e4bad9214db%3A0x8f5115bb30158afc!2sTecnoParque%20SENA%20Cazuc%C3%A1!5e0!3m2!1ses!2sco!4v1604524579866!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Huila--------------------------------------------------------->

        <h2 id="titulo-regional-huila" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Huila</h2>

        <!--------------------------Nodo Angostura-------------------------->

        <h3 id="nodo-angostura" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Angostura</h3>

        <div id="contenido-nodo-angostura" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>km 38 vía al sur de Neiva</p>

                <h5>Teléfono</h5>

                <p>(+034) 8380191</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingeniería Y Diseño</p>

            </div>
            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d813.4815898505594!2d-75.3615997!3d2.6127947!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b3f4b1c54ddc5%3A0x6a0d5a458d5d190d!2sCentro%20de%20Formaci%C3%B3n%20Agroindustrial%20La%20Angostura!5e1!3m2!1ses-419!2sco!4v1606343813427!5m2!1ses-419!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>

        <!--------------------------Nodo Neiva-------------------------->

        <h3 id="nodo-neiva" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Neiva</h3>

        <div id="contenido-nodo-neiva" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Diagonal 20 Nº 38 -16</p>

                <h5>Teléfono</h5>

                <p>(+038) 8757154</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.5633854382395!2d-75.26448515034166!3d2.940982355208341!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3b743cf7063ce1%3A0x2e36a406a1af90c3!2sTecnoparque%20SENA%20Neiva!5e0!3m2!1ses!2sco!4v1604525989274!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!--------------------------Nodo Pitalito-------------------------->

        <h3 id="nodo-pitalito" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Pitalito</h3>

        <div id="contenido-nodo-pitalito" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Km 7 vía Pitalito,<br>vereda Aguaduas</p>

                <h5>Teléfono</h5>

                <p>(+038) 8365960</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Tecnologías Virtuales</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.6427630880576!2d-76.09256925034046!3d1.892195760114839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e2572d5f6b3dd1f%3A0x10e75cc78a354f15!2sTecnoparque%207%20Agroecol%C3%B3gico%20Yamboro!5e0!3m2!1ses!2sco!4v1604526043866!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Norte de santander--------------------------------------------------------->

        <h2 id="titulo-regional-norte-de-santander" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Norte de Santander</h2>

        <!--------------------------Nodo Cucuta-------------------------->

        <h3 id="nodo-cucuta" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Cúcuta</h3>

        <div id="contenido-nodo-cucuta" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Calle 2N avenida 4 y 5 Pescadero</p>

                <h5>Teléfono</h5>

                <p>(+037) 5899990</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Tecnologías Virtuales</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.938539721015!2d-72.50548375033188!3d7.901490107775649!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e66456e853423bd%3A0x6bd4a033f6ad90de!2sSENA!5e0!3m2!1ses!2sco!4v1604526121626!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!--------------------------Nodo Ocaña-------------------------->

        <h3 id="nodo-ocaña" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Ocaña</h3>

        <div id="contenido-nodo-ocaña" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Transversal 30 N° 7-110 La Primavera</p>

                <h5>Teléfono</h5>

                <p>(+57) 3187305118</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Ingeniería Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.4550838067826!2d-73.36102745033021!3d8.2574175028414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e677b9d3b165feb%3A0xd29509ced014fdd0!2sTecnoparque%20Colombia%20Nodo%20Oca%C3%B1a%20-%20SENA!5e0!3m2!1ses!2sco!4v1604526230738!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Risaralda--------------------------------------------------------->

        <h2 id="titulo-regional-risaralda" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Risaralda</h2>

        <!--------------------------Nodo Pereira-------------------------->

        <h3 id="nodo-pereira" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Pereira</h3>

        <div id="contenido-nodo-pereira" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Carrera 8 No. 26 - 79</p>

                <h5>Teléfono</h5>

                <p>(+036) 3135800</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingenieria Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3975.742967373967!2d-75.70282865034092!3d4.8141373419884586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e388747c893ad05%3A0xd5dbbc9ef6f29d!2sTecnoparque%20SENA%20-%20Nodo%20Pereira!5e0!3m2!1ses!2sco!4v1604525067733!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Santander--------------------------------------------------------->

        <h2 id="titulo-regional-santander" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Santander</h2>

        <!--------------------------Nodo Bucaramanga-------------------------->

        <h3 id="nodo-bucaramanga" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Bucaramanga</h3>

        <div id="contenido-nodo-bucaramanga" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Carrera 23 No 39 - 38 Bucaramanga</p>

                <h5>Teléfono</h5>

                <p>(+037) 6800600</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingenieria Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.066749550133!2d-73.12118595033506!3d7.118263517914365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e683f57b7db02a9%3A0x2451bd9419408f8b!2sTecnoparque%20Nodo%20Bucaramanga!5e0!3m2!1ses!2sco!4v1604526314470!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!--------------------------Nodo Socorro-------------------------->

        <h3 id="nodo-socorro" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Socorro</h3>

        <div id="contenido-nodo-socorro" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Calle 16 No. 14-28</p>

                <h5>Teléfono</h5>

                <p>(+037) 7296851</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingenieria Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.398113747465!2d-73.26326725033722!3d6.471149925543726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e69c2a428797543%3A0xd6755136b807ecce!2sTecnoparque%20Nodo%20SOCORRO!5e0!3m2!1ses!2sco!4v1604526418536!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Tolima--------------------------------------------------------->

        <h2 id="titulo-regional-tolima" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Tolima</h2>

        <!--------------------------Nodo La Granja - tolima-------------------------->

        <h3 id="nodo-granja" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> La Granja - Tolima</h3>

        <div id="contenido-nodo-granja" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Km 5 Vía Espinal - Ibagué</p>

                <h5>Teléfono</h5>

                <p>(+038) 2709600</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Tecnologías Virtuales</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.2348368006647!2d-74.92769615034152!3d4.174182547146813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3ed3e7f32bc353%3A0x17c49f902cb02ef7!2sCentro%20Agropecuario%20La%20granja%20Sena!5e0!3m2!1ses!2sco!4v1604525522906!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>

        <!---------------------------------------------------------Regional Valle del Cauca--------------------------------------------------------->

        <h2 id="titulo-regional-valle-del-cauca" class="titulos-regionales-movil"><i class="fas fa-angle-double-down"></i> Valle del Cauca</h2>

        <!--------------------------Nodo Cali-------------------------->

        <h3 id="nodo-cali" class="titulos-ciudades-nodos-movil"><i class="fas fa-chevron-down"></i> Cali</h3>

        <div id="contenido-nodo-cali" class="contenido-nodo">

            <div class="nodos-movil-direccion-telefono">

                <h5>Dirección</h5>

                <p>Carrera 5 No. 11-68, <br>Plaza de Caicedo Centro de Cali</p>

                <h5>Teléfono</h5>

                <p>(+032) 4315800</p>

            </div>

            <div class="nodos-movil-lineas">

                <h5>Líneas</h5>

                <p>Electrónica Y Telecomunicaciones</p>

                <p>Tecnologías Virtuales</p>

                <p>Biotecnología Y Nanotecnología</p>

                <p>Ingenieria Y Diseño</p>

            </div>

            <iframe class="nodos-movil-mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.5814419959147!2d-76.53443735034175!3d3.451456252171622!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e30a665ce24e9a5%3A0x91ec224dfd550379!2sTecnoparque%20Sena!5e0!3m2!1ses!2sco!4v1604525619358!5m2!1ses!2sco"
                width="400" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

        </div>
    </section>

    </div>



</main>

<div id="area_trabajo_divNoticiaPrincipal" style="background-color: rgba(0, 0, 0, 0.4);z-index: 100000;position: absolute; width: 100%; height: 1215px;"> <div>
    <span style="float:right; z-index:1000; position: fixed; right: 0; margin-right: 55px; margin-top: -70px; cursor: pointer;"> <img height="30" class="modal-close" src="{{asset('img/close.png')}}" title="Cerrar" width="29"> </span>
     <span style="display: block; text-align: center; margin-top: 100px;">
        <a target="_blank" href="">
            <img src="{{asset('img/como_registrarRED.png')}}" style="background-color:  #FFFFFF" width="1000px" height="500px" >
        </a>
    </span>
</div>
 </div>


@endsection

@push('script')
<script type="text/javascript" src="{{ asset('Jquery/InteractividadJquery.js') }}"></script>
<script src="{!! asset('js/pruebaJS.js') !!}"></script>
<script>
$(document).ready(function(){
    $('#area_trabajo_divNoticiaPrincipal').openModal();
});
</script>
@endpush
