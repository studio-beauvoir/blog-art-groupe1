<?php

require_once __DIR__ . '/../util/index.php';
require_once __DIR__ . '/getMember.php';

// sinon le membre n'est pas connecté
if(!$loggedMember) {
    header('location: '.webSitePath('/connexion.php'));
}

?>