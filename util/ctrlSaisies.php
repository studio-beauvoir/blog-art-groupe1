<?php
///////////////////////////////////////////////////////
//
//  Script : ctrlSaisies.php
//
///////////////////////////////////////////////////////

function ctrlSaisies($saisie){

    // Convertion caractères spéciaux en entités HTML => peu performant
    // Préférer htmlentities()
    // $saisie = htmlspecialchars($saisie);
    
    // Suppression des espaces (ou d'autres caractères) en début et fin de chaîne
    $saisie = trim($saisie);
    // Suppression des antislashs d'une chaîne
    $saisie = stripslashes($saisie);
    
    // Conversion des caractères spéciaux en entités HTML y compris les accents
    // $saisie = htmlentities($saisie);

    // Conversion des caractères spéciaux en entités HTML
    $saisie = htmlspecialchars($saisie);

    $saisie = preg_replace('/&(amp;){2,}/', '&amp;', $saisie);

    return $saisie;
}
