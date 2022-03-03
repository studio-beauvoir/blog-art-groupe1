<?php

require_once __DIR__ . '/../util/index.php';
require_once __DIR__ . '/getUser.php';

// sinon l'user n'est pas connecté
if(!$loggedUser) {
    header('location: '.webSitePath('/admin/connexion.php'));
}

?>