<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Angle
require_once __DIR__ . '/../../class_crud/angle.class.php'; 

// Instanciation de la classe Angle
$monAngle = new angle(); 

require_once __DIR__ . '/../../class_crud/langue.class.php';
$maLangue = new langue();
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
        ValidationRule::required('id'),
        ValidationRule::required('libAngl'),
        ValidationRule::required('idLang')
    ])->bindValues($_POST);

    if($validator->success()) {
        // Saisies valides
        $erreur = false;

        $numAngl = $validator->verifiedField('id');
        $libAngl = $validator->verifiedField('libAngl');
        $numLang = $validator->verifiedField('idLang');
        $monAngle->update($numAngl, $libAngl, $numLang);


        header("Location: ./angle.php");
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies
}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")


// Init variables form
include __DIR__ . '/initAngle.php';

$pageTitle = "Modifier un Angle";
$pageNav = ['Home:/admin.php', 'Gestion Angle:./angle.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
<?php
    // Modif : récup id à modifier
    // id passé en GET

    if(!isset($_GET['id'])) {
        header("Location: ./angle.php");
        die();
    }
    $angle = $monAngle->get_1Angle($_GET['id']);
    $libAngl = $angle['libAngl'];
    $idLang = $angle['numLang'];

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
            <label for="libAngl">Libellé</label>
            <input name="libAngl" id="libAngl" size="80" maxlength="80" value="<?= $libAngl; ?>" />
        </div>

        <div class="field">
            <label for="idLang">Quelle langue :</label>
            <select name="idLang" id="idLang">
            <?php 
                $allLangues = $maLangue->get_AllLangues();                    
                foreach($allLangues as $langue) { 
            ?>
                <option <?=$langue['numLang']==$idLang?'selected':'' ?> value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" href="./angle.php">Annuler</a>
            <input class="btn btn-lg" type="submit" value="Valider" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
