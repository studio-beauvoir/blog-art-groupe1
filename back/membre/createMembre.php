<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Membre
require_once __DIR__ . '/../../CLASS_CRUD/membre.class.php'; 


// Instanciation de la classe Membre
$monMembre = new MEMBRE(); 

// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = Validator::make([
        ValidationRule::required('prenomMemb'),
        ValidationRule::required('nomMemb'),
        ValidationRule::required('pseudoMemb')->pseudo,
        ValidationRule::required('passMemb'),
        ValidationRule::required('eMailMemb')->email,
        ValidationRule::required('dtCreaMemb'),
        ValidationRule::required('accordMemb'),
        ValidationRule::required('idStat')->password,
    ])->bindValues($_POST);

    if($validator->success()) {

        // Saisies valides
        $erreur = false;

        $prenomMemb = $validator->verifiedField('prenomMemb');
        $nomMemb = $validator->verifiedField('nomMemb');
        $pseudoMemb = $validator->verifiedField('pseudoMemb');
        $passMemb = $validator->verifiedField('passMemb');
        $eMailMemb = $validator->verifiedField('eMailMemb');
        $dtCreaMemb = $validator->verifiedField('dtCreaMemb');
        $accordMemb = $validator->verifiedField('accordMemb');
        $idStat = $validator->verifiedField('idStat');
        
        $monMembre->create($prenomMemb, $nomMemb, $pseudoMemb, $passMemb, $eMailMemb, $dtCreaMemb, $accordMemb, $idStat);

        header("Location: ./membre.php");
        die();
    }   // Fin if ((isset($_POST['libStat'])) ...
    else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initMembre.php';

$submitBtn = "Créer";
$pagePrecedent = "./membre.php";
$pageTitle = "Créer un membre";
$pageNav = ['Home:/index1.php', 'Gestion des membres:'.$pagePrecedent, $pageTitle];
$pageTitle = "Créer un Angle";
$pageNav = ['Home:/index1.php', 'Gestion du Angle:./angle.php', $pageTitle];
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
            <label for="libAngl">Libellé</label>
            <input name="libAngl" id="libAngl" size="80" maxlength="80" value="<?= $libAngl; ?>" />
        </div>

        <div class="field">
            <label for="numLang">Quelle langue :</label>
            <select name="numLang" id="numLang">
            <?php 
                $allLangues = $maLangue->get_AllLangues();                    
                foreach($allLangues as $langue) { 
            ?>
                <option value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" href="./statut.php">Annuler</a>
            <input class="btn btn-lg" type="submit" value="Valider" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
