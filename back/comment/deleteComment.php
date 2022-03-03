<?php

$submitBtn = "Supprimer";
$pageCrud = "comment";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.':'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../class_crud/comment.class.php';  
require_once __DIR__ . '/../../class_crud/article.class.php';  
require_once __DIR__ . '/../../class_crud/membre.class.php';  

$monComment = new comment();
$monArticle = new article();
$monMembre = new membre();

$validator = Validator::make();


// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('idCom'),
        ValidationRule::required('idArt'),
    ])->bindValues($_GET);

    if($validator->success()) {
        $numSeqCom = $validator->verifiedField('idCom');
        $numArt = $validator->verifiedField('idArt');
        
        $monComment->delete($numSeqCom, $numArt);

        header("Location: $pagePrecedent");
        die();
    }
}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")


// Init variables form
include __DIR__ . '/initComment.php';

include __DIR__ . '/../../layouts/back/head.php';

// affichage des erreurs
$validator->echoErrors();

    if(!isset($_GET['idCom']) OR !isset($_GET['idArt'])) {
        header("Location: $pagePrecedent");
        die();
    }
    $comment = $monComment->get_1Comment($_GET['idCom'],$_GET['idArt']);
    $numMemb = $comment['numMemb'];
    $idSeqCom = $comment['numSeqCom'];
    $attModOK = $comment['attModOK'];
    $numSeqCom = $comment['numSeqCom'];
    $numArt = $comment['numArt'];
    $libCom = $comment['libCom'];

    $membre = $monMembre->get_1Membre($numMemb);
    $article = $monArticle->get_1Article($numArt);

?>
<form 
    class="admin-form"
    method="POST" 
    action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?idCom=<?=$_GET['idCom']?>&idArt=<?=$_GET['idArt']?>" 
    enctype="multipart/form-data" 
    accept-charset="UTF-8"
>

    <div class="field">
        <label for="pseudoMemb">Quel membre</label>
        <input disabled name="pseudoMemb" id="pseudoMemb" size="80" maxlength="80" value="<?= $membre['pseudoMemb']; ?>" />
    </div>

    <div class="field">
        <label for="libTitrArt">Quel article</label>
        <input disabled name="libTitrArt" id="libTitrArt" size="80" maxlength="80" value="<?= $article['libTitrArt']; ?>" />
    </div>

    <div class="field">
        <label for="libCom">Commentaire</label>
        <input disabled name="libCom" value="<?=$libCom?>" id="libCom" size="80" maxlength="80" />
    </div>

    <div class="controls">
        <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
        <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
    </div>
</form>

<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>