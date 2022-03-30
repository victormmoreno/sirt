$(document).ready(function() {

    /* ============== Posiciones y Altos de Secciones =======================*/


    /* ========================== Seccion home=========================================*/

    $(".nodo1").slideDown(1500);
    $(".nodo2").slideDown(2000);
    $(".nodo3").slideDown(2500);
    $(".nodo4").slideDown(3000);
    $(".nodo5").slideDown(3500);

    $(".red-textl").delay(3500).animate({
        top: "100px",
        opacity: "1"
    }, 1000)

    $(".tecno").delay(3700).animate({
        top: "100px",
        opacity: "1"
    }, 1000)

    $(".colom").delay(3900).animate({
            top: "159px",
            opacity: "1"
        }, 1000)
        /*===home cel ===*/

    $(".red-cel").delay(1000).animate({
        top: "50px",
        opacity: "1"
    }, 1000)

    $(".tecno-cel").delay(1500).animate({
        top: "50px",
        opacity: "1"
    }, 1000)

    $(".colom-cel").delay(2000).animate({
            top: "88px",
            opacity: "1"
        }, 1000)
        /* ========================== nodos pasar mapa =========================================*/

    $(".cirnodo1").click(function() {

        $(".medellin").css({
            display: "block"
        });
        $(".bogota, .rionegro, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali, .angostura, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo1").css({
            background: "white"
        });
        $(".cirnodo2, .cirnodo3, .cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });
        $(".antioquia1").css({
            background: "#ff6c00"
        });
        $(".antioquia2").css({
            background: "white"
        });

    });

    $(".cirnodo2").click(function() {

        $(".bogota").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali, .angostura, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo2").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo3, .cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });
        $(".cundinamarca2").css({
            background: "white"
        });
        $(".cundinamarca1").css({
            background: "#ff6c00"
        });


    });

    $(".cirnodo3").click(function() {

        $(".valledupar").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .Popayan, .pereira, .manizales, .lagranja, .cali, .angostura, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo3").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });


    });

    $(".cirnodo4").click(function() {

        $(".Popayan").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar,.pereira, .manizales, .lagranja, .cali, .angostura, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo4").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });


    });

    $(".cirnodo5").click(function() {

        $(".pereira").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar, .Popayan, .manizales, .lagranja, .cali, .angostura, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo5").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });


    });

    $(".cirnodo6").click(function() {

        $(".manizales").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar, .Popayan, .pereira, .lagranja, .cali, .angostura, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo6").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo5, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10 ,.cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });


    });

    $(".cirnodo7").click(function() {

        $(".lagranja").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar, .Popayan, .pereira, .manizales, .cali, .neiva, .pitalito, .angostura, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo7").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo5, .cirnodo6, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });


    });

    $(".cirnodo8").click(function() {

        $(".cali").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .neiva, .pitalito, .angostura, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo8").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo9, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });


    });

    $(".cirnodo9").click(function() {

        $(".angostura").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo9").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo10, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });
        $(".huila1").css({
            background: "#ff6c00"
        });
        $(".huila2, .huila3").css({
            background: "white"
        });

    });

    $(".cirnodo10").click(function() {

        $(".Cucuta").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali, .neiva, .pitalito, .angostura, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo10").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo11, .cirnodo12").css({
            background: "#ff6c00"
        });
        $(".nor-santa1").css({
            background: "#ff6c00"
        });
        $(".nor-santa2").css({
            background: "white"
        });

    });

    $(".cirnodo11").click(function() {

        $(".Bucaramanga").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali, .neiva, .pitalito, .angostura, .Ocaña, .Cucuta, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".cirnodo11").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo12").css({
            background: "#ff6c00"
        });
        $(".santa2").css({
            background: "white"
        });
        $(".santa1").css({
            background: "#ff6c00"
        });

    });
    $(".cirnodo12").click(function() {

        $(".atlanti").css({
            display: "block"
        });
        $(".medellin ,.rionegro, .bogota, .valledupar,.pereira, .manizales, .lagranja, .cali, .angostura, .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .Popayan").css({
            display: "none"
        });
        $(".cirnodo12").css({
            background: "white"
        });
        $(".cirnodo1, .cirnodo2, .cirnodo3,.cirnodo4, .cirnodo5, .cirnodo6, .cirnodo7, .cirnodo8, .cirnodo9, .cirnodo10, .cirnodo11").css({
            background: "#ff6c00"
        });


    });


    /* ========================== nodos pasar entre nodos=========================================*/

    $(".antioquia1").click(function() {

        $(".medellin").css({
            display: "block"
        });
        $(".rionegro ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali, .neiva, .pitalito, .angostura, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".antioquia2").css({
            background: "white"
        });
        $(".antioquia1").css({
            background: "#ff6c00"
        });


    });

    $(".antioquia2").click(function() {

        $(".rionegro").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali, .neiva, .pitalito, .angostura, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".antioquia1").css({
            background: "white"
        });
        $(".antioquia2").css({
            background: "#ff6c00"
        });
    });



    $(".huila1").click(function() {

        $(".angostura").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali , .neiva, .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".huila2, .huila3").css({
            background: "white"
        });
        $(".huila1").css({
            background: "#ff6c00"
        });
    });

    $(".huila2").click(function() {

        $(".neiva").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura , .pitalito, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".huila1, .huila3").css({
            background: "white"
        });
        $(".huila2").css({
            background: "#ff6c00"
        });
    });

    $(".huila3").click(function() {

        $(".pitalito").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura ,.neiva, .Cucuta, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".huila2, .huila1").css({
            background: "white"
        });
        $(".huila3").css({
            background: "#ff6c00"
        });
    });
    $(".nor-santa1").click(function() {

        $(".Cucuta").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura ,.neiva, .Ocaña, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".nor-santa2").css({
            background: "white"
        });
        $(".nor-santa1").css({
            background: "#ff6c00"
        });
    });
    $(".nor-santa2").click(function() {

        $(".Ocaña").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura ,.neiva, .Cucuta, .Bucaramanga, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".nor-santa1").css({
            background: "white"
        });
        $(".nor-santa2").css({
            background: "#ff6c00"
        });
    });

    $(".santa1").click(function() {

        $(".Bucaramanga").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura ,.neiva, .Cucuta, .Ocaña, .Socorro, .Cazuca, .atlanti").css({
            display: "none"
        });
        $(".santa2").css({
            background: "white"
        });
        $(".santa1").css({
            background: "#ff6c00"
        });
    });

    $(".santa2").click(function() {

        $(".Socorro").css({
            display: "block"
        });
        $(".medellin ,.bogota, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura ,.neiva, .Cucuta, .Ocaña, .Bucaramanga, .Cazuca, .atlanti ").css({
            display: "none"
        });
        $(".santa1").css({
            background: "white"
        });
        $(".santa2").css({
            background: "#ff6c00"
        });
    });

    $(".cundinamarca1").click(function() {

        $(".bogota").css({
            display: "block"
        });
        $(".medellin , .Socorro, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura ,.neiva, .Cucuta, .Ocaña, .Bucaramanga, .Cazuca, .atlanti ").css({
            display: "none"
        });
        $(".cundinamarca2").css({
            background: "white"
        });
        $(".cundinamarca1").css({
            background: "#ff6c00"
        });
    });

    $(".cundinamarca2").click(function() {

        $(".Cazuca").css({
            display: "block"
        });
        $(".medellin , .Socorro, .valledupar, .Popayan, .pereira, .manizales, .lagranja, .cali ,.angostura ,.neiva, .Cucuta, .Ocaña, .Bucaramanga, .bogota, .atlanti").css({
            display: "none"
        });
        $(".cundinamarca1").css({
            background: "white"
        });
        $(".cundinamarca2").css({
            background: "#ff6c00"
        });
    });
    /*------------animacion 17nodos------------------------- */
    $(window).scroll(function() {

        var altoseccionnodos = $("#Nodos").offset().top;
        console.log(altoseccionnodos);

        var posicionhtml = $(window).scrollTop();
        console.log(posicionhtml);

        if (posicionhtml >= altoseccionnodos) {
            $(".TEX-NODOS").animate({
                left: "100px",
                opacity: "1"
            }, 1000)
        }

    });



    /* == Slider ==*/

    /* == Hacer el slider dinamico ==*/

    var imgItems = $(".slider-escritorio li").length; //Conseguir el numero de elementos
    var imgPos = 1;



    //Hacer paginacion(Agregar cirulos/enlaces segun el # de imgs o elementos)

    for (i = 1; i <= imgItems; i++) {

        $(".paginacion").append('<li><span class="fas fa-circle"></span></i></li>')
            /* == append para agregar elementos en el html==*/

    }

    $(".slider-escritorio li").hide() //ocultar elementos

    $(".slider-escritorio li:first").show() // mostrar primer elemento

    $(".paginacion li:first").css({ "color": "white" }) // Dar estilos al primer item de los enlaces

    /* == ejecutar funciones  ==*/

    $(".paginacion li").click(pagination)

    setInterval(function() {
        nextSlider()
    }, 10000)

    /* == Funcion pasar con enlaces/circulos  ==*/

    function pagination() {

        var paginationPosition = $(this).index() + 1; // Conseguir el numero en el que esta la img o elementos
        // al que se le ha dado click (".paginacion li" para este caso)
        //console.log(paginationPosition)

        $(".slider-escritorio li").hide(); //Ocultar Imgs o Elementos

        $(".slider-escritorio li:nth-child(" + paginationPosition + ")").fadeIn("slow"); // Mostrar el elemento correspondiente
        //a cada enlace/circulo

        $(".paginacion li").css({ "color": "rgba(255, 255, 255, 0.5)" }) //Dar color general a los enlaces/circulos no activos

        $(this).css({ "color": "white" }) // Dar color diferencial al enlace/circulo activo

        imgPos = paginationPosition; // Igualar variables para que el automatico funcione correctamente

    }

    function nextSlider() {

        //Condicional

        if (imgPos >= imgItems) {
            imgPos = 1;
        } else {
            imgPos++;
        }

        //console.log(imgPos)

        $(".slider-escritorio li").hide(); //Ocultar Imgs o Elementos

        $(".slider-escritorio li:nth-child(" + imgPos + ")").fadeIn("slow"); // Mostrar el elemento correspondiente
        //a cada enlace/circulo

        $(".paginacion li").css({ "color": "rgba(255, 255, 255, 0.5)" }) //Dar color general a los enlaces/circulos no activos

        $(".paginacion li:nth-child(" + imgPos + ")").css({ "color": "white" }) // Dar color diferencial al enlace/circulo activo
    }

    /* ============== Interactividad en seccion Video =======================*/

    /* == Aparecer titulo ==*/

    $(window).scroll(function() {

        var altoseccionvideo = $("#video").offset().top;
        console.log(altoseccionvideo);


        var posicionhtml = $(window).scrollTop();
        console.log(posicionhtml);

        if (posicionhtml >= altoseccionvideo - 100) {
            $("#titulo-seccion-video").slideDown("slow")
        }

    })

    /* == Slider-cel ==*/

    /* == Hacer el slider dinamico ==*/

    var imgItemscel = $(".slider-cel li").length; //Conseguir el numero de elementos
    var imgPoscel = 1;



    //Hacer paginacion(Agregar cirulos/enlaces segun el # de imgs o elementos)

    for (c = 1; c <= imgItemscel; c++) {

        $(".paginacion-cel").append('<li><span class="fas fa-circle"></span></i></li>')
            /* == append para agregar elementos en el html==*/

    }

    $(".slider-cel li").hide() //ocultar elementos

    $(".slider-cel li:first").show() // mostrar primer elemento

    $(".paginacion-cel li:first").css({ "color": "white" }) // Dar estilos al primer item de los enlaces

    /* == ejecutar funciones  ==*/

    $(".paginacion-cel li").click(paginationcel)

    setInterval(function() {
        nextSlidercel()
    }, 10000)

    /* == Funcion pasar con enlaces/circulos  ==*/

    function paginationcel() {

        var paginationPositioncel = $(this).index() + 1; // Conseguir el numero en el que esta la img o elementos
        // al que se le ha dado click (".paginacion li" para este caso)
        //console.log(paginationPosition)

        $(".slider-cel li").hide(); //Ocultar Imgs o Elementos

        $(".slider-cel li:nth-child(" + paginationPositioncel + ")").fadeIn("slow"); // Mostrar el elemento correspondiente
        //a cada enlace/circulo

        $(".paginacion-cel li").css({ "color": "rgba(255, 255, 255, 0.5)" }) //Dar color general a los enlaces/circulos no activos

        $(this).css({ "color": "white" }) // Dar color diferencial al enlace/circulo activo

        imgPoscel = paginationPositioncel; // Igualar variables para que el automatico funcione correctamente

    }

    function nextSlidercel() {

        //Condicional

        if (imgPoscel >= imgItemscel) {
            imgPoscel = 1;
        } else {
            imgPoscel++;
        }

        //console.log(imgPos)

        $(".slider-cel li").hide(); //Ocultar Imgs o Elementos

        $(".slider-cel li:nth-child(" + imgPoscel + ")").fadeIn("slow"); // Mostrar el elemento correspondiente
        //a cada enlace/circulo

        $(".paginacion-cel li").css({ "color": "rgba(255, 255, 255, 0.5)" }) //Dar color general a los enlaces/circulos no activos

        $(".paginacion-cel li:nth-child(" + imgPoscel + ")").css({ "color": "white" }) // Dar color diferencial al enlace/circulo activo
    }

    /* == Slider-tab ==*/

    /* == Hacer el slider dinamico ==*/

    var imgItemstab = $(".slider-tab li").length; //Conseguir el numero de elementos
    var imgPostab = 1;



    //Hacer paginacion(Agregar cirulos/enlaces segun el # de imgs o elementos)

    for (t = 1; t <= imgItemstab; t++) {

        $(".paginacion-tab").append('<li><span class="fas fa-circle"></span></i></li>')
            /* == append para agregar elementos en el html==*/

    }

    $(".slider-tab li").hide() //ocultar elementos

    $(".slider-tab li:first").show() // mostrar primer elemento

    $(".paginacion-tab li:first").css({ "color": "white" }) // Dar estilos al primer item de los enlaces

    /* == ejecutar funciones  ==*/

    $(".paginacion-tab li").click(paginationtab)

    setInterval(function() {
        nextSlidertab()
    }, 10000)

    /* == Funcion pasar con enlaces/circulos  ==*/

    function paginationtab() {

        var paginationPositiontab = $(this).index() + 1; // Conseguir el numero en el que esta la img o elementos
        // al que se le ha dado click (".paginacion li" para este caso)
        //console.log(paginationPosition)

        $(".slider-tab li").hide(); //Ocultar Imgs o Elementos

        $(".slider-tab li:nth-child(" + paginationPositiontab + ")").fadeIn("slow"); // Mostrar el elemento correspondiente
        //a cada enlace/circulo

        $(".paginacion-tab li").css({ "color": "rgba(255, 255, 255, 0.5)" }) //Dar color general a los enlaces/circulos no activos

        $(this).css({ "color": "white" }) // Dar color diferencial al enlace/circulo activo

        imgPostab = paginationPositiontab; // Igualar variables para que el automatico funcione correctamente

    }

    function nextSlidertab() {

        //Condicional

        if (imgPostab >= imgItemstab) {
            imgPostab = 1;
        } else {
            imgPostab++;
        }

        //console.log(imgPos)

        $(".slider-tab li").hide(); //Ocultar Imgs o Elementos

        $(".slider-tab li:nth-child(" + imgPostab + ")").fadeIn("slow"); // Mostrar el elemento correspondiente
        //a cada enlace/circulo

        $(".paginacion-tab li").css({ "color": "rgba(255, 255, 255, 0.5)" }) //Dar color general a los enlaces/circulos no activos

        $(".paginacion-tab li:nth-child(" + imgPostab + ")").css({ "color": "white" }) // Dar color diferencial al enlace/circulo activo
    }

    /* ============== Interactividad en seccion Video =======================*/

    /* == Aparecer titulo ==*/

    $(window).scroll(function() {

        var altoseccionvideo = $("#video").offset().top;
        console.log(altoseccionvideo);


        var posicionhtml = $(window).scrollTop();
        console.log(posicionhtml);

        if (posicionhtml >= altoseccionvideo - 100) {
            $("#titulo-seccion-video").slideDown("slow")
        }

    })



    /* ============== Interactividad en seccion lineas =======================*/

    $(window).scroll(function() {

        var posicionhtml = $(window).scrollTop();
        console.log(posicionhtml);

        if (posicionhtml >= 200) {

            /* == Bajar lineas ==*/

            $("#caja-texto-2").animate({
                height: "100%"
            }, 1500)

            /* == Aparecer Caja Iconos ==*/

            $("#iconos").delay(500).animate({
                opacity: "1"
            }, 1500)

            /* == Animacion linea ==*/

            $("#lineas-texto hr").delay(1200).animate({
                width: "10%"
            })

            /* == Desplazar Iconos ==*/

            $("#icono1").delay(1000).animate({
                marginLeft: "0%"
            }, 1500)

            $("#icono2").delay(2000).animate({
                marginLeft: "0%"
            }, 1500)

            $("#icono3").delay(1500).animate({
                marginLeft: "0%"
            }, 1500)

            $("#icono4").delay(2500).animate({
                marginLeft: "0%"
            }, 1500)

        }

    })

    /* ============== Mostrar descripcion lineas =======================*/

    $("#descripcion-linea1").slideDown()

    $("#caja-icono1").click(function() {
        $("#descripcion-linea1").delay(500).slideDown("slow");
        $("#descripcion-linea2").slideUp("slow");
        $("#descripcion-linea3").slideUp("slow");
        $("#descripcion-linea4").slideUp("slow");
    })


    $("#caja-icono2").click(function() {
        $("#descripcion-linea2").delay(500).slideDown("slow");
        $("#descripcion-linea1").slideUp("slow");
        $("#descripcion-linea3").slideUp("slow");
        $("#descripcion-linea4").slideUp("slow");
    })

    $("#caja-icono3").click(function() {
        $("#descripcion-linea3").delay(500).slideDown("slow");
        $("#descripcion-linea1").slideUp("slow");
        $("#descripcion-linea2").slideUp("slow");
        $("#descripcion-linea4").slideUp("slow");
    })

    $("#caja-icono4").click(function() {
        $("#descripcion-linea4").delay(500).slideDown("slow");
        $("#descripcion-linea1").slideUp("slow");
        $("#descripcion-linea2").slideUp("slow");
        $("#descripcion-linea3").slideUp("slow");
    })

    /* == Mostrar y esconder descripcion de las lineas ==*/
    /* =========================== Nodos movil ====================================*/

    /* ============ Mostrar los nodos por regional ============*/

    /* == variables Contadores Regionales ==*/

    var iantioquia = 1;

    var iatlantico = 1;

    var icaldas = 1;

    var icauca = 1;

    var icesar = 1;

    var icundinamarca = 1;

    var ihuila = 1;

    var inortesantander = 1;

    var irisaralda = 1;

    var isantander = 1;

    var itolima = 1;

    var ivalledelcauca = 1;

    /* == Mostrar nodos de antioquia ==*/

    $("#titulo-regional-antioquia").click(function() {

            //console.log(iantioquia)

            if (iantioquia == 1) {
                $("#nodo-medellin").slideDown("slow");
                $("#nodo-rionegro").slideDown("slow");
                iantioquia++
            } else {
                $("#contenido-nodo-medellin").slideUp("slow");
                $("#contenido-nodo-rionegro").slideUp("slow");
                $("#nodo-medellin").delay(500).slideUp("slow");
                $("#nodo-rionegro").delay(500).slideUp("slow");
                inodomedellin = 1
                inodorionegro = 1
                iantioquia = 1
            }

        })
        /* == Mostrar nodos de atlantico ==*/

    $("#titulo-regional-atlantico").click(function() {

        //console.log(iatlantico)

        if (iatlantico == 1) {
            $("#nodo-proximamente").slideDown("slow");
            iatlantico++
        } else {
            $("#nodo-proximamente").slideUp("slow");
            iatlantico = 1
        }

    })

    /* == Mostrar nodos de caldas ==*/

    $("#titulo-regional-caldas").click(function() {

        //console.log(icaldas)

        if (icaldas == 1) {
            $("#nodo-manizales").slideDown("slow");
            icaldas++
        } else {
            $("#contenido-nodo-manizales").slideUp("slow");
            $("#nodo-manizales").delay(500).slideUp("slow");
            inodomanizales = 1
            icaldas = 1
        }

    })

    /* == Mostrar nodos de cauca ==*/

    $("#titulo-regional-cauca").click(function() {

        //console.log(icauca)

        if (icauca == 1) {
            $("#nodo-popayan").slideDown("slow");
            icauca++
        } else {
            $("#contenido-nodo-popayan").slideUp("slow");
            $("#nodo-popayan").delay(500).slideUp("slow");
            inodopopayan = 1
            icauca = 1
        }

    })

    /* == Mostrar nodos de cesar ==*/

    $("#titulo-regional-cesar").click(function() {

        //console.log(icesar)

        if (icesar == 1) {
            $("#nodo-valledupar").slideDown("slow");
            icesar++
        } else {
            $("#contenido-nodo-valledupar").slideUp("slow");
            $("#nodo-valledupar").delay(500).slideUp("slow");
            inodovalledupar = 1
            icesar = 1
        }

    })

    /* == Mostrar nodos de cundinamarca ==*/

    $("#titulo-regional-cundinamarca").click(function() {

        //console.log(icundinamarca)

        if (icundinamarca == 1) {
            $("#nodo-bogota").slideDown("slow");
            $("#nodo-cazuca").slideDown("slow");
            icundinamarca++
        } else {
            $("#contenido-nodo-bogota").slideUp("slow");
            $("#contenido-nodo-cazuca").slideUp("slow");
            $("#nodo-bogota").delay(500).slideUp("slow");
            $("#nodo-cazuca").delay(500).slideUp("slow");
            inodobogota = 1
            inodocazuca = 1
            icundinamarca = 1
        }

    })

    /* == Mostrar nodos de huila ==*/

    $("#titulo-regional-huila").click(function() {

        //console.log(ihuila)

        if (ihuila == 1) {
            $("#nodo-angostura").slideDown("slow");
            $("#nodo-neiva").slideDown("slow");
            $("#nodo-pitalito").slideDown("slow");
            ihuila++
        } else {
            $("#contenido-nodo-angostura").slideUp("slow");
            $("#contenido-nodo-neiva").slideUp("slow");
            $("#contenido-nodo-pitalito").slideUp("slow");
            $("#nodo-angostura").delay(500).slideUp("slow");
            $("#nodo-neiva").delay(500).slideUp("slow");
            $("#nodo-pitalito").delay(500).slideUp("slow");
            inodoangostura = 1
            inodoneiva = 1
            inodopitalito = 1
            ihuila = 1
        }

    })

    /* == Mostrar nodos de nortesantander ==*/

    $("#titulo-regional-norte-de-santander").click(function() {

        //console.log(inortesantander)

        if (inortesantander == 1) {
            $("#nodo-cucuta").slideDown("slow");
            $("#nodo-ocaña").slideDown("slow");
            inortesantander++
        } else {
            $("#contenido-nodo-cucuta").slideUp("slow");
            $("#contenido-nodo-ocaña").slideUp("slow");
            $("#nodo-cucuta").delay(500).slideUp("slow");
            $("#nodo-ocaña").delay(500).slideUp("slow");
            inodocucuta = 1
            inodoocaña = 1
            inortesantander = 1
        }

    })

    /* == Mostrar nodos de risaralda ==*/

    $("#titulo-regional-risaralda").click(function() {

        //console.log(irisaralda)

        if (irisaralda == 1) {
            $("#nodo-pereira").slideDown("slow");
            irisaralda++
        } else {
            $("#contenido-nodo-pereira").slideUp("slow");
            $("#nodo-pereira").delay(500).slideUp("slow");
            inodopereira = 1
            irisaralda = 1
        }

    })

    /* == Mostrar nodos de santander ==*/

    $("#titulo-regional-santander").click(function() {

        //console.log(isantander)

        if (isantander == 1) {
            $("#nodo-bucaramanga").slideDown("slow");
            $("#nodo-socorro").slideDown("slow");
            isantander++
        } else {
            $("#contenido-nodo-bucaramanga").slideUp("slow");
            $("#contenido-nodo-socorro").slideUp("slow");
            $("#nodo-bucaramanga").delay(500).slideUp("slow");
            $("#nodo-socorro").delay(500).slideUp("slow");
            inodobucaramanga = 1
            inodosocorro = 1
            isantander = 1
        }

    })

    /* == Mostrar nodos de tolima ==*/

    $("#titulo-regional-tolima").click(function() {

        //console.log(itolima)

        if (itolima == 1) {
            $("#nodo-granja").slideDown("slow");
            itolima++
        } else {
            $("#contenido-nodo-granja").slideUp("slow");
            $("#nodo-granja").delay(500).slideUp("slow");
            inodogranja = 1
            itolima = 1
        }

    })

    /* == Mostrar nodos de valle del cauca ==*/

    $("#titulo-regional-valle-del-cauca").click(function() {

        //console.log(ivalledelcauca)

        if (ivalledelcauca == 1) {
            $("#nodo-cali").slideDown("slow");
            ivalledelcauca++
        } else {
            $("#contenido-nodo-cali").slideUp("slow");
            $("#nodo-cali").delay(500).slideUp("slow");
            inodocali = 1
            ivalledelcauca = 1
        }

    })

    /* ============ Mostrar caracteristicas de los nodos ============*/

    /* == variables Contadores Nodos ==*/

    var inodomedellin = 1;

    var inodorionegro = 1;

    var inodomanizales = 1;

    var inodopopayan = 1;

    var inodovalledupar = 1;

    var inodobogota = 1;

    var inodocazuca = 1;

    var inodoangostura = 1;

    var inodoneiva = 1;

    var inodopitalito = 1;

    var inodocucuta = 1;

    var inodoocaña = 1;

    var inodopereira = 1;

    var inodobucaramanga = 1;

    var inodosocorro = 1;

    var inodogranja = 1;

    var inodocali = 1;

    /* == Mostrar caracteristicas del nodo medellin ==*/

    $("#nodo-medellin").click(function() {

        //console.log(inodomedellin)

        if (inodomedellin == 1) {
            $("#contenido-nodo-medellin").slideDown("slow");
            inodomedellin++
        } else {
            $("#contenido-nodo-medellin").slideUp("slow");
            inodomedellin = 1
        }

    })

    /* == Mostrar caracteristicas del nodo rionegro ==*/

    $("#nodo-rionegro").click(function() {

        //console.log(inodorionegro)

        if (inodorionegro == 1) {
            $("#contenido-nodo-rionegro").slideDown("slow");
            inodorionegro++
        } else {
            $("#contenido-nodo-rionegro").slideUp("slow");
            inodorionegro = 1
        }

    })

    /* == Mostrar caracteristicas del nodo manizales ==*/

    $("#nodo-manizales").click(function() {

        //console.log(inodomanizales)

        if (inodomanizales == 1) {
            $("#contenido-nodo-manizales").slideDown("slow");
            inodomanizales++
        } else {
            $("#contenido-nodo-manizales").slideUp("slow");
            inodomanizales = 1
        }

    })

    /* == Mostrar caracteristicas del nodo popayan ==*/

    $("#nodo-popayan").click(function() {

        //console.log(inodopopayan)

        if (inodopopayan == 1) {
            $("#contenido-nodo-popayan").slideDown("slow");
            inodopopayan++
        } else {
            $("#contenido-nodo-popayan").slideUp("slow");
            inodopopayan = 1
        }

    })

    /* == Mostrar caracteristicas del nodo valledupar ==*/

    $("#nodo-valledupar").click(function() {

        //console.log(inodovalledupar)

        if (inodovalledupar == 1) {
            $("#contenido-nodo-valledupar").slideDown("slow");
            inodovalledupar++
        } else {
            $("#contenido-nodo-valledupar").slideUp("slow");
            inodovalledupar = 1
        }

    })

    /* == Mostrar caracteristicas del nodo bogota ==*/

    $("#nodo-bogota").click(function() {

        //console.log(inodobogota)

        if (inodobogota == 1) {
            $("#contenido-nodo-bogota").slideDown("slow");
            inodobogota++
        } else {
            $("#contenido-nodo-bogota").slideUp("slow");
            inodobogota = 1
        }

    })

    /* == Mostrar caracteristicas del nodo cazuca ==*/

    $("#nodo-cazuca").click(function() {

        //console.log(inodocazuca)

        if (inodocazuca == 1) {
            $("#contenido-nodo-cazuca").slideDown("slow");
            inodocazuca++
        } else {
            $("#contenido-nodo-cazuca").slideUp("slow");
            inodocazuca = 1
        }

    })

    /* == Mostrar caracteristicas del nodo angostura ==*/

    $("#nodo-angostura").click(function() {

        //console.log(inodoangostura)

        if (inodoangostura == 1) {
            $("#contenido-nodo-angostura").slideDown("slow");
            inodoangostura++
        } else {
            $("#contenido-nodo-angostura").slideUp("slow");
            inodoangostura = 1
        }

    })

    /* == Mostrar caracteristicas del nodo neiva ==*/

    $("#nodo-neiva").click(function() {

        //console.log(inodoneiva)

        if (inodoneiva == 1) {
            $("#contenido-nodo-neiva").slideDown("slow");
            inodoneiva++
        } else {
            $("#contenido-nodo-neiva").slideUp("slow");
            inodoneiva = 1
        }

    })

    /* == Mostrar caracteristicas del nodo pitalito ==*/

    $("#nodo-pitalito").click(function() {

        //console.log(inodopitalito)

        if (inodopitalito == 1) {
            $("#contenido-nodo-pitalito").slideDown("slow");
            inodopitalito++
        } else {
            $("#contenido-nodo-pitalito").slideUp("slow");
            inodopitalito = 1
        }

    })

    /* == Mostrar caracteristicas del nodo cucuta ==*/

    $("#nodo-cucuta").click(function() {

        //console.log(inodocucuta)

        if (inodocucuta == 1) {
            $("#contenido-nodo-cucuta").slideDown("slow");
            inodocucuta++
        } else {
            $("#contenido-nodo-cucuta").slideUp("slow");
            inodocucuta = 1
        }

    })

    /* == Mostrar caracteristicas del nodo ocaña ==*/

    $("#nodo-ocaña").click(function() {

        //console.log(inodoocaña)

        if (inodoocaña == 1) {
            $("#contenido-nodo-ocaña").slideDown("slow");
            inodoocaña++
        } else {
            $("#contenido-nodo-ocaña").slideUp("slow");
            inodoocaña = 1
        }

    })

    /* == Mostrar caracteristicas del nodo pereira ==*/

    $("#nodo-pereira").click(function() {

        //console.log(inodopereira)

        if (inodopereira == 1) {
            $("#contenido-nodo-pereira").slideDown("slow");
            inodopereira++
        } else {
            $("#contenido-nodo-pereira").slideUp("slow");
            inodopereira = 1
        }

    })

    /* == Mostrar caracteristicas del nodo bucaramanga ==*/

    $("#nodo-bucaramanga").click(function() {

        //console.log(inodobucaramanga)

        if (inodobucaramanga == 1) {
            $("#contenido-nodo-bucaramanga").slideDown("slow");
            inodobucaramanga++
        } else {
            $("#contenido-nodo-bucaramanga").slideUp("slow");
            inodobucaramanga = 1
        }

    })

    /* == Mostrar caracteristicas del nodo socorro ==*/

    $("#nodo-socorro").click(function() {

        //console.log(inodosocorro)

        if (inodosocorro == 1) {
            $("#contenido-nodo-socorro").slideDown("slow");
            inodosocorro++
        } else {
            $("#contenido-nodo-socorro").slideUp("slow");
            inodosocorro = 1
        }

    })

    /* == Mostrar caracteristicas del nodo la granja ==*/

    $("#nodo-granja").click(function() {

        //console.log(inodogranja)

        if (inodogranja == 1) {
            $("#contenido-nodo-granja").slideDown("slow");
            inodogranja++
        } else {
            $("#contenido-nodo-granja").slideUp("slow");
            inodogranja = 1
        }

    })

    /* == Mostrar caracteristicas del nodo cali ==*/

    $("#nodo-cali").click(function() {

        //console.log(inodocali)

        if (inodocali == 1) {
            $("#contenido-nodo-cali").slideDown("slow");
            inodocali++
        } else {
            $("#contenido-nodo-cali").slideUp("slow");
            inodocali = 1
        }
    })
});
