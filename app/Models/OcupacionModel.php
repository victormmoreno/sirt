<?php

namespace App\Models;

class OcupacionModel
{
    public $items = null;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
        }
    }

    public function add($item, $id)
    {
        $itemAlmacenado = [
            
            'item' => $item
        ];

        if($this->items)
        {
            if(array_key_exists($id, $this->items))
                $itemAlmacenado = $this->items[$id];
        }

        $this->items[$id] = $itemAlmacenado;

    }


    public function removeaitem($id)
    {
            unset($this->items[$id]);
    }

}
