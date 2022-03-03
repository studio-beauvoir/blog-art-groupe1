<?php
require_once __DIR__ . '../../../util/index.php';
require_once __DIR__ . '../../../middleware/userShouldBeMoreThanUser.php';

// Gestion des CIR => affichage erreur sinon
$errCIR = isset($_GET['err_cir']) && $_GET['err_cir'] == true;

$listErrors = [];

if (isset($errDel) && ($errDel == 99) ) { 
    array_push($listErrors ,"Erreur delete langue : la suppression s'est mal passée !");
}

if ($errCIR) {
    array_push($listErrors ,"Suppression impossible, existence de thématique(s), angle(s) et/ou mot(s) clé(s) associé(s) à cette langue. Vous devez d'abord supprimer le(s) thématique(s), le(s) angle(s) ou le(s) mots clés concerné(s).");
}
if (isset($erreur) && $erreur && isset($errSaisies)) { 
    array_push($listErrors , $errSaisies);
}
?>

<!DOCTYPE html>
<html lang="fr-FR">
    <head>
        <meta charset="utf-8" />
        <title><?= isset($pageTitle)?$pageTitle:'Title' ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />


        <link href="<?= webAssetPath('css/var.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= webAssetPath('css/master.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= webAssetPath('css/admin.css') ?>" rel="stylesheet" type="text/css" />

        <!-- editeur bbcode -->
        <link href="<?= webAssetPath('css/bbeditor.css') ?>" rel="stylesheet" type="text/css" />


        <script src="<?= webAssetPath('js/img-input-preview.js') ?>"></script>
        <script src="<?= webAssetPath('js/cancel-btn.js') ?>"></script>
        
        <!-- <link href="<?= webAssetPath('css/style.css') ?>" rel="stylesheet" type="text/css" /> -->
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

            <?php if(count($listErrors)>0) { ?>
            <div class="errors">
                <?php foreach($listErrors as $error) { ?>
                    <div class="error"><?=$error ?></div>
                <?php } ?>
            </div>
            <?php } ?>