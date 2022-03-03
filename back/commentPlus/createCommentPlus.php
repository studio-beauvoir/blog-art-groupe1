<?php

$submitBtn = "Créer";
$pageCrud = "comment plus";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des ' .$pageCrud .$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Comment Plus
require_once __DIR__ . '/../../class_crud/commentplus.class.php'; 

// Instanciation de la classe Comment Plus
$monCommentPlus = new commentplus(); 

// Insertion classe Article
require_once __DIR__ . '/../../class_crud/article.class.php'; 

// Instanciation de la classe Article
$monArticle = new article(); 

// Insertion classe Comment
require_once __DIR__ . '/../../class_crud/comment.class.php'; 

// Instanciation de la classe Comment
$monComment = new comment();

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
            <select name="numSeqCom" id="numSeqCom">
                <?php
                    $allCommentPlus = $monCommentPlus->get_AllCommentPlus();
                    foreach($allCommentPlus as $commentPlus) {
                ?>
                    <option <?=$commentPlus['numSeqCom']==$validator->oldField('numSeqCom')?'selected': '' ?> value="<?= $commentPlus['numSeqCom'] ?> "><?=$commentPlus['numSeqCom'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="numArt">Numéro de l'article :</label>
            <select name="numArt" id="numArt">
                <?php
                    $allCommentPlus = $monCommentPlus->get_AllCommentPlus();
                    foreach($allCommentPlus as $commentPlus) {
                ?>
                <option <?=$commentPlus['numArt']==$validator->oldField('numArt')?'selected': '' ?> value="<?= $commentPlus['numArt'] ?> "><?=$commentPlus['numArt'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="numSeqComR">Numéro de Seq Commentaire R :</label>
            <select name="numSeqComR" id="numSeqComR">
                <?php
                    $allCommentPlus = $monCommentPlus->get_AllCommentPlus();
                    foreach($allCommentPlus as $commentPlus) {
                ?>
                <option <?=$commentPlus['numSeqComR']==$validator->oldField('numSeqComR')?'selected': '' ?> value="<?= $commentPlus['numSeqComR'] ?> "><?=$commentPlus['numSeqComR'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="numArtR">Numéro de l'article R :</label>
            <select name="numArtR" id="numArtR">
                <?php
                    $allCommentPlus = $monCommentPlus->get_AllCommentPlus();
                    foreach($allCommentPlus as $commentPlus) {
                ?>
                <option <?=$commentPlus['numArtR']==$validator->oldField('numArtR')?'selected': '' ?> value="<?= $commentPlus['numArtR'] ?> "><?=$commentPlus['numArtR'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
