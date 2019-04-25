<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = 'tipodocumento';

	public $primaryKey= 'idtipodocumento';
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abreviatura',
        'nombre',
        'estado',
    ];
}
