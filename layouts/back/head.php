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
        <?php require_once __DIR__ . './../general/header.php'; ?>
        <main>
            <div class="page-header">
            <?php require_once __DIR__ . '/../../layouts/back/nav.php'; ?>
            <?php if(isset($pageTitle)) { ?>
                <h2><?=$pageTitle?></h2>
            <?php } ?>
            </div>

            <?php if (isset($errDel) && ($errDel == 99) ) { ?>
                <i><div class="error">=>Erreur delete LANGUE : la suppression s'est mal passée !</div></i>
            <?php } ?>

            <?php if (isset($errCIR) && ($errCIR == 1) ) { ?>
                <i><div class="error">=>Suppression impossible, existence de thématique(s), angle(s) et/ou mot(s) clé(s) associé(s) à cette langue. Vous devez d'abord supprimer le(s) thématique(s), le(s) angle(s) ou le(s) mots clés concerné(s).</div></i>
            <?php } ?>