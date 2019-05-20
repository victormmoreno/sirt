<?php

function setActiveRoute($name){
    return request()->is($name) ? 'class="active"':'';
}