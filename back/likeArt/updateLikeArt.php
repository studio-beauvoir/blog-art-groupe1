<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Angle
require_once __DIR__ . '/../../class_crud/likeart.class.php'; 

// Instanciation de la classe Angle
$monLikeArt = new LIKEART(); 

// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if(isset($_POST['Submit'])){
        $Submit = $_POST['Submit'];
    } else {
        $Submit = "";
    }

    $validator = Validator::make([
        ValidationRule::required('numMemb'),
        ValidationRule::required('numArt'),
        ValidationRule::required('likeA')
    ])->bindValues($_POST);

    if($validator->success()) {
        // Saisies valides
        $erreur = false;

        $numMemb = $validator->verifiedField('numMemb');
        $numArt = $validator->verifiedField('numArt');
        $likeA = $validator->verifiedField('likeA');
        $monLikeArt->update($numMemb, $numArt, $likeA);


        header("Location: ./likeArt.php");
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies
}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")


// Init variables form
include __DIR__ . '/initLikeArt.php';

$pageTitle = "Modifier un like d'article";
$pageNav = ['Home:/admin.php', 'Gestion des likes d articles:./likeArt.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
<?php
    // Modif : récup id à modifier
    // id passé en GET

    if(!isset($_GET['numMemb'], $_GET['numArt'])) {
        header("Location: ./likeArt.php");
        die();
    }
    $likeArt = $monLikeArt->get_1LikeArt($_GET['numMemb'], $_GET['numArt']);
    $numMemb = $likeArt['numMemb'];
    $numArt = $likeArt['numArt'];

?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="id" name="id" value="<?=$_GET['id'] ?>" />

        <div class="field">
            <label for="numMemb">Numéro du membre</label>
            <input name="numMemb" id="numMemb" size="80" maxlength="80" value="<?= $numMemb; ?>" />
        </div>

        <div class="field">
            <label for="numArt">Numéro de l'article :</label>
            <input name="numArt" id="numArt" size="80" maxlength="80" value="<?= $numArt; ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" href="./angle.php">Annuler</a>
            <input class="btn btn-lg" type="submit" value="Valider" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
