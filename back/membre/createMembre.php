<?php

$submitBtn = "Créer";
$pageCrud = "membre";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des membres:'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
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
        ValidationRule::required('pseudoMemb')->pseudo(),
        ValidationRule::required('passMemb'),
        ValidationRule::required('eMailMemb')->email(),
        ValidationRule::required('dtCreaMemb'),
        ValidationRule::required('accordMemb'),
        ValidationRule::required('idStat')->password(),
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

include __DIR__ . '/../../layouts/back/head.php';
?>

<script>
        // Affichage pass
        function myFunction(myInputPass) {
            var x = document.getElementById(myInputPass);
            if (x.type === "password") {
              x.type = "text";
            } else {
              x.type = "password";
            }
        }
</script>

    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="prenomMemb">Prénom</label>
            <input name="prenomMemb" id="prenomMemb" size="80" maxlength="80" value="<?= $prenomMemb; ?>" />
        </div>

        <div class="field">
            <label for="nomMemb">Nom</label>
            <input name="nomMemb" id="nomMemb" size="80" maxlength="80" value="<?= $nomMemb; ?>" />
        </div>

        <div class="field">
            <label for="pseudoMemb">Pseudonyme</label>
            <input name="pseudoMemb" id="pseudoMemb" size="80" maxlength="70" value="<?= $pseudoMemb; ?>" />
        </div>

        <div class="field">
            <label for="pass1Memb">Mot passe</label>
            <input type="password" name="pass1Memb" id="myInput1" size="80" maxlength="80" value="<?= $passMemb; ?>" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput1')">
            <label><i>Afficher Mot de passe</i></label>
        </div>

        <div class="field">
            <label for="pass2Memb">Confirmez le mot de passe<span class="error">(*)</span></label>
            <input type="password" name="pass2Memb" id="myInput2" size="80" maxlength="80" value="<?= $passMemb; ?>" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput2')">
            <label><i>Afficher Mot de passe</i></label>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
