<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoEncuesta extends Model
{
    /**
     * the table name
     * @var string
     */
    protected $table = 'resultados_encuesta';

    protected $fillable = [
        'proyecto_id', 'user_id', 'estado', 'resultados', 'fecha_envio', 'fecha_respuesta'
    ];

    protected $casts = [
        'resultados' => 'array',
    ];

    const IS_NO_RESPONDIDA = 0;
    const IS_RESPONDIDA = 1;

    public static function IsNoRespondida()
    {
        return self::IS_NO_RESPONDIDA;
    }

    public static function IsRespondida()
    {
        return self::IS_RESPONDIDA;
    }

    public function encuestaToken()
    {
        return $this->hasOne(EncuestaToken::class);
    }

    public function proyecto()
    {
        return $this->hasOne(Proyecto::class, 'proyecto_id', 'id');
    }

    /**
     * Retornar el builder con los resultados de la encuesta
     *
     * @param $query
     * @return Builder
     * @author dum
     **/
    public function scopeGetResultados($query)
    {
        return $query->select(
            'fecha_envio',
            'fecha_respuesta',
            'proyectos.codigo_proyecto',
            'proyectos.nombre AS nombre_proyecto',
            'entidades.nombre AS nodo'
        )
        ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(resultados,  '$.resultados')) as resultados")
        ->join('proyectos', 'proyectos.id', '=', 'resultados_encuesta.proyecto_id')
        ->join('nodos', 'nodos.id', '=', 'proyectos.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->where('estado', $this->IsRespondida());
    }
}
