<?php
namespace App\Helpers;

class ArrayHelper {

  // Método para validar en caso de que un elemento de un array/objecto sea null
    public static function validarDatoNullDeUnObject($datos) {
        foreach ($datos as $key => $value) {
        foreach ($value as $key2 => $value2) {
            if ($value2 == null) {
            $value[$key2] = 'No hay información disponible.';
            }
            $datos[$key] = $value;
        }
        }
        return $datos;
    }

    /**
     * Valida los datos de un array para que no muestre null
     * @param array $datos
     * @return array
     * @author Victor Manuel Moreno Vega
     */
    public static function validarDatoNullDeUnArray($datos) {
        foreach ($datos as $key => $value) {
        if ($value === null) {
            $datos[$key] = 'No hay información disponible.';
        }
        }
        return $datos;
    }

  // Método para validar en caso de que un elemento de un array sea null (Válido únicamente para los entregables (De lo que sea, edt, proyectos, articulaciones, etc.))
    public static function validarEntregablesNullDeUnArrayString($datos) {
        foreach ($datos as $key => $value) {
        if ($value == 1) {
            $datos[$key] = 'Si';
        }
        if ($value == null || $value == 0) {
            $datos[$key] = 'No';
        }
        }
        return $datos;
    }
}
