<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../class_crud/statut.class.php'; 

// Instanciation de la classe Statut
$monStatut = new STATUT(); 

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
        ValidationRule::required('libStat'),
        ValidationRule::required('id')
    ])->bindValues($_POST);

    if($validator->success()) {
        // Saisies valides
        $erreur = false;

        $libStat = ctrlSaisies($_POST['libStat']);
        $idStat = ctrlSaisies($_POST['id']);
        $monStatut->update($idStat, $libStat);

        header("Location: ./statut.php");
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies
}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")


// Init variables form
include __DIR__ . '/initStatut.php';

$pageTitle = "Modifier un Statut";
$pageNav = ['Home:/admin.php', 'Gestion du Statut:./statut.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
<?php
    // Modif : récup id à modifier
    // id passé en GET

    if(!isset($_GET['id'])) {
        header("Location: ./statut.php");
        die();
    }
    $statut = $monStatut->get_1Statut($_GET['id']);

    $libStat = $statut['libStat'];

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
            <label for="libStat">Nom</label>
            <input name="libStat" id="libStat" size="80" maxlength="80" value="<?= $libStat; ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" href="./statut.php">Annuler</a>
            <input class="btn btn-lg" type="submit" value="Valider" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
