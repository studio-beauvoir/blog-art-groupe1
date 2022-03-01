<?php

$submitBtn = "Créer";
$pageCrud = "like de commentaire";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des likes de commentaires:'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe LikeArt
require_once __DIR__ . '/../../CLASS_CRUD/likecom.class.php'; 


// Instanciation de la classe LikeArt
$monLikeCom = new LIKECOM(); 


// Gestion des erreurs de saisie
$erreur = false;

$validator = Validator::make();
// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('numMemb'),
        ValidationRule::required('numSeqCom'),
        ValidationRule::required('numArt'),
        ValidationRule::required('likeC'),
    ])->bindValues($_POST);

    if($validator->success()) {

        // Saisies valides
        $erreur = false;

        $numMemb = $validator->verifiedField('numMemb');
        $numSeqCom = $validator->verifiedField('numSeqCom');
        $numArt = $validator->verifiedField('numArt');
        $likeC = $validator->verifiedField('likeC');
        
        var_dump($numSeqCom);

        $monLikeCom->create($numMemb, $numSeqCom, $numArt, $likeC);

        header("Location: ./likeCom.php");
        die();
    }   // Fin if ((isset($_POST['libStat'])) ...
    else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initLikeCom.php';


include __DIR__ . '/../../layouts/back/head.php';
?>
    <?=$validator->echoErrors() ?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="numMemb">Numéro du membre :</label>
            <input name="numMemb" id="numMemb" size="80" maxlength="80" value="<?= $validator->oldField('numMemb') ?>" />
        </div>

        <div class="field">
            <label for="numSeqCom">Numéro Seq du Commentaire :</label>
            <input name="numSeqCom" id="numSeqCom" size="80" maxlength="80" value="<?= $validator->oldField('numSeqCom') ?>" />
        </div>

        <div class="field">
            <label for="numArt">Numéro de l'article :</label>
            <input name="numArt" id="numArt" size="80" maxlength="80" value="<?= $validator->oldField('numArt') ?>" />
        </div>

        <div class="field">
            <label for="likeC">Like de l'article (1->like, 0-> pas de like) :</label>
            <input name="likeC" id="likeC" size="80" maxlength="80" value="<?= $validator->oldField('likeC') ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
