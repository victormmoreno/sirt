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
        'nombres_contacto',
        'apellidos_contacto',
        'correo_contacto',
        'telefono_contacto',
        'nombre_proyecto',
        'codigo_idea',
        'aprendiz_sena',
        'pregunta1',
        'pregunta2',
        'pregunta3',
        'descripcion',
        'objetivo',
        'alcance',
        'viene_convocatoria',
        'convocatoria',
        'aval_empresa',
        'empresa',
        'tipo_idea',
        'producto_parecido',
        'si_producto_parecido',
        'reemplaza',
        'si_reemplaza',
        'problema',
        'quien_compra',
        'quien_usa',
        'necesidades',
        'distribucion',
        'quien_entrega',
        'packing',
        'tipo_packing',
        'medio_venta',
        'valor_clientes',
        'requisitos_legales',
        'si_requisitos_legales',
        'requiere_certificaciones',
        'si_requiere_certificaciones',
        'forma_juridica',
        'version_beta',
        'cantidad_prototipos',
        'recursos_necesarios',
        'si_recursos_necesarios',
        'acuerdo_no_confidencialidad',
        'fecha_acuerdo_no_confidencialidad',
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
            'ideas.user_id'
        )
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombres_talento')
        ->selectRaw('concat(ug.nombres, " ", ug.apellidos) AS experto')
        ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
        ->join('estadosidea', 'estadosidea.id', '=', 'ideas.estadoidea_id')
        ->join('users as ug', 'ug.id', '=', 'ideas.asesor_id')
        ->leftjoin('users', 'users.id', '=', 'ideas.user_id')
        ->where('nodos.id', $idnodo)
        ->where('estadosidea.nombre', EstadoIdea::IsAdmitido())
        ->experto($idgestor);
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
        ->selectRaw('concat(nombres_contacto, " ", apellidos_contacto) AS nombres_contacto')
        ->selectRaw('concat(users.nombres, " ", users.apellidos) AS nombres_talento')
        ->selectRaw('concat(ug.nombres, " ", ug.apellidos) AS experto')
        ->join('nodos', 'nodos.id', '=', 'ideas.nodo_id')
        ->join('estadosidea', 'estadosidea.id', '=', 'ideas.estadoidea_id')
        ->leftJoin('gestores', 'gestores.id', '=', 'ideas.asesor_id')
        ->leftJoin('users as ug', 'ug.id', '=', 'gestores.user_id')
        ->leftjoin('talentos', 'talentos.id', '=', 'ideas.user_id')
        ->leftjoin('users', 'users.id', '=', 'talentos.user_id')
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
