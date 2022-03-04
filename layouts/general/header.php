<?php
require_once __DIR__ . '/../../middleware/getMember.php';
?>
<header >
    <div class="header-box container ">
        <div class="header-box-logo">
            <a href="<?= webSitePath('/')?>"><img class="logo" src="<?= webAssetPath('img/logo.png') ?>" alt="logo du blog bordeaux street art"></a>
        </div>
        <nav class="header-box-liste">
            <ul>
                <li class="searchbar">
                    <form class="searchbar-form" action="<?= webSitePath('/search.php')?>" method="GET" title="Recherche par mots clés">
                        <!-- Pourquoi pas ajouter un menu déroulant pour ne pouvoir sélectionner que des mots clés enregistrés dans la base de données...-->
                        <input name="motCle" class="searchbar-input" placeholder="Rechercher...">
                        <button class="btn-none" type="submit" ><img class="searchbar-icon" src="<?= webAssetPath('svg/search.svg') ?>" title="Recherche par mots clés"></button>
                    </form>
                    
                </li>
                <li><a href="<?= webSitePath('/')?>" class="interactive-lien-text white">Accueil</a></li>
                <?php if(!$loggedMember): ?>
                    <li><a href="<?= webSitePath('/connexion.php')?>" class="interactive-lien-text white">Connexion</a></li>
                    <li ><a href="<?= webSitePath('/inscription.php')?>" class="interactive-lien-text white">Inscription</a></li> 
                <?php else: ?>
                    <li ><a href="<?= webSitePath('/profil.php')?>" class="interactive-lien-text white">Profil</a></li> 
                    <li ><a href="<?= webSitePath('/deconnexion.php')?>" class="interactive-lien-text white">Se déconnecter</a></li> 
                <?php endif; ?>
            </ul> 
        </nav>
    </div>
</header>