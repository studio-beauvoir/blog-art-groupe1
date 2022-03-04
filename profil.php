<?php

require_once __DIR__ . '/middleware/loggedMember.php';

require_once __DIR__ . '/layouts/front/head.php';
?>
<div class="container section-profil">
        <div class="identity-box">
            <div class="pdp">
                <img class="svg-avatar" src="<?= webAssetPath('svg/avatar.svg') ?>" alt="avatar par défault du blog Bordeaux Street Art" >
            </div>
            <div class="vous-box">
                <div class="vous-item">
                <h2>Mon profil</h2>
                </div>
                <div class="vous-item">
                <label>Pseudo</label> 
                <p class="interactive-lien-text"><?=$loggedMember['pseudoMemb']?></p>
                </div>
                <div class="vous-item">
                <label>Statut</label>
                <p class="interactive-lien-text"><?=$loggedMember['libStat']?></p>
                </div>
            </div>
        </div>
        <div class="donnee-box">
            <div>
                <h3>Données de votre profil</h3>
                <div class="donnee">
                <label>Prénom</label>
                <p class="interactive-lien-text"><?=$loggedMember['prenomMemb']?></p>
                </div>
                <div class="donnee">
                <label>Nom</label>
                <p class="interactive-lien-text"><?=$loggedMember['nomMemb']?> </p>
                </div>
                <div class="donnee">
                <label>Email</label>
                <p class="interactive-lien-text"><?=$loggedMember['eMailMemb']?></p>
                </div>
            </div>
        </div>
</div>
<?php require_once __DIR__ . '/layouts/front/foot.php'; ?>