<?php

$submitBtn = "Éditer";
$pageCrud = "likeCom";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Modifier un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des likes de commentaires:'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe LikeArt
require_once __DIR__ . '/../../class_crud/likecom.class.php'; 
require_once __DIR__ . '/../../class_crud/comment.class.php'; 
require_once __DIR__ . '/../../class_crud/membre.class.php'; 
require_once __DIR__ . '/../../class_crud/article.class.php'; 

// Instanciation de la classe LikeArt
$monLikeCom = new likecom(); 
$monComm = new comment(); 
$monMembre = new membre();
$monArticle = new article();

// Gestion des erreurs de saisie
$erreur = false;

$validator = Validator::make();
// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('likeC'),
    ])->bindValues($_POST);

    if($validator->success()) {

        // Saisies valides
        $erreur = false;

        $numMemb = $_GET['numMemb'];
        $numSeqCom = $_GET['numSeqCom'];
        $numArt = $_GET['numArt'];
        $likeC = $validator->verifiedField('likeC') == "true"?1:0;
        
        $monLikeCom->update($numMemb, $numSeqCom, $numArt, $likeC);

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

if(!isset($_GET['numMemb'], $_GET['numArt'], $_GET['numSeqCom'])) {
    header("Location: ./likeCom.php");
    die();
}
$likeCom = $monLikeCom->get_1LikeCom($_GET['numMemb'], $_GET['numSeqCom'], $_GET['numArt']);
$numMemb = $likeCom['numMemb'];
$numArt = $likeCom['numArt'];
$likeC = $likeCom['likeC'];
?>
    <?=$validator->echoErrors() ?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?numMemb=<?=$_GET['numMemb'];?>&numArt=<?=$_GET['numArt'];?>&numSeqCom=<?=$_GET['numSeqCom']?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="numMemb">Quel membre</label>
            <select disabled name="numMemb" id="numMemb">
                <?php 
                    $allMembres = $monMembre->get_AllMembres();                    
                    foreach($allMembres as $membre) { 
                ?>
                    <option <?=$membre['numMemb']==$numMemb?'selected':'' ?> value="<?= $membre['numMemb'] ?>" ><?=$membre['pseudoMemb'] ?></option>
                <?php } ?>
            </select>
        </div>


        <div class="field">
            <label for="numSeqCom">Quel commentaire</label>
            <select disabled name="numSeqCom" id="numSeqCom">
                <?php 
                    $allComm = $monComm->get_AllComments();                    
                    foreach($allComm as $comm) { 
                ?>
                    <option <?=$comm['numSeqCom']==$numSeqCom?'selected':'' ?> value="<?= $comm['numSeqCom'] ?>" ><?=$comm['pseudoMemb'] ?>: <?=$comm['libCom'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="numArt">Quel article</label>
            <select disabled name="numArt" id="numArt">
                <?php 
                    $allArticles = $monArticle->get_AllArticles();                    
                    foreach($allArticles as $article) { 
                ?>
                    <option <?=$article['numArt']==$numArt?'selected':'' ?> value="<?= $article['numArt'] ?>" ><?=$article['libTitrArt'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="likeC">Like ?</label>
            <select name="likeC" id="likeC">
                <option <?=$likeC?'selected':'' ?> value="true">Oui</option>
                <option <?=$likeC?'':'selected' ?> value="false">Non</option>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" alt="Bouton réinitialiser" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
