<?php

// Parametres max fichier image
define('MAX_IMG_SIZE', 10*1000*1000);    // Taille en octets (max 10 Mo)
// define('WIDTH_MAX', 80000);       // Largeur en pixels
// define('HEIGHT_MAX', 80000);      // Hauteur en pixels



function getImageExtensionsAllowed() {
    return ['jpg','gif','png','jpeg'];
}

function isImage($file) {
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    
    // check extension
    if( !in_array(strtolower($extension), getImageExtensionsAllowed()) ) return false;


    $infosImg = getimagesize($file['tmp_name']);

    // check si c'est bien une image
    if( !($infosImg[2] >= 1) OR !($infosImg[2] <= 14)) return false;

    // Parcours tableau erreurs et verif typage
    if(!isset($file['error']) OR UPLOAD_ERR_OK !== $file['error'] ) return false;

    // si tout est bon on retourne true
    return true;
}



function uploadImage($file, $filename=false) {
    // récupère l'extension
    $extension  = pathinfo($file['name'], PATHINFO_EXTENSION);
    
    // 'imgArt' . md5(uniqid()) 

    // la concatène avec le nom de fichier défini le cas échéant.
    // sinon avec le nom du fichier par défaut
    if(!$filename) $filename = $file['name'];
    $nomImage = $filename . '.' . $extension;

    // enregistre le fichier
    $isUploaded = move_uploaded_file($file['tmp_name'], uploadPath($nomImage));
    // retourne le résultat (bool)
    return [
        'is_uploaded' => $isUploaded,
        'filename' => $nomImage
    ];    /*-- --------------------------------------------------------------- --*/
}