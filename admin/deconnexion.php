<?php
require_once __DIR__ . '/util/index.php';

logout();

header('location: '.webSitePath('/'));
?>