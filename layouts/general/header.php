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
                <li class="joe"> 
                    <input type="text" class="research-bar">
                    <svg width="35" height="34" viewBox="0 0 112 111" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M37.2718 72.1464C56.7135 72.1464 72.4742 56.4249 72.4742 37.0314C72.4742 17.638 56.7135 1.9165 37.2718 1.9165C17.83 1.9165 2.06934 17.638 2.06934 37.0314C2.06934 56.4249 17.83 72.1464 37.2718 72.1464Z" fill="white" stroke="white" stroke-width="2.87069" stroke-miterlimit="10"/>
                        <path d="M100.901 106.388L59.1074 64.5946L64.9034 58.813L106.697 100.606L100.901 106.388Z" fill="white" stroke="white" stroke-width="2.87069" stroke-miterlimit="10"/>
                        <path d="M105.556 109.468C107.796 109.468 109.612 107.564 109.612 105.215C109.612 102.866 107.796 100.962 105.556 100.962C103.316 100.962 101.5 102.866 101.5 105.215C101.5 107.564 103.316 109.468 105.556 109.468Z" fill="white" stroke="white" stroke-width="2.87069" stroke-miterlimit="10"/>
                        <path d="M37.2717 69.8015C55.4152 69.8015 70.1234 55.1298 70.1234 37.0313C70.1234 18.9329 55.4152 4.26123 37.2717 4.26123C19.1282 4.26123 4.41992 18.9329 4.41992 37.0313C4.41992 55.1298 19.1282 69.8015 37.2717 69.8015Z" fill="white" stroke="black" stroke-width="2.87069" stroke-miterlimit="10"/>
                        <path d="M38.8501 60.744C51.3997 60.744 61.5732 50.5958 61.5732 38.0773C61.5732 25.5589 51.3997 15.4106 38.8501 15.4106C26.3004 15.4106 16.127 25.5589 16.127 38.0773C16.127 50.5958 26.3004 60.744 38.8501 60.744Z" fill="black" stroke="black" stroke-width="0.956897" stroke-miterlimit="10"/>
                        <path d="M36.3843 56.3534C48.9339 56.3534 59.1074 46.2051 59.1074 33.6867C59.1074 21.1682 48.9339 11.02 36.3843 11.02C23.8346 11.02 13.6611 21.1682 13.6611 33.6867C13.6611 46.2051 23.8346 56.3534 36.3843 56.3534Z" fill="black" stroke="black" stroke-width="0.956897" stroke-miterlimit="10"/>
                        <path d="M44.9785 47.4452C57.2188 40.3957 63.0659 27.6395 58.0384 18.9535C53.0109 10.2675 39.0126 8.94095 26.7723 15.9905C14.5321 23.0401 8.68496 35.7963 13.7125 44.4822C18.74 53.1682 32.7382 54.4948 44.9785 47.4452Z" fill="white"/>
                        <path d="M48.2416 55.9813C61.4133 48.3953 67.1797 33.7604 61.1212 23.2932C55.0628 12.8261 39.4737 10.4904 26.302 18.0764C13.1304 25.6624 7.36398 40.2973 13.4224 50.7645C19.4809 61.2316 35.07 63.5673 48.2416 55.9813Z" fill="white"/>
                        <path d="M102.952 106.94L59.1074 63.1237L63.3363 58.9053L107.181 102.71L102.952 106.94Z" fill="black" stroke="black" stroke-width="2.87069" stroke-miterlimit="10"/>
                        <path d="M105.798 108.549C107.446 108.549 108.782 107.211 108.782 105.56C108.782 103.91 107.446 102.572 105.798 102.572C104.15 102.572 102.813 103.91 102.813 105.56C102.813 107.211 104.15 108.549 105.798 108.549Z" fill="black" stroke="black" stroke-width="2.87069" stroke-miterlimit="10"/>
                        <path d="M107.305 101.766L101.82 106.854L102.864 107.973L108.349 102.886L107.305 101.766Z" fill="white"/>
                        <path d="M65.4302 59.8216L59.9956 65.2427L61.0793 66.3236L66.5139 60.9025L65.4302 59.8216Z" fill="white"/>
                        <path d="M73.2925 69.8013C77.6366 73.6863 82.1651 78.0082 86.7627 82.8013C90.8879 87.1001 94.6329 91.33 98.0321 95.399L73.2925 69.8013Z" fill="white"/>
                    </svg>
                </li>
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