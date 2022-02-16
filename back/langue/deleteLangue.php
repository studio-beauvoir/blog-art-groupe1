<?php

$submitBtn = "Supprimer";
$pageCrud = "langue";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn: $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

//Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php'; 

// Instanciation de la classe langue
$maLangue = new LANGUE(); 

// Ctrl CIR
// Insertion classe Angle
require_once __DIR__ . '/../../CLASS_CRUD/angle.class.php';

// Instanciation de la classe Angle
$monAngle = new ANGLE();

// Insertion classe Thematique
require_once __DIR__ . '/../../CLASS_CRUD/thematique.class.php';
// Instanciation de la classe Thematique
$maThematique = new THEMATIQUE();

// Insertion classe Motcle
require_once __DIR__ . '/../../CLASS_CRUD/motcle.class.php';
// Instanciation de la classe Motcle
$monMotCle = new MOTCLE();


// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = Validator::make([
        ValidationRule::required('id')
    ])->bindValues($_POST);

    if($validator->success()) {
        $numLang = $validator->verifiedField('id');
        $maLangue->delete($numLang);

        header("Location: $pagePrecedent");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, la langue à supprimer n'existe pas !";
    }

}   // End of if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initLangue.php';

//Architecture Arthaud

include __DIR__ . '/../../layouts/back/head.php';


// Supp : récup id à supprimer
// id passé en GET
$langue = $maLangue->get_1Langue($_GET['id']);

$numPays = $langue['numPays'];
$lib1Lang = $langue['lib1Lang'];
$lib2Lang = $langue['lib2Lang'];

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
            <label for="lib1Lang">Nom</label>
            <input disabled name="lib1Lang" id="lib1Lang" size="80" maxlength="80" value="<?= $lib1Lang; ?>" />
        </div>

        <div class="field">
            <label for="lib2Lang">Nom</label>
            <input disabled name="lib2Lang" id="lib2Lang" size="80" maxlength="80" value="<?= $lib2Lang; ?>" />
        </div>

        <div class="field">
            <label for="numPays">Pays</label>
            <input disabled name="numPays" id="numPays" size="80" maxlength="80" value="<?= $numPays; ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent?>">Annuler</a>
            <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>