<?php
require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '../../../middleware/getUser.php';
?>
<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="utf-8" />
        <title><?= isset($pageTitle)?$pageTitle:'Title' ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link href="<?= webSitePath() ?>/assets/css/var.css" rel="stylesheet" type="text/css" />
        <link href="<?= webSitePath() ?>/assets/css/master.css" rel="stylesheet" type="text/css" />
        <link href="<?= webSitePath() ?>/assets/css/front.css" rel="stylesheet" type="text/css" />
        <link href="<?= webSitePath() ?>/assets/css/error.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?= webSitePath() ?>/assets/css/style.css" rel="stylesheet" type="text/css" /> -->

    </head>
    <body>
        <?php require_once __DIR__ . '/../general/header.php'; ?>
        <main class="container-fluid">

        <?php if($loggedUser): ?>
            <div class="container container-full">
                <div class="admin-statut">
                    <div class="admin-statut-inner">
                        <label>Administration</label>
                        <h3><?=$loggedUser['pseudoUser'] ?></h3>
                        <a href="<?= webSitePath('/admin/deconnexion.php')?>" class="interactive-lien-text">Se déconnecter</a>
                    </div>
                </div>
            </div>
        <?php endif ?>
