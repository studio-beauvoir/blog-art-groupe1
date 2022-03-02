<?php

$submitBtn = "Créer";
$pageCrud = "comment plus";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des ' .$pageCrud .$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Comment Plus
require_once __DIR__ . '/../../CLASS_CRUD/commentplus.class.php'; 

// Instanciation de la classe Comment Plus
$monCommentPlus = new COMMENTPLUS(); 

// Insertion classe Article
require_once __DIR__ . '/../../CLASS_CRUD/article.class.php'; 

// Instanciation de la classe Article
$monArticle = new ARTICLE(); 

// Gestion des erreurs de saisie
$erreur = false;

$validator = Validator::make();
// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('numSeqCom'),
        ValidationRule::required('numArt'),
        ValidationRule::required('numSeqComR'),
        ValidationRule::required('numArtR'),
    ])->bindValues($_POST);

    if($validator->success()) {

        // Saisies valides
        $erreur = false;

        $numSeqCom = $validator->verifiedField('numSeqCom');
        $numArt = $validator->verifiedField('numArt');
        $numSeqComR = $validator->verifiedField('numSeqComR');
        $numArtR = $validator->verifiedField('numArtR');
        
        // var_dump($numSeqCom);

        $monCommentPlus->create($numSeqCom, $numArt, $numSeqComR, $numArtR);

        header("Location: ./commentplus.php");
        die();
    }   // Fin if ((isset($_POST['libStat'])) ...
    else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initCommentPlus.php';


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
            <label for="numSeqCom">Numéro de Seq Commentaire :</label>
            <input name="numSeqCom" id="numSeqCom" size="80" maxlength="80" value="<?= $validator->oldField('numSeqCom') ?>" />
        </div>

        <div class="field">
            <label for="numArt">Numéro de l'article :</label>
            <input name="numArt" id="numArt" size="80" maxlength="80" value="<?= $validator->oldField('numArt') ?>" />
        </div>

        <div class="field">
            <label for="numSeqComR">Numéro de Seq Commentaire R :</label>
            <input name="numSeqComR" id="numSeqComR" size="80" maxlength="80" value="<?= $validator->oldField('numSeqComR') ?>" />
        </div>

        <div class="field">
            <label for="numArtR">Numéro de l'article R :</label>
            <input name="numArtR" id="numArtR" size="80" maxlength="80" value="<?= $validator->oldField('numArtR') ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
