<?php

$submitBtn = "Supprimer";
$pageCrud = "commentPlus";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn: $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

//Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../class_crud/commentplus.class.php'; 

// Instanciation de la classe langue
$monCommentPlus = new COMMENTPLUS(); 

// Ctrl CIR
// Insertion classe article
require_once __DIR__ . '/../../class_crud/article.class.php';

// Instanciation de la classe article
$monArticle = new ARTICLE();

// Insertion classe Comment
require_once __DIR__ . '/../../class_crud/comment.class.php';

// Instanciation de la classe Comment
$monComment = new COMMENT();

// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = Validator::make([
        ValidationRule::required('numSeqCom')
    ])->bindValues($_POST);

    if($validator->success()) {
        $numSeqCom = $validator->verifiedField('numSeqCom');
        $monCommentPlus->delete($numSeqCom);

        header("Location: $pagePrecedent");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, le Comment Plus à supprimer n'existe pas !";
    }

}   // End of if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initCommentPlus.php';

//Architecture Arthaud

include __DIR__ . '/../../layouts/back/head.php';


// Supp : récup id à supprimer
// id passé en GET
$commentPlus = $monCommentPlus->get_1CommentPlus($_GET['numSeqCom']);

$numSeqCom = $commentPlus['numSeqCom'];
$numArt = $commentPlus['numArt'];
$numSeqComR = $commentPlus['numSeqComR'];
$numArtR = $commentPlus['numArtR'];

?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?numSeqCom=<?=$_GET['numSeqCom']?>"
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="numSeqCom" name="numSeqCom" value="<?=$_GET['numSeqCom'] ?>" />

        <div class="field">
            <label for="numSeqCom">Numéro de Seq Commentaire</label>
            <input disabled name="numSeqCom" id="numSeqCom" size="80" maxlength="80" value="<?= $numSeqCom; ?>" />
        </div>

        <div class="field">
            <label for="numArt">Numéro de l'article</label>
            <input disabled name="numArt" id="numArt" size="80" maxlength="80" value="<?= $numArt; ?>" />
        </div>

        <div class="field">
            <label for="numSeqComR">Numéro de Seq Commentaire R </label>
            <input disabled name="numSeqComR" id="numSeqComR" size="80" maxlength="80" value="<?= $numSeqComR; ?>" />
        </div>

        <div class="field">
            <label for="numArtR">Numéro de l'article R </label>
            <input disabled name="numArtR" id="numArtR" size="80" maxlength="80" value="<?= $numArtR; ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?numSeqCom=<?=$_GET['numSeqCom'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent?>">Annuler</a>
            <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>