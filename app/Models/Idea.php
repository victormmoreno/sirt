<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{

    /*=================================================================
    =            constantes para conocer los tipos de idea            =
    =================================================================*/
    
    const IS_EMPRENDEDOR   = 1;
    const IS_GRUPOINVESTIGACION_EMPRESA = 2;
    
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
        'fecha',
        'nombrec',
        'apellidoc',
        'correo',
        'telefono',
        'nombreproyecto',
        'aprendizsena',
        'pregunta1',
        'pregunta2',
        'pregunta3',
        'descripcion',
        'objetivo',
        'alcance',
        'tipoidea',
        'nodo_id',
        'estadoidea_id',
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

    public static function IsGrupoInvestigacionEmpresa()
    {
        return Idea::IS_GRUPOINVESTIGACION_EMPRESA;
    }
    
    
    /*=====  End of metodos para conocer los tipos de ideas  ======*/

      
    
}
