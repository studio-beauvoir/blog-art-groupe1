<?php

/**
 * Retourne la racine du serveur, pour les scripts php
 */
function sitePath() {
    return realpath(__DIR__."/../");
}

/**
 * Retourne le lien vers le dossier d'uploads, pour les scripts php
 */
function uploadPath($morePath="") {
    return sitePath().'/assets/uploads/'.$morePath;
}

/**
 * Retourne la racine du serveur dans le navigateur
 */
function webSitePath($morePath="") {
    return preg_replace(
        '/\\\/',
        '/',
        str_replace(realpath($_SERVER["DOCUMENT_ROOT"]), '', sitePath())
    ).$morePath;
}

/**
 * Retourne le lien vers un crud dans le navigateur
 */
function crudPath($crud="") {
    return webSitePath('/BACK/'.$crud);
}

/**
 * Retourne le lien vers un crud dans le navigateur
 */
function webUploadPath($morePath="") {
    return webSitePath('/assets/uploads/'.$morePath);
}

?>