<?php

require_once __DIR__ . '/../util/index.php';

 

$loggedMember = getLoggedMemberOrFalse();
var_dump($loggedMember);
// sinon le membre n'est pas connecté
if(!$loggedMember) {
    header('location: '.webSitePath('/connexion.php'));
}

?>