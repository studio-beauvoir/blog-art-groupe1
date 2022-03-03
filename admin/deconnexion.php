<?php
require_once __DIR__ . '/../util/index.php';

logoutUser();

header('location: '.webSitePath('/'));
?>