<?php

function sitePath() {
    return realpath(__DIR__."/../");
}


function webSitePath() {
    return preg_replace(
        '/\\\/',
        '/',
        str_replace(realpath($_SERVER["DOCUMENT_ROOT"]), '', sitePath())
    );
}

function crudPath($crud) {
    return webSitePath().'/BACK/'.$crud;
}

?>