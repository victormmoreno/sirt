<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $table = 'videos';

    protected $fillable = [
        'servidor_video_id',
        'ruta',
    ];

    public function servidorvideo()
    {
        return $this->belongsTo(ServidorVideo::class, 'servidor_video_id', 'id');
    }

    public function videoble()
    {
    	return $this->morphTo();
    }
}
