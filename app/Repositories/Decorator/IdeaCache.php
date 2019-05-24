<?php

namespace App\Repositories\Decorator;

use App\Repositories\Interface\IdeaInterface;
use Illuminate\Support\Facades\Cache;

class IdeaCache 
{
	public $ideas;

	public function __construct(IdeaRepository $ideas)
	{
		$this->ideas = $ideas;
	}


	public function getSelectNodo()
	{
		return Cache::rememberForever('nodos.select',function(){
            return $this->ideas->getSelectNodo();
        });
	}


	public function findByid()
	{
		return Cache::rememberForever("ideas.{$id}",function() use($id){
			return $this->ideas->findByid($id);
		});	
	}
}