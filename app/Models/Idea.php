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

}
