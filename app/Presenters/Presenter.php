<?php

namespace App\Presenters;

use Illuminate\Database\Eloquent\Model;

class Presenter{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function message(String $message){
        return $message;
    }
}