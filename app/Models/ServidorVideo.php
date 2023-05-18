<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServidorVideo extends Model
{
	protected $table = 'servidor_videos';

    protected $fillable = [
        'nombre',
        'dominio',
    ];

    public function getDominoAttribute($dominio)
    {
        return mb_strtolower(trim($dominio),'UTF-8');
    }

    public function setDominoAttribute($dominio)
    {
        $this->attributes['dominio'] = mb_strtolower(trim($dominio),'UTF-8');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'servidor_video_id', 'id');
    }

    public function scopeAllServidoresVideo($query)
    {
        return $query;
    }
}
