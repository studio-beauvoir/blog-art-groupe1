<?php

$submitBtn = "Créer";
$pageCrud = "likeCom";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des likes de commentaires:'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe LikeArt
require_once __DIR__ . '/../../CLASS_CRUD/likecom.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/comment.class.php'; 
require_once __DIR__ . '/../../class_crud/membre.class.php'; 
require_once __DIR__ . '/../../class_crud/article.class.php'; 

// Instanciation de la classe LikeArt
$monLikeCom = new LIKECOM(); 
$monComm = new COMMENT(); 
$monMembre = new MEMBRE();
$monArticle = new ARTICLE();

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
        $likeC = $validator->verifiedField('likeC') == "true"?1:0;
        
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
            <label for="numMemb">Quel membre</label>
            <select name="numMemb" id="numMemb">
                <?php 
                    $allMembres = $monMembre->get_AllMembres();                    
                    foreach($allMembres as $membre) { 
                ?>
                    <option <?=$membre['numMemb']==$validator->oldField('numMemb')?'selected':'' ?> value="<?= $membre['numMemb'] ?>" ><?=$membre['pseudoMemb'] ?></option>
                <?php } ?>
            </select>
        </div>


        <div class="field">
            <label for="numSeqCom">Quel commentaire</label>
            <select name="numSeqCom" id="numSeqCom">
                <?php 
                    $allComm = $monComm->get_AllComments();                    
                    foreach($allComm as $comm) { 
                ?>
                    <option <?=$comm['numSeqCom']==$validator->oldField('numSeqCom')?'selected':'' ?> value="<?= $comm['numSeqCom'] ?>" ><?=$comm['pseudoMemb'] ?>: <?=$comm['libCom'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="numArt">Quel article</label>
            <select name="numArt" id="numArt">
                <?php 
                    $allArticles = $monArticle->get_AllArticles();                    
                    foreach($allArticles as $article) { 
                ?>
                    <option <?=$article['numArt']==$validator->oldField('numArt')?'selected':'' ?> value="<?= $article['numArt'] ?>" ><?=$article['libTitrArt'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="likeC">Like?</label>
            <select name="likeC" id="likeC">
                <option <?=$likeC?'selected':'' ?> value="true">Oui</option>
                <option <?=$likeC?'':'selected' ?> value="false">Non</option>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
