<?php

function setActiveRoutePadding($name){
    return request()->is($name) ? 'active':'';
}

function setActiveRoute($name){
    return request()->is($name) ? 'class="active-page"':'';
}