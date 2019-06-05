<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Idea extends Model
{
    use Notifiable;

    /*=================================================================
    =            constantes para conocer los tipos de idea            =
    =================================================================*/

    const IS_EMPRENDEDOR   = 1;
    const IS_EMPRESA = 2;
    const IS_GRUPOINVESTIGACION = 3;

    /*=====  End of constantes para conocer los tipos de idea  ======*/


    protected $table = 'ideas';

    protected $appends = ['nombre_completo'];

    protected $dates = [
        'fecha',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nodo_id',
        'nombres_contacto',
        'apellidos_contacto',
        'correo_contacto',
        'telefono_contacto',
        'nombre_proyecto',
        'aprendiz_sena',
        'pregunta1',
        'pregunta2',
        'pregunta3',
        'descripcion',
        'objetivo',
        'alcance',
        'tipo_idea',

    ];

    public function estadoIdea()
    {
        return $this->belongsTo(EstadoIdea::class, 'estadoidea_id', 'id');
    }

    public function nodo()
    {
        return $this->belongsTo(Nodo::class, 'nodo_id', 'id');
    }

    public function getNombreCompletoAttribute()
    {
        return ucfirst($this->nombrec) . ' ' . ucfirst($this->apellidoc);
    }

    /*===============================================================
    =            metodos para conocer los tipos de ideas            =
    ===============================================================*/
    public static function IsEmprendedor()
    {
        return Idea::IS_EMPRENDEDOR;
    }

    public static function IsEmpresa()
    {
        return Idea::IS_EMPRESA;
    }

    public static function IsGrupoInvestigacion()
    {
        return Idea::IS_GRUPOINVESTIGACION;
    }


    /*=====  End of metodos para conocer los tipos de ideas  ======*/

    public static function getAllIdeas()
    {
        return self::all();
    }

    public function scopeConsultarIdeaId($query, $id)
    {
      return $query->select('nombres_contacto', 'apellidos_contacto', 'correo_contacto', 'nombre_proyecto', 'descripcion', 'objetivo', 'alcance', 'nodo_id', 'estadoidea_id',
      'telefono_contacto', 'ideas.id', 'estadosidea.nombre AS estado_idea')
      ->selectRaw('IF(aprendiz_sena = 1, "Si", "No") AS aprendiz_sena')
      ->selectRaw('IF(pregunta1=1, "Tengo el problema identificado, pero no tengo claro que producto debo desarrollar para resolverlo",
      IF(pregunta1=3, "Tengo la idea del producto que quiero desarrollar, tengo los conocimientos para hacerlo, pero no se qué pasos seguir para formular el proyecto",
      IF(pregunta1=5, "Mi proyecto está formulado y ya comencé la ejecución, pero necesito gestionar algunos recursos para poder avanzar",
      IF(pregunta1=7, "Ya tengo un prototipo final, he realizado pruebas y ajustes, tengo planteada la idea de negocio y requiero gestionar algunos recursos para implementarla",
      IF(pregunta1=9, "Quiero desarrollar una página web para promocionar mi negocio actual",
      IF(pregunta1=2, "Tengo la idea del producto que quiero desarrollar pero no sé cómo hacerlo",
      IF(pregunta1=4, "Tengo formulado el proyecto para desarrollar mi producto: tengo claros los objetivos, el alcance, los recursos y las actividades que debo realizar para conseguirlo, entre otros",
      IF(pregunta1=6, "Ya tengo un prototipo avanzado de mi producto y requiero gestionar algunos recursos para concluir mi proyecto",
      IF(pregunta1=8, "No voy a desarrollar un producto, voy a comercializar un producto de otro fabricante", "Sin pregunta" ))))))))) AS pregunta1String')
      ->selectRaw('IF(pregunta2=1, "No tengo equipo de trabajo, yo solo me encargaré de desarrollar el producto",
      IF(pregunta2=3, "Tengo un equipo de trabajo que cuenta con los conocimientos de mercadeo mínimos para la implementación de la idea de negocio, pero no contamos con los conocimientos técnicos para desarrollar el producto",
      IF(pregunta2=2, "Tengo un equipo de trabajo que cuenta con los conocimientos técnicos mínimos para el desarrollo del producto, pero no contamos con los conocimientos de mercadeo para la implementación de la idea de negocio",
      IF(pregunta2=4, "Tengo un equipo de trabajo multidisciplinar, que cuenta con los conocimientos técnicos, conocimientos de gestión y conocimientos de mercadeo necesarios para el desarrollo del producto y la implementación de la idea de negocio", "Sin pregunta" )))) AS pregunta2String')
      ->selectRaw('IF(pregunta3=1, "Tecnologías Virtuales: desarrollo de software para dIFerentes dispositivos, animaciones 2D y 3D, creación de contenidos para aplicaciones, animaciones y videojuegos",
      IF(pregunta3=3, "Electrónica y Telecomunicaciones: Control de procesos, telecomunicaciones, automatización, robótica aplicada, sistemas embebidos, prototipado electrónico y televisión digital",
      IF(pregunta3=2, "Biotecnología: utilización de organismos vivos o sus derivados para el desarrollo de productos y/o procesos en las áreas de ambiente, alimentos y nanotecnología",
      IF(pregunta3=5, "Nanotecnología y nuevos materiales: Modificación de superficies a escala nanométrica, síntesis de nanopartículas, evaluación a escala nanométrica, desarrollo y evaluación de nuevos materiales como materiales compuestos, materiales biodegradables y biopolímeros obtenidos a través de biotecnología",
      IF(pregunta3=6, "Otros Productos: personalización de productos, productos de moda, alimentos no tradicionales o exóticos, productos artesanales, construcción de infraestructura",
      IF(pregunta3=4, "Ingeniería y Diseño: diseño de productos en las áreas afines a la mecánica y el diseño industrial, como aprovechamiento de energías renovables, máquinas,mobiliario, consumo masivo y empaques", "Sin pregunta" )))))) AS pregunta3String')
      ////1- emprendedor - 2- empresa - 3- grupo de investigacion
      ->selectRaw('IF(tipo_idea = 1, "Emprendedor",
      IF(tipo_idea = 2, "Empresa", "Grupo de Investigacón")) AS tipo_ideaString')
      ->join('estadosidea', 'estadosidea.id', '=', 'ideas.estadoidea_id')
      ->where('ideas.id', $id);
    }

}
