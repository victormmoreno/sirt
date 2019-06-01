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
    return request()->is($name) ? 'color="#008981"':'';
}
<<<<<<< HEAD

=======
>>>>>>> 6dd3e63e62a96183c85d29f48571d5e51212673e
