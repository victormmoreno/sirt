<?php

namespace App\Http\Traits\EdtTrait;

trait EdtTrait
{

  /**
  * Retorna el valor de la constante IS_INACTIVE
  * @return int type
  */
  public static function IsInactive()
  {
    return self::IS_INACTIVE;
  }

  /**
  * Retorna el valor de la constante IS_ACTIVE
  * @return int type
  */
  public static function IsActive()
  {
    return self::IS_ACTIVE;
  }

}
