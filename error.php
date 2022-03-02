<?php
require_once __DIR__ . '/util/index.php';

$pageTitle = "Erreur 404";
require_once __DIR__ . '/layouts/front/head.php';
?>

    <div class=" container error-body">
        <img class="error-icon" src="<?= webAssetPath('svg/error404.svg') ?>" alt="Erreur 404">
        <div class="section-paragraph">
            <h1>Page introuvable</h1>
            <p>Il semblerait que vous vous soyez perdu entre pinceaux et bombes de peinture !</p>
            <p>Vous pouvez <a href="<?= webSitePath('/') ?>" class="interactif interactive-lien-text"><b>retourner à l'accueil</b></a> pour continuer de découvrir nos articles.</p>
        </div>
    </div>

<?php require_once __DIR__ . '/layouts/front/foot.php';?>