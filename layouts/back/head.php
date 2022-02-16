<?php
require_once __DIR__ . '../../../util/index.php';

?>

<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="utf-8" />
        <title><?= isset($pageTitle)?$pageTitle:'Title' ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link href="<?= webSitePath() ?>/assets/css/var.css" rel="stylesheet" type="text/css" />
        <link href="<?= webSitePath() ?>/assets/css/master.css" rel="stylesheet" type="text/css" />
        <link href="<?= webSitePath() ?>/assets/css/admin.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?= webSitePath() ?>/assets/css/style.css" rel="stylesheet" type="text/css" /> -->
    </head>
    <body>
        <?php 
            require_once __DIR__ . './../general/header.php';
        ?>