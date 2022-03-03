<?php

$submitBtn = "Éditer";
$pageCrud = "membre";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.':'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Membre
require_once __DIR__ . '/../../class_crud/membre.class.php'; 

// Instanciation de la classe Membre
$monMembre = new MEMBRE(); 

//Insertion de la classe Statut
require_once __DIR__ . '/../../class_crud/statut.class.php';

//Instanciation de le classe Statut
$monStatut = new STATUT();

// Gestion des erreurs de saisie
$erreur = false;
$validator = Validator::make();
// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if(isset($_POST['Submit'])){
        $Submit = $_POST['Submit'];
    } else {
        $Submit = "";
    }

    $validator->addRules([
        ValidationRule::required('id'),
        ValidationRule::required('prenomMemb'),
        ValidationRule::required('nomMemb'),
        ValidationRule::required('passMemb')->password(),
        ValidationRule::required('passMemb_confirm')->password()->equalTo('passMemb'),
        ValidationRule::required('eMailMemb')->email()->unique('membre')->customError('shouldBeUnique', 'Cet email est déjà pris'),
        ValidationRule::required('eMailMemb_confirm')->email()->equalTo('eMailMemb'),
        ValidationRule::required('accordMemb')->equalToValue('on')->customError('shouldBeEqualToValue', 'Vous devez accepter les conditions d\'utilisation'),
        ValidationRule::required('oldHashPassMemb'),
        ValidationRule::required('idStat')
    ])->bindValues($_POST);

    if($validator->success()) {
        // Saisies valides
        $erreur = false;

        $numMemb = $validator->verifiedField('id');
        $prenomMemb = $validator->verifiedField('prenomMemb');
        $nomMemb = $validator->verifiedField('nomMemb');
        
        $passMemb = $validator->verifiedField('passMemb');
        if($passMemb == NULL OR $passMemb==""){
            $passMemb = $validator->verifiedField('oldHashPassMemb');
        } else {
            // hashage du mot de passe
            $passMemb = password_hash($passMemb, PASSWORD_BCRYPT);
        }


        $eMailMemb = $validator->verifiedField('eMailMemb');

        $idStat = $validator->verifiedField('idStat');
        $monMembre->update($numMemb, $prenomMemb, $nomMemb, $passMemb, $eMailMemb, $idStat);


        header("Location: $pagePrecedent");
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies
}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")


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

<?php
    // Modif : récup id à modifier
    // id passé en GET

    if(!isset($_GET['id'])) {
        header("Location: ./membre.php");
        die();
    }
    $membre = $monMembre->get_1Membre($_GET['id']);
    $prenomMemb = $membre['prenomMemb'];
    $nomMemb = $membre['nomMemb'];
    $pseudoMemb = $membre['pseudoMemb'];
    $passMemb = $membre['passMemb'];
    $eMailMemb = $membre['eMailMemb'];
    $dtCreaMemb = $membre['dtCreaMemb'];
    $accordMemb = $membre['accordMemb'];
    $idStat = $membre['idStat'];

?>
<?=$validator->echoErrors()?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="id" name="id" value="<?=$_GET['id'] ?>" />
        <input type="hidden" id="oldHashPassMemb" name="oldHashPassMemb" value="<?=$passMemb ?>" />

        <div class="field">
            <label for="prenomMemb">Prénom</label>
            <input name="prenomMemb" id="prenomMemb" size="80" maxlength="80" value="<?= $prenomMemb; ?>" />
        </div>


        <div class="field">
            <label for="nomMemb">Nom</label>
            <input name="nomMemb" id="nomMemb" size="80" maxlength="80" value="<?= $nomMemb; ?>" />
        </div>



        <div class="field">
            <label for="pseudoMemb">Pseudo</label>
            <input name="pseudoMemb" id="pseudoMemb" size="80" maxlength="80" value="<?= $pseudoMemb; ?>" disabled/>
        </div>

        <div class="field">
            <label class="control-label" for="passMemb">Mot passe</label>
            <input type="password" name="passMemb" id="passMemb" size="80" maxlength="80" value="<?= $passMemb; ?>" autocomplete="on" />
            <label><input type="checkbox" onclick="myFunction('passMemb')"><i>Afficher mot de passe</i></label>
        </div>

        <div class="field">
            <label class="control-label" for="passMemb_confirm">Confirmez le mot passe</label>
            <input type="password" name="passMemb_confirm" id="passMemb_confirm" size="80" maxlength="80" value="<?= $passMemb; ?>" autocomplete="on" />
            <label><input type="checkbox" onclick="myFunction('passMemb_confirm')"><i>Afficher mot de passe</i></label>
        </div>
        
        <div class="field">
            <label for="eMailMemb">Email</label>
            <input name="eMailMemb" id="eMailMemb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" />
        </div>

        <div class="field">
            <label class="control-label" for="eMailMemb_confirm">Confirmez l'eMail</label>
            <input type="email" name="eMailMemb_confirm" id="eMailMemb_confirm" size="80" maxlength="80" value="<?= $eMailMemb; ?>" autocomplete="on" />
        </div>

        <div class="field">
            <label for="dtCreaMemb">Date de création</label>
            <input name="dtCreaMemb" id="dtCreaMemb" size="80" maxlength="80" value="<?= $dtCreaMemb; ?>" />
        </div>

        <div class="field">
            <label for="accordMemb">Accord du membre au RGPD</label>
            <input name="accordMemb" id="accordMemb" size="80" maxlength="80" value="<?= $accordMemb; ?>" />
        </div>

        <div class="field">
            <label for="idStat">Quel statut :</label>
            <select name="idStat" id="idStat">
            <?php 
                $allStatuts = $monStatut->get_AllStatutsExceptSuperAdmin();                    
                foreach($allStatuts as $statut) { 
            ?>
                <option <?=$statut['idStat']==$idStat?'selected':'' ?> value="<?= $statut['idStat'] ?>" ><?=$statut['libStat'] ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser"  href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
