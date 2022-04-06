<?php

namespace App\Imports;

use Carbon\Carbon;

class ValidacionesImport
{

    public function validarTamanhoCelda($celda, $i, $nombre_campo, $max, $hoja)
    {
        if (strlen($celda) > $max) {
            session()->put('errorMigracion', 'Error en la hoja de "'.$hoja.'": ' . $nombre_campo . ' ' . $celda . ' en el registro de la fila #' . ($i+2) . ' no debe ser mayor a ' . $max . ' carácteres.');
            return false;
        }
        return true;
    }
    
    public function validarFecha($fecha, $i, $nombre_campo, $hoja)
    {
        try {
            if ($fecha != null) {
                $fecha_format = Carbon::parse($fecha);
                if ($fecha_format->format('Y-m-d') != $fecha) {
                    session()->put('errorMigracion', 'Error en la hoja de "'.$hoja.'": ' . $nombre_campo . ' ' . Carbon::parse($fecha)->format('Y-m-d'). ' en el registro de la fila #' . ($i+2) . ' no existe.');
                    return false;
                }
            }
            return true;
        }
        catch (\Exception $err) {
            session()->put('errorMigracion', 'Error en la hoja de "'.$hoja.'": ' . $err->getMessage() . ' en el registro de la fila #' . ($i+2));
            return false;
        }
    }

    public function validarCelda($celda, $i, $nombre_campo, $hoja) {
        if($celda == null) {
            session()->put('errorMigracion', 'Error en la hoja de "'.$hoja.'": ' . $nombre_campo . ' ' . $celda . ' en el registro de la fila #' . ($i+2) . ' no es un valor correcto.');
            return false;
        }
        return true;
    }

    public function validarQuery($query, $celda, $i, $modelo, $hoja)
    {
        if ($query == null) {
            session()->put('errorMigracion', 'Error en la hoja de "'.$hoja.'": ' . $modelo . ' ' . $celda . ' en el registro de la fila #' . ($i+2) . ' no existe en la base de datos.');
            return false;
        }
        return true;
    }

    public function validarGenero($genero, $i, $hoja)
    {
        if ($genero != 'MASCULINO' && $genero != 'FEMENINO') {
            session()->put('errorMigracion', 'Error en la hoja de "'.$hoja.'": El género ' . $genero . ' en el registro de la fila #' . ($i+2) . ' no es válido (MASCULINO O FEMENINO).');
            return false;
        }
        return true;
    }

    public function errorValidacionCorreo($email, $i, $documento_registrado, $hoja)
    {
        session()->put('errorMigracion', 'Error en la hoja de "'.$hoja.'": El correo ' . $email . ' en el registro de la fila #' . ($i+2) . ' ya se encuentra asociado al usuario con número de cédula: '.$documento_registrado.' (No se permite la duplicación de correos).');
        return false;
    }
}
