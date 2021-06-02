<?php

function setActiveRoutePadding($name){
    return request()->is($name.'*') ? 'active':'';
}

function setActiveRoute($name){
    return request()->is($name.'*') ? 'active':'';
}

function setActiveRouteActivePage($name){
    return request()->is($name.'*') ? 'active-page':'';
}

function setActiveRouteActiveIcon($name){
    return request()->is($name.'*') ? 'orange-text lighten-2':'';
}

function arrayRecursiveDiff($aArray1, $aArray2) {
    $aReturn = array();
  
    foreach ($aArray1 as $mKey => $mValue) {
        if (array_key_exists($mKey, $aArray2)) {
            if (is_array($mValue)) {
                $aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
            } else {
                if ($mValue != $aArray2[$mKey]) {
                    $aReturn[$mKey] = $mValue;
                }
            }
        } else {
            $aReturn[$mKey] = $mValue;
        }
    }
  
    return $aReturn;
}

function nameFase($fase){
    switch ($fase) {
        case 'inicio':
            $fase = 'inicio';
            break;
        case 'planeación':
            $fase = 'planeacion';
            break;
        case 'Ejecución':
            $fase = 'ejecucion';
            break;
        case 'ejecución':
            $fase = 'ejecucion';
            break;
        case 'cierre':
            $fase = 'cierre';
            break;
        case 'Cierre':
            $fase = 'cierre';
            break;
        
        default:
            $fase = 'inicio';
            break;
    }

    return $fase;
}
