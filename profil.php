<?php

require_once __DIR__ . '/middleware/logged.php';

require_once __DIR__ . '/layouts/front/head.php';
?>
<div class="container">
    <h2>Votre profil</h2>
    <p>Identité : <?=$loggedMember['prenomMemb']?> <?=$loggedMember['nomMemb']?></p>
    <p>Pseudo : <?=$loggedMember['pseudoMemb']?></p>
    <p>Email : <?=$loggedMember['eMailMemb']?></p>
    <p><?=$loggedMember['libStat']?></p>
</div>
<?php require_once __DIR__ . '/layouts/front/foot.php'; ?>