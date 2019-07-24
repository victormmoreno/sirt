<?php

namespace App\Exceptions\Nodo;

use InvalidArgumentException;

class NodoDoesNotExist extends InvalidArgumentException
{
    public static function named(string $nodoName)
    {
        return new static("no hay ningun nodo llamado `{$nodoName}`.");
    }

    public static function withId(int $nodoId)
    {
        return new static("There is no role with id `{$nodoId}`.");
    }
}
