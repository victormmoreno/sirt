<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TamanhoEmpresa extends Model
{
    protected $table = 'tamanhos_empresas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

    public function empresas()
    {
      return $this->hasMany(Empresa::class, 'tamanhoempresa_id', 'id');
    }
}
