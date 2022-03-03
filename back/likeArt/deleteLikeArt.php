<?php
$submitBtn = "Supprimer";
$pageCrud = "like d'article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Supprimer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];


require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../class_crud/likeart.class.php';
$monLikeArt = new likeart(); 

// Ctrl CIR
// Insertion classe Article
require_once __DIR__ . '/../../class_crud/article.class.php';
// Instanciation de la classe Article
$monArticle = new likeart(); 



// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {



    // controle CIR

    // delete effective de l'angle

    $validator = Validator::make([
        ValidationRule::required('numMemb'),
        ValidationRule::required('numArt')
    ])->bindValues($_POST);

    if($validator->success()) {
        $numMemb = $validator->verifiedField('numMemb');
        $numArt = $validator->verifiedField('numArt');
        $monLikeArt->delete($numMemb, $numArt);

        header("Location: $pagePrecedent");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, le like article à supprimer n'existe pas !";
    }

}

// Init variables form
include __DIR__ . '/initLikeArt.php';
include __DIR__ . '/../../layouts/back/head.php';

// controles
if(!isset($_GET['numMemb'], $_GET['numArt'])); //header("Location: $pagePrecedent")
$likeArt = $monLikeArt->get_1LikeArt($_GET['numMemb'], $_GET['numArt']);
if(!$likeArt) header("Location: $pagePrecedent");

$numMemb = $likeArt['numMemb'];
$numArt = $likeArt['numArt'];
?>
    <form
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id']?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?>" />
        
        <div class="field">
            <label for="numMemb">Numéro du membre</label>
            <input disabled name="numMemb" value="<?=$numMemb?>" id="numMemb" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="numArt">Numéro de l'article</label>
            <input disabled name="numArt" value="<?=$numArt?>" id="numArt" size="80" maxlength="80" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>