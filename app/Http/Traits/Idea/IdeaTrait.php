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
use Carbon\Carbon;
use Illuminate\Support\Arr;

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

    public function getDatosIdeaAttribute($value)
    {
        $value = json_decode($value);

        // dd($value);
        $value->pregunta1->answer = $this->getPreguntaUno($value->pregunta1->answer);
        $value->pregunta2->answer = $this->getPreguntaDos($value->pregunta2->answer);
        $value->pregunta3->answer = $this->getPreguntaTres($value->pregunta3->answer);
        $value->fecha_acuerdo_no_confidencialidad->answer = Carbon::parse($value->fecha_acuerdo_no_confidencialidad->answer)->format('Y-m-d H:m');
        $value = $this->getApoyoRequerido($value);
        $value = $this->getVersionBeta($value);
        $value = $this->accessingInfo($value);
        return $value;
    }

    // // Accesor para 'apoyo_requerido.answer'
    // public function getApoyoRequeridoAnswerAttribute()
    // {
    //     return $this->datos_idea['apoyo_requerido']['answer'] ?? 'Respuesta de apoyo por defecto';
    // }

    // // Accesor para 'apoyo_requerido.label'
    // public function getApoyoRequeridoLabelAttribute()
    // {
    //     return $this->datos_idea['apoyo_requerido']['label'] ?? 'Etiqueta de apoyo por defecto';
    // }

    // public function getApoyoRequeridoAnswerAttribute() {
    //     return $this->datos_idea['apoyo_requerido']['answer'] ?? 'No se encontraron datos';
    // }

    /**
     * Retorna la información del array controlada
     *
     * @param $value
     * @return object
     * @author dum
     **/
    private function accessingInfo($value)
    {
        foreach ($value as $key => $item_value) {
            if ($item_value->answer === null) {
                $item_value->answer = 'No hay información disponible';
            }
            if ($item_value->answer === 0) {
                $item_value->answer = 'No';
            }
            if ($item_value->answer === 1) {
                $item_value->answer = 'Si';
            }
        }
        return $value;
    }

    /**
     * Retorna el valor de la pregunta 3
     *
     * @param $value El valor de la pregunta 3 (¿En qué categoría se clasifica su idea?)
     * @return array
     * @author dum
     **/
    private function getPreguntaTres($value)
    {
        return [
            0 => 'No hay información disponible',
            1 => 'Tecnologías Virtuales: Esta linea esta enfocada al desarrollo de aplicaciones web, móviles, inteligencia artificial, realidad aumentada, sistemas de información geográfica, seguridad informática y creación de entornos virtuales.',
            2 => 'Biotecnología y Nanotecnología: Esta linea esta enfocada al trabajo de la agroindustria alimentaria, biotecnologia vegetal, biotecnologia molecular aplicada a plantas, animales y microorganismos.',
            3 => 'Electrónica y Telecomunicaciones: Esta linea esta enfocada al internet de las cosas, automatización de procesos, sistemas embebidos, robótica, procesamiento de imágenes e instrumentación electrónica, gestión de la energía y energías renovables.',
            4 => 'Ingeniería y Diseño: Esta linea esta enfocada al diseño mecánico, diseño de productos, sistemas CAD/CAM/CAE, optimización topológica, prototipado rápido y procesos de manufactura avanzada,  ingeniería inversa  y análisis dimensiona, prototipado 3d y impresión a laser.',
            6 => 'Otros Productos: personalización de productos, productos de moda, alimentos no tradicionales o exóticos, productos artesanales, construcción de infraestructura.',
            null => 'No hay información disponible'
        ][$value];
    }

    /**
     * Retorna el valor de la pregunta 2
     *
     * @param $value El valor de la pregunta 2 (¿Cómo está conformado su equipo de trabajo?)
     * @return array
     * @author dum
     **/
    private function getPreguntaDos($value)
    {
        return [
            1 => 'No tengo equipo de trabajo, yo solo me encargaré de desarrollar el producto.',
            2 => 'Tengo un equipo de trabajo que cuenta con los conocimientos técnicos mínimos para el desarrollo del producto, pero no contamos con los conocimientos de mercadeo para la implementación de la idea de negocio.',
            3 => 'Tengo un equipo de trabajo que cuenta con los conocimientos de mercadeo mínimos para la implementación de la idea de negocio, pero no contamos con los conocimientos técnicos para desarrollar el producto.',
            4 => 'Tengo un equipo de trabajo multidisciplinar, que cuenta con los conocimientos técnicos, conocimientos de gestión y conocimientos de mercadeo necesarios para el desarrollo del producto y la implementación de la idea de negocio.',
            null => 'No hay información disponible'
        ][$value];
    }

    /**
     * Retorna el valor de la pregunta 1
     *
     * @param $value El valor de la pregunta 1 (Estado actual de la idea de proyecto)
     * @return array
     * @author dum
     **/
    private function getPreguntaUno($value)
    {
        return [
            1 => 'Tengo el problema identificado, pero no tengo claro que producto debo desarrollar para resolverlo',
            2 => 'Tengo la idea del producto que quiero desarrollar pero no sé cómo hacerlo.',
            3 => 'Tengo la idea del producto que quiero desarrollar, tengo los conocimientos para hacerlo, pero no se qué pasos seguir para formular el proyecto.',
            4 => 'Tengo formulado el proyecto para desarrollar mi producto: tengo claros los objetivos, el alcance, los recursos y las actividades que debo realizar para conseguirlo, entre otros.',
            5 => 'Mi proyecto está formulado y ya comencé la ejecución, pero necesito gestionar algunos recursos para poder avanzar.',
            6 => 'Ya tengo un prototipo avanzado de mi producto y requiero gestionar algunos recursos para concluir mi proyecto.',
            7 => 'Ya tengo un prototipo final, he realizado pruebas y ajustes, tengo planteada la idea de negocio y requiero gestionar algunos recursos para implementarla.',
            8 => 'No voy a desarrollar un producto, voy a comercializar un producto de otro fabricante.',
            9 => 'Quiero desarrollar una página web para promocionar mi negocio actual.',
            null => 'No hay información disponible'
        ][$value];
    }

    /**
     * Retorna el valor para la pregunta de si hay un prototipo o version beta de la idea
     *
     * @param $value El valor de la version beta
     * @return object
     * @author dum
     **/
    private function getVersionBeta($value)
    {
        // dd($value);
        if (isset($value->version_beta->answer)) {
            if (is_numeric($value->version_beta->answer) || $value->version_beta->answer == null) {
                $value->version_beta->answer = [
                    1 => 'Concepto: Algo formulado, pero no tangible',
                    2 => 'Modelo en 3D: Diseño de alternativa en software CAD que permite identificar la esencia del proyecto que se está presentando, con algunos detalles de concepto',
                    3 => 'Prototipo: Diseño en físico ya sea tamaño real, mayor o menor',
                    4 => 'Versión beta: Versión de prototipo final ya en pruebas con usuarios',
                    null => 'No hay información disponible'
                ][$value->version_beta->answer];
            } 
        }
        return $value;
    }

    /**
     * Retorna el valor para el tipo de apoyo requerido
     *
     * @param $value El valor del tipo de apoyo requerido
     * @return object
     * @author dum
     **/
    private function getApoyoRequerido($value)
    {
        $value = json_encode($value);
        $value = json_decode($value, true);
        if (!isset($value['apoyo_requerido']['label'])) {
            $value['apoyo_requerido']['answer'] = 'No hay información disponible';
            $value['apoyo_requerido']['label'] = '¿Ha identificado algún tipo de recurso y/o apoyo requerido para la escalabilidad de la idea?';
        }
        if (!isset($value['link_video']['label'])) {
            $value['link_video']['answer'] = 'No hay información disponible';
            $value['link_video']['label'] = 'Link del video presentación de la idea de proyecto';
        }

        $value = json_encode($value);
        $value = json_decode($value);
        if (isset($value->apoyo_requerido->answer)) {
            if (is_numeric($value->apoyo_requerido->answer) || $value->apoyo_requerido->answer == null) {
            

                $value->apoyo_requerido->answer = [
                    1 => 'Requiero apoyo en marketing o espacios comerciales',
                    2 => 'Requiero inversionistas',
                    3 => 'Requiero inversión de capital semilla de Fondo Emprender',
                    4 => 'Requiero relacionamiento con Cámara de Comercio, Aceleradoras, Incubadores, entre otros aliados estratégicos',
                    5 => 'No requiero ningún tipo de recurso para escalar mi idea',
                    null => 'No hay información disponible'
                ][$value->apoyo_requerido->answer];
            }

        }
        // dd($value);
        return $value;
    }

    //metodo para retorar el valor string de la primera preunta de registro de ideas
    public static function preguntaUno(int $question = null)
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
            // case null:
            //     return "No hay información disponible.";
            //     break;
            default:
                return "No registra";
                break;
        }
    }

    //metodo para retorar el valor string de la segunda preunta de registro de ideas
    public static function preguntaDos(int $question = null)
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
    public static function preguntaTres(int $question = null)
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
            // case null:
            //     return 'No hay información disponible';
            //     break;
            default:
                return "No registra";
                break;
        }
    }
}
