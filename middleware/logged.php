<?php

require_once __DIR__ . '/../util/index.php';

 

$loggedUser = getLoggedUserOrFalse();
var_dump($loggedUser);
// sinon le membre n'est pas connecté
if(!$loggedUser) {
    header('location: '.webSitePath('/connexion.php'));
}

?>