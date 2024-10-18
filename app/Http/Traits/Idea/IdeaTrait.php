<?php

namespace App\Http\Traits\Idea;

use App\Models\EstadoIdea;
use App\Models\Nodo;
use App\Models\Proyecto;
use App\Models\Sede;
use App\Models\RutaModel;
use App\Models\Comite;
use App\User;
use App\Models\Entrenamiento;
use App\Models\HistorialEntidad;
use App\Models\UsoInfraestructura;

trait IdeaTrait
{
    public static function IsEmprendedor()
    {
        return self::IS_EMPRENDEDOR;
    }

    public static function IsEmpresa()
    {
        return self::IS_EMPRESA;
    }

    public static function IsGrupoInvestigacion()
    {
        return self::IS_GRUPOINVESTIGACION;
    }

    public function historial()
    {
        return $this->morphMany(HistorialEntidad::class, 'model');
    }

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

    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id', 'id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comites()
    {
        return $this->belongsToMany(Comite::class, 'comite_idea')
            ->withTimestamps()
            ->withPivot(['hora', 'admitido', 'asistencia', 'observaciones', 'direccion']);
    }

    public function entrenamiento()
    {
        return $this->belongsToMany(Entrenamiento::class, 'entrenamiento_idea')
            ->withTimestamps()
            ->withPivot(['confirmacion', 'canvas', 'asistencia1', 'asistencia2', 'convocado_csibt']);
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


    public function asesorias()
    {
        return $this->morphMany(UsoInfraestructura::class, 'asesorable');
    }

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
                return "Tecnologías Virtuales: Esta linea esta enfocada al desarrollo de aplicaciones web, móviles, inteligencia artificial, realidad aumentada, sistemas de información geográfica, seguridad informática y creación de entornos virtuales.";
                break;
            case 2:
                return "Biotecnología y Nanotecnología: Esta linea esta enfocada al trabajo de la agroindustria alimentaria, biotecnologia vegetal, biotecnologia molecular aplicada a plantas, animales y microorganismos.";
                break;
            case 3:
                return "Electrónica y Telecomunicaciones: Esta linea esta enfocada al internet de las cosas, automatización de procesos, sistemas embebidos, robótica, procesamiento de imágenes e instrumentación electrónica, gestión de la energía y energías renovables.";
                break;
            case 4:
                return "Ingeniería y Diseño: Esta linea esta enfocada al diseño mecánico, diseño de productos, sistemas CAD/CAM/CAE, optimización topológica, prototipado rápido y procesos de manufactura avanzada,  ingeniería inversa  y análisis dimensiona, prototipado 3d y impresión a laser.";
                break;
            // case 5:
            //     return "Biotecnología y Nanotecnología: Esta linea esta enfocada al trabajo de la agroindustria alimentaria, biotecnologia vegetal, biotecnologia molecular aplicada a plantas, animales y microorganismos.";
            //     break;
            case 6:
                return "Otros Productos: personalización de productos, productos de moda, alimentos no tradicionales o exóticos, productos artesanales, construcción de infraestructura.";
                break;
            default:
                return "No registra";
                break;
        }
    }
}
