<?php

//Technique de Gwendal pour créer un chemin absolu, je lâche ça là...
    //define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/BLOGART22');
    //include ROOT . 'img/monimage.png';

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
function webCrudPath($crud="") {
    return webSitePath('/BACK/'.$crud);
}

/**
 * Retourne le lien vers un crud dans le navigateur
 */
function webAssetPath($morePath="") {
    return webSitePath('/assets/'.$morePath);
}

/**
 * Retourne le lien vers un crud dans le navigateur
 */
function webUploadPath($morePath="") {
    return webSitePath('/assets/uploads/'.$morePath);
}

?>