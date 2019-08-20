<?php

namespace App\Repositories\Repository\ConfiguracionRepository;

use App\Models\ServidorVideo;

class ServidorVideoRepository
{
	public function getAllServidorVideo()
	{
		return ServidorVideo::allServidoresVideo()->select('id','nombre')->orderBy('nombre')->pluck('nombre','id');
	}
}