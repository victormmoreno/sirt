<?php

function setActiveRoutePadding($name){
    return request()->is($name) ? 'active':'';
}

function setActiveRoute($name){
    return request()->is($name) ? 'active':'';
}

function setActiveRouteActivePage($name){
    return request()->is($name) ? 'active-page':'';
}

function setActiveRouteActiveIcon($name){
    return request()->is($name) ? 'active-icon':'';
}
