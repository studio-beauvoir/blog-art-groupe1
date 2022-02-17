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
    ];
}

function e() {
    /************************************************************
     * Creation dossier cible si inexistant
     *************************************************************/
    if (!is_dir(TARGET)) {
        if (!mkdir(TARGET, 0755)) {
        exit("<p><font color='red'>Erreur : création du dossier 'uploads' impossible ! <br>Vérifiez les droits en création ou créer le dossier en amont !</font>");
        } // End of if (!mkdir(TARGET, 0755))
    } else {
        $target_OK = true;
    }

    /************************************************************
     * Script d'upload
     *************************************************************/

    /*-- --------------------------------------------------------------- --*/
    // Recuperation extension fichier
    $extension  = pathinfo($_FILES['monfichier']['name'], PATHINFO_EXTENSION);

    // verif extension fichier
    if (in_array(strtolower($extension), $tabExt)) {
    // recup dimensions fichier
    $infosImg = getimagesize($_FILES['monfichier']['tmp_name']);

    // verif type image
    if ($infosImg[2] >= 1 AND $infosImg[2] <= 14) {
        // verif dimensions et taille image
        if (($infosImg[0] <= WIDTH_MAX) AND ($infosImg[1] <= HEIGHT_MAX) AND
            (filesize($_FILES['monfichier']['tmp_name']) <= MAX_SIZE)) {
        // Parcours tableau erreurs
        if (isset($_FILES['monfichier']['error']) AND
            UPLOAD_ERR_OK === $_FILES['monfichier']['error']) { // Vérif typage
            // rename fichier
            $nomImage = 'imgArt' . md5(uniqid()) . '.' . $extension;

            if (move_uploaded_file($_FILES['monfichier']['tmp_name'], TARGET.$nomImage)) {
                // upload OK
                $etatImg = 1;
                $uploadOK = true;
            } else {
                // erreur systeme
                $etatImg = 2;
            }
        } else {
            // erreur interne
            $etatImg = 3;
        }
        } else {
            // erreur dimensions et taille image
            $etatImg = 4;
        }
    } else {
        // erreur type image
        $etatImg = 5;
    }
    } else {
    // erreur pour l'extension
    $etatImg = 6;
    }
    /*-- --------------------------------------------------------------- --*/
        switch ($etatImg) {
            // Si OK, test upload
            case 1:
                $msg = "<p>Upload d'une image sur le serveur :<br>";
                $msg .= "<font color='green'>&nbsp;&nbsp;=>>&nbsp;&nbsp;L'envoi de l'image a bien été effectué !</font><br /></p>";
            break;
            case 2:
                // Sinon affiche erreur systeme
                $msg = "<p>Upload d'une image sur le serveur :<br>";
                $msg .= "<font color='red'>&nbsp;&nbsp;=>>&nbsp;&nbsp;Erreur systeme. Problème lors de l'upload !</font></p>";
            break;
            case 3:
                $msg = "<p>Upload d'une image sur le serveur :<br>";
                $msg .= "<font color='red'>&nbsp;&nbsp;=>>&nbsp;&nbsp;Upload de l'image impossible : erreur interne !</font></p>";
            break;
            case 4:
                $msg = "<p>Upload d'une image sur le serveur :<br>";
                $msg .= "<font color='red'>&nbsp;&nbsp;=>>&nbsp;&nbsp;Erreur dimensions : ";
                $msg .= "Le fichier est trop volumineux :<br />";
                $msg .= "<b>(Poids limité à 2Go) !</b></font></p>";
            break;
            case 5:
                $msg = "<p>Upload d'une image sur le serveur :<br>";
                $msg .= '<font color="red">&nbsp;&nbsp;=>>&nbsp;&nbsp;Upload de l\'image impossible : Le fichier n\'est pas une image !</font></p>';
            break;
            case 6:
                $msg = "<p>Upload d'une image sur le serveur :<br>";
                $msg .= "<font color='red'>&nbsp;&nbsp;=>>&nbsp;&nbsp;L'extension du fichier n'est pas autorisée. <br /></font>";
                $msg .= "<font color='red'>(Seuls les fichiers jpg, jpeg, gif, png sont acceptés.)</font></p>";
            break;
            default:
                $msg = '<p><font color="red">&nbsp;&nbsp;=>>&nbsp;&nbsp;Problème lors de l\'upload ! Contactez l\'administrateur.</font> </p>';
                break;
        }
    /*-- --------------------------------------------------------------- --*/
}