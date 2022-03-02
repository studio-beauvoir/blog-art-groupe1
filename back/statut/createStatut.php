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

    $validator = Validator::make([
        ValidationRule::required('libStat')
    ])->bindValues($_POST);

    if($validator->success()) {

        // Saisies valides
        $erreur = false;

        // $libStat = ctrlSaisies($_POST['libStat']);
        $libStat = $validator->verifiedField('libStat');

        $monStatut->create($libStat);

        header("Location: ./statut.php");
        die();
    }   // Fin if ((isset($_POST['libStat'])) ...
    else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initStatut.php';

$pageTitle = "Créer un Statut";
$pageNav = ['Home:/admin.php', 'Gestion du Statut:./statut.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="libStat">Nom</label>
            <input name="libStat" id="libStat" size="80" maxlength="80" value="<?= $libStat; ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" href="./statut.php">Annuler</a>
            <input class="btn btn-lg" type="submit" value="Valider" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
