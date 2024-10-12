<?php

namespace App\Models;

use App\Http\Traits\Idea\IdeaTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\EstadoIdea;
use App\Presenters\IdeaPresenter;


class Idea extends Model
{

    use IdeaTrait;

    const IS_EMPRENDEDOR        = 1;
    const IS_EMPRESA            = 2;
    const IS_GRUPOINVESTIGACION = 3;

    protected $table = 'ideas';

    protected $appends = ['nombre_completo'];

    protected $dates = [
        'fecha',
    ];

    protected $casts = [
        'datos_idea' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asesor_id',
        'user_id',
        'sede_id',
        'nodo_id',
        'estadoidea_id',
        'codigo_idea',
        'datos_idea'
    ];

    /**
     * The polymorfic relation much to much
     *
     * @return void
     */
    public function articulationables()
    {
        return $this->morphToMany(ArticulationStage::class, 'articulationable');
    }

    public function registrarHistorialIdea($movimiento, $role, $comentario, $descripcion)
    {
        return $this->historial()->create([
            'movimiento_id' => Movimiento::where('movimiento', $movimiento)->first()->id,
            'user_id' => auth()->user()->id,
            'role_id' => Role::where('name', $role)->first()->id,
            'comentarios' => $comentario,
            'descripcion' => $descripcion
        ]);
    }

    public function validarAcuerdoConfidencialidad()
    {
        if ($this->acuerdo_no_confidencialidad == 0) {
            return false;
        }
        return true;
    }

    public function validarIdeaEnEstadoRegistro()
    {
        if ($this->estadoIdea->nombre == EstadoIdea::IsRegistro()) {
            return true;
        }
        return false;
    }

    public function scopeConsultarIdeasAprobadasEnComite($query, $idnodo, $idgestor)
    {
        return $query->select(
            'ideas.id AS consecutivo',
            'ideas.codigo_idea',
            'nombre_proyecto',
            'tipo_idea',
            'viene_convocatoria',
            'convocatoria',
            'c.fechacomite',
            'ideas.user_id'
        )
        ->selectRaw('DATEDIFF(now(), fechacomite) as dias')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombres_talento')
        ->selectRaw('concat(ug.nombres, " ", ug.apellidos) AS experto')
        ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
        ->join('estadosidea', 'estadosidea.id', '=', 'ideas.estadoidea_id')
        ->join('users as ug', 'ug.id', '=', 'ideas.asesor_id')
        ->join('comite_idea AS ci', 'ci.idea_id', '=', 'ideas.id')
        ->join('comites AS c', 'c.id', '=', 'ci.comite_id')
        ->leftjoin('users', 'users.id', '=', 'ideas.user_id')
        ->where('nodos.id', $idnodo)
        ->where('ci.admitido', 1)
        ->where('estadosidea.nombre', EstadoIdea::IsAdmitido())
        ->experto($idgestor);
    }

    public function scopeConsultarIdeasRegistradas($query, $idnodo, $desde, $hasta)
    {
        return $query->select(
            'ideas.id AS consecutivo',
            'ideas.codigo_idea',
            'nombre_proyecto',
            'tipo_idea',
            'viene_convocatoria',
            'convocatoria',
            'ideas.talento_id'
        )
        ->selectRaw('concat(nombres_contacto, " ", apellidos_contacto) AS nombres_contacto')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombres_talento')
        ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
        ->join('entidades', 'entidades.id', '=', 'nodos.entidad_id')
        ->join('estadosidea', 'estadosidea.id', '=', 'ideas.estadoidea_id')
        ->leftjoin('talentos', 'talentos.id', '=', 'ideas.talento_id')
        ->leftjoin('users', 'users.id', '=', 'talentos.user_id')
        ->where('nodos.id', $idnodo)
        ->whereBetween('ideas.created_at', [$desde, $hasta]);
    }

    public function scopeConsultarIdeasConvocadasAComite($query, $id)
    {
        return $query->select(
            'ideas.id',
            'ideas.created_at AS fecha_registro',
            'ideas.codigo_idea',
            'nombre_proyecto',
            'estadosidea.nombre AS estado',
            'viene_convocatoria',
            'convocatoria'
        )
            ->selectRaw('CONCAT(codigo_idea, " - ", nombre_proyecto) AS nombre_idea')
            ->join('estadosidea', 'estadosidea.id', '=', 'ideas.estadoidea_id')
            ->where('nodo_id', $id)
            ->whereIn('estadosidea.nombre', [EstadoIdea::IsConvocado(), EstadoIdea::IsReprogramado()])
            ->groupBy('ideas.id')
            ->orderBy('nombre_proyecto');
    }

    /**
     * Query para consultar ideas de proyecto
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function scopeConsultarIdeas($query, $field, $value, $nodo)
    {
        return $query->select(
            'ideas.id AS id',
            'ideas.codigo_idea',
            'nombre_proyecto',
            'tipo_idea',
            'viene_convocatoria',
            'convocatoria',
            'ideas.user_id'
        )
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombres_talento')
        ->selectRaw('concat(ug.nombres, " ", ug.apellidos) AS experto')
        ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
        ->join('estadosidea', 'estadosidea.id', '=', 'ideas.estadoidea_id')
        ->leftJoin('users as ug', 'ug.id', '=', 'ideas.asesor_id')
        ->leftjoin('users', 'users.id', '=', 'ideas.user_id')
        ->field($field, $value)
        ->oneNodo($nodo);
    }

    public function scopeCreatedAt($query, $created_at)
    {
        if (!empty($created_at) && $created_at != 'all' && $created_at != null) {
            return $query->whereYear('created_at', $created_at);
        }
        return $query;
    }

    public function scopeState($query, $state)
    {
        if (!empty($state) && $state != 'all' && $state != null) {
            return $query->where('estadoidea_id', $state);
        }
        return $query;
    }


    public function scopeVieneConvocatoria($query, $viene_convocatoria)
    {
        if (!empty($viene_convocatoria) && $viene_convocatoria != 'all' && $viene_convocatoria != null) {
            if ($viene_convocatoria == 'si') {
                $viene_convocatoria = 1;
            } else {
                $viene_convocatoria = 0;
            }
            return $query->where('viene_convocatoria', $viene_convocatoria);
        }
        return $query;
    }

    public function scopeNodo($query, $nodo)
    {
        if (!empty($nodo) && $nodo != null && $nodo != 'all') {
            return $query->whereIn('nodo_id', $nodo);
        }
        return $query;
    }

    public function scopeOneNodo($query, $nodo)
    {
        if (!empty($nodo) && $nodo != null && $nodo != 'all') {
            return $query->where('ideas.nodo_id', $nodo);
        }
        return $query;
    }

    public function scopeExperto($query, $experto)
    {
        if (!empty($experto) && $experto != null && $experto != 'all') {
            return $query->where('asesor_id', $experto);
        }
        return $query;
    }

    public function scopeField($query, $field, $value)
    {
        if (!empty($field) && $field != null && $field != 'all' && !empty($value) && $value != null && $value != 'all') {
            return $query->where($field, 'like', "%{$value}%");
        }
        return $query;
    }

    public function scopeConvocatoria($query, $convocatoria)
    {
        if (!empty($convocatoria) && $convocatoria != '' && $convocatoria != null) {
            return $query->where('convocatoria', 'LIKE', "%$convocatoria%");
        }
        return $query;
    }

    public function scopeIdeaWithRelations($query, array $relations)
    {
        return $query->with($relations);
    }

    /**
     * returns an instance of the ProjectPresenter class
     * @author devjul
     * @return void
     */
    public function present()
    {
        return new IdeaPresenter($this);
    }
}
