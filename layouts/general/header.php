<?php
require_once __DIR__ . '/../../middleware/getMember.php';
?>
<header >
    <div class="header-box container ">
    <div class="header-box-logo">
        <a href="<?= webSitePath('/admin.php')?>"><img class="logo" src="<?= webAssetPath('img/logo.png') ?>" alt="logo du blog bordeaux street art"></a>
    </div>
    <nav class="header-box-liste">
        <ul>
            <li><a href="<?= webSitePath('/home.php')?>" class="interactive-lien-text">Accueil</a></li>
            <?php if(!$loggedMember): ?>
                <li><a href="<?= webSitePath('/connexion.php')?>" class="interactive-lien-text">Connexion</a></li>
                <li ><a href="<?= webSitePath('/inscription.php')?>" class="interactive-lien-text">Inscription</a></li> 
            <?php else: ?>
                <li ><a href="<?= webSitePath('/profil.php')?>" class="interactive-lien-text">Profil</a></li> 
                <li ><a href="<?= webSitePath('/deconnexion.php')?>" class="interactive-lien-text">Se déconnecter</a></li> 
            <?php endif; ?>
        </ul> 
    </nav>
    </div>
</header>