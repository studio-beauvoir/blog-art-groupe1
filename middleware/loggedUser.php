<?php

require_once __DIR__ . '/../util/index.php';
require_once __DIR__ . '/getUser.php';

// sinon l'user n'est pas connecté
var_dump($loggedUser);
die();
if(!$loggedUser) {
    header('location: '.webSitePath('/admin/connexion.php'));
}

?>