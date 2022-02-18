<?php

$submitBtn = "Créer";
$pageCrud = "angle";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des angles:'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../CLASS_CRUD/angle.class.php'; 


// Instanciation de la classe Statut
$monAngle = new ANGLE(); 

require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php';
$maLangue = new LANGUE();

// Gestion des erreurs de saisie
$erreur = false;

$validator = Validator::make();
// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('libAngl'),
        ValidationRule::required('numLang'),
    ])->bindValues($_POST);

    if($validator->success()) {

        // Saisies valides
        $erreur = false;

        $libAngl = $validator->verifiedField('libAngl');
        $numLang = $validator->verifiedField('numLang');
        $numAngl = $monAngle->getNextNumAngl($libAngl);
        
        $monAngle->create($numAngl, $libAngl, $numLang);

        header("Location: ./angle.php");
        die();
    }   // Fin if ((isset($_POST['libStat'])) ...
    else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initAngle.php';


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
            <label for="libAngl">Libellé</label>
            <input name="libAngl" id="libAngl" size="80" maxlength="80" value="<?= $validator->oldField('libAngl') ?>" />
        </div>

        <div class="field">
            <label for="numLang">Quelle langue :</label>
            <select name="numLang" id="numLang">
            <?php 
                $allLangues = $maLangue->get_AllLangues();                    
                foreach($allLangues as $langue) { 
            ?>
                <option <?=$langue['numLang']==$validator->oldField('numLang')?'selected':'' ?> value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
