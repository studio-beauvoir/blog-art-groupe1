<?php

require_once __DIR__ . '/../util/index.php';
require_once __DIR__ . '/getUser.php';


if(!$loggedUser) {
    header('location: '.webSitePath('/admin/connexion.php'));
}

?>