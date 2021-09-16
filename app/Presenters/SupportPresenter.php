<?php

namespace App\Presenters;

use App\Models\Support;

class SupportPresenter extends Presenter
{
    protected $Support;

    public function __construct(Support $Support)
    {
        $this->Support = $Support;
    }

    public function ticket()
    {
        return  $this->Support->ticket ? : 'No Registra';
    }

    public function name()
    {
        return  $this->Support->name ? : 'No Registra';
    }

    public function lastname()
    {
        return  $this->Support->lastname ? : 'No Registra';
    }

    public function fullname()
    {
        return  "{$this->Support->name} {$this->Support->lastname}";
    }

    public function document()
    {
        return  $this->Support->document ? : 'No Registra';
    }

    public function email()
    {
        return  $this->Support->email ? : 'No Registra';
    }

    public function phone()
    {
        return  $this->Support->phone ? : 'No Registra';
    }

    public function subject()
    {
        return  $this->Support->subject ? : 'No Registra';
    }
    public function description()
    {
        return  $this->Support->subject ? : 'No Registra';
    }

    public function difficulty()
    {
        return  $this->Support->subject ? : 'No Registra';
    }

    public function status()
    {
        return  $this->Support->subject ? : 'No Registra';
    }

}
