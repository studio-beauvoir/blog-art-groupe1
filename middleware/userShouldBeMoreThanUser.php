<?php

require_once __DIR__ . '/loggedUser.php';

// user doit être plus qu'un simple utilisateur 
// il doit ête admin, modérateur ou superviseur
// il ne doit donc pas avoir le statut d'id 3 ou 4
if( !($loggedUser['idStat']=='3' OR $loggedUser['idStat']=='4') ) {
    header('location: '.webSitePath('/erreur400.php'));
    die();
}

?>