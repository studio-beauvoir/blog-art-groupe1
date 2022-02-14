<?php
////////////////////////////////////////////////////////////
//
//  CRUD STATUT (PDO) - Modifié : 4 Juillet 2021
//
//  Script  : createStatut.php  -  (ETUD)  BLOGART22
//
////////////////////////////////////////////////////////////

// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../CLASS_CRUD/statut.class.php'; 


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

        $libStat = ctrlSaisies($_POST['libStat']);

        $monStatut->create($libStat);

        header("Location: ./statut.php");
    }   // Fin if ((isset($_POST['libStat'])) ...
    else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies
    // controle des saisies du formulaire

    // insertion effective du statut

    // Gestion des erreurs => msg si saisies ko

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initStatut.php';

$pageTitle = "Admin - CRUD Statut";
include __DIR__ . '/../../layouts/back/head.php';
?>

    <h1>BLOGART22 Admin - CRUD Statut</h1>
    <h2>Ajout d'un statut</h2>

    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" accept-charset="UTF-8">

      <fieldset>
        <legend class="legend1">Formulaire Statut...</legend>

        <input type="hidden" id="id" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>" />

        <div class="control-group">
            <label class="control-label" for="libStat"><b>Nom :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="text" name="libStat" id="libStat" size="80" maxlength="80" value="<?= $libStat; ?>" autofocus="autofocus" />
        </div>

        <div class="control-group">
            <div class="error">
<?php
            if ($erreur) {
                echo ($errSaisies);
            } else {
                $errSaisies = "";
                echo ($errSaisies);
            }
?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;">Réinitialiser</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Valider" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;"/>
                <br>
            </div>
        </div>
      </fieldset>
    </form>
<?php
require_once __DIR__ . '/footerStatut.php';

require_once __DIR__ . '/footer.php';
?>
</body>
</html>
