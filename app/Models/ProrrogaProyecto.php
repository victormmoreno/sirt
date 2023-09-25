<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProrrogaProyecto extends Model
{
    /**
     * the table name
     * @var string
     * @author dum
     */
    protected $table = 'prorroga_proyecto';

    protected $fillable = [
        'fecha_ejecucion',
        'justificacion'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }
}
