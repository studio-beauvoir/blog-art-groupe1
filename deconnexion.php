<?php
require_once __DIR__ . '/util/index.php';

logoutMember();

header('location: '.webSitePath('/'));
?>