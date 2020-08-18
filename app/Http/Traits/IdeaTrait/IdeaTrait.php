<?php

namespace App\Http\Traits\IdeaTrait;

use App\Models\EstadoIdea;
use App\Models\Nodo;
use App\Models\Proyecto;
use App\Models\RutaModel;
use App\Models\Comite;
use App\Models\Gestor;

trait IdeaTrait
{

    /**
     * Relación a la tabla de proyectos
     */
    public function proyecto()
    {
        return $this->hasOne(Proyecto::class, 'idea_id', 'id');
    }

    public function estadoIdea()
    {
        return $this->belongsTo(EstadoIdea::class, 'estadoidea_id', 'id');
    }

    public function gestor()
    {
        return $this->belongsTo(Gestor::class, 'gestor_id', 'id');
    }

    public function comites()
    {
        return $this->belongsToMany(Comite::class, 'comite_idea')
            ->withTimestamps()
            ->withPivot(['hora', 'admitido', 'asistencia', 'observaciones', 'direccion']);
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function rutamodel()
    {
        return $this->morphOne(RutaModel::class, 'model');
    }

    public function getNombreCompletoAttribute()
    {
        return ucfirst($this->nombres_contacto) . ' ' . ucfirst($this->apellidos_contacto);
    }


    /*=========================================
  =            asesores eloquent            =
  =========================================*/

    public function getNombresContactoAttribute($nombres_contacto)
    {
        return ucfirst(trim($nombres_contacto));
    }

    public function getApellidosContactoAttribute($apellidos_contacto)
    {
        return ucfirst(trim($apellidos_contacto));
    }

    public function getCorreoContactoAttribute($correo_contacto)
    {
        return mb_strtolower(trim($correo_contacto), 'UTF-8');
    }

    public function getTelefonoContactoAttribute($telefono_contacto)
    {
        return trim($telefono_contacto);
    }

    public function getNombreProyectoAttribute($nombre_proyecto)
    {
        return ucfirst(trim($nombre_proyecto));
    }
    public function getDescripcionAttribute($descripcion)
    {
        return ucfirst(trim($descripcion));
    }
    public function getObjetivoAttribute($objetivo)
    {
        return ucfirst(trim($objetivo));
    }

    public function getAlcanceAttribute($alcance)
    {
        return ucfirst(trim($alcance));
    }

    /*=====  End of asesores eloquent  ======*/

    /*========================================
  =            mutador eloquent            =
  ========================================*/
    public function setNombresContactoAttribute($nombres_contacto)
    {
        $this->attributes['nombres_contacto'] = ucfirst(trim($nombres_contacto));
    }

    public function setApellidosContactoAttribute($apellidos_contacto)
    {
        $this->attributes['apellidos_contacto'] = ucfirst(trim($apellidos_contacto));
    }

    public function setCorreoContactoAttribute($correo_contacto)
    {
        $this->attributes['correo_contacto'] = mb_strtolower(trim($correo_contacto), 'UTF-8');
    }

    public function setTelefonoContactoAttribute($telefono_contacto)
    {
        $this->attributes['telefono_contacto'] = trim($telefono_contacto);
    }

    public function setNombreProyectoAttribute($nombre_proyecto)
    {
        $this->attributes['nombre_proyecto'] = ucfirst(trim($nombre_proyecto));
    }

    public function setDescripcionAttribute($descripcion)
    {
        $this->attributes['descripcion'] = ucfirst(trim($descripcion));
    }

    public function setObjtivoAttribute($objetivo)
    {
        $this->attributes['objetivo'] = ucfirst(trim($objetivo));
    }

    public function setAlcanceAttribute($alcance)
    {
        $this->attributes['alcance'] = ucfirst(trim($alcance));
    }
    /*=====  End of mutador eloquent  ======*/

    //metodo para retorar el valor string de la primera preunta de registro de ideas
    public static function preguntaUno(int $question)
    {

        switch ($question) {
            case 1:
                return "Tengo el problema identificado, pero no tengo claro que producto debo desarrollar para resolverlo";
                break;
            case 2:
                return "Tengo la idea del producto que quiero desarrollar pero no sé cómo hacerlo.";
                break;
            case 3:
                return "Tengo la idea del producto que quiero desarrollar, tengo los conocimientos para hacerlo, pero no se qué pasos seguir para formular el proyecto.";
                break;
            case 4:
                return "Tengo formulado el proyecto para desarrollar mi producto: tengo claros los objetivos, el alcance, los recursos y las actividades que debo realizar para conseguirlo, entre otros.";
                break;
            case 5:
                return " Mi proyecto está formulado y ya comencé la ejecución, pero necesito gestionar algunos recursos para poder avanzar.";
                break;
            case 6:
                return "Ya tengo un prototipo avanzado de mi producto y requiero gestionar algunos recursos para concluir mi proyecto.";
                break;
            case 7:
                return "Ya tengo un prototipo final, he realizado pruebas y ajustes, tengo planteada la idea de negocio y requiero gestionar algunos recursos para implementarla.";
                break;
            case 8:
                return "No voy a desarrollar un producto, voy a comercializar un producto de otro fabricante.";
                break;
            case 9:
                return "Quiero desarrollar una página web para promocionar mi negocio actual.";
                break;
            default:
                return "No registra";
                break;
        }
    }

    //metodo para retorar el valor string de la segunda preunta de registro de ideas
    public static function preguntaDos(int $question)
    {

        switch ($question) {
            case 1:
                return "No tengo equipo de trabajo, yo solo me encargaré de desarrollar el producto.";
                break;
            case 2:
                return "Tengo un equipo de trabajo que cuenta con los conocimientos técnicos mínimos para el desarrollo del producto, pero no contamos con los conocimientos de mercadeo para la implementación de la idea de negocio";
                break;
            case 3:
                return "Tengo un equipo de trabajo que cuenta con los conocimientos de mercadeo mínimos para la implementación de la idea de negocio, pero no contamos con los conocimientos técnicos para desarrollar el producto";
                break;
            case 4:
                return "Tengo un equipo de trabajo multidisciplinar, que cuenta con los conocimientos técnicos, conocimientos de gestión y conocimientos de mercadeo necesarios para el desarrollo del producto y la implementación de la idea de negocio.";
                break;
            default:
                return "No registra";
                break;
        }
    }

    //metodo para retorar el valor string de la tercera preunta de registro de ideas
    public static function preguntaTres(int $question)
    {

        switch ($question) {
            case 1:
                return "Tecnologías Virtuales: desarrollo de software para diferentes dispositivos, animaciones 2D y 3D, creación de contenidos para aplicaciones, animaciones y videojuegos.";
                break;
            case 2:
                return "Biotecnología: utilización de organismos vivos o sus derivados para el desarrollo de productos y/o procesos en las áreas de ambiente, alimentos y nanotecnología.";
                break;
            case 3:
                return "Electrónica y Telecomunicaciones: Control de procesos, telecomunicaciones, automatización, robótica aplicada, sistemas embebidos, prototipado electrónico y televisión digital.";
                break;
            case 4:
                return "Ingeniería y Diseño: diseño de productos en las áreas afines a la mecánica y el diseño industrial, como aprovechamiento de energías renovables, máquinas,mobiliario, consumo masivo y empaques.";
                break;
            case 5:
                return "Nanotecnología y nuevos materiales: Modificación de superficies a escala nanométrica, síntesis de nanopartículas, evaluación a escala nanométrica, desarrollo y evaluación de nuevos materiales como materiales compuestos, materiales biodegradables y biopolímeros obtenidos a través de biotecnología.";
                break;
            case 6:
                return "Otros Productos: personalización de productos, productos de moda, alimentos no tradicionales o exóticos, productos artesanales, construcción de infraestructura.";
                break;
            default:
                return "No registra";
                break;
        }
    }
}
