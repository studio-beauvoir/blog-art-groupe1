<?php

$submitBtn = "Éditer";
$pageCrud = "membre";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des '.$pageCrud.':'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Membre
require_once __DIR__ . '/../../CLASS_CRUD/membre.class.php'; 

// Instanciation de la classe Membre
$monMembre = new MEMBRE(); 

//Insertion de la classe Statut
require_once __DIR__ . '/../../CLASS_CRUD/statut.class.php';

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
        ValidationRule::required('pass1Memb'),
        ValidationRule::required('pass2Memb')->equalTo('pass1Memb'),
        ValidationRule::required('eMail1Memb')->email(),
        ValidationRule::required('eMail2Memb')->email()->equalTo('eMail1Memb'),
        ValidationRule::required('idStat')
    ])->bindValues($_POST);

    if($validator->success()) {
        // Saisies valides
        $erreur = false;

        $numMemb = $validator->verifiedField('id');
        $prenomMemb = $validator->verifiedField('prenomMemb');
        $nomMemb = $validator->verifiedField('nomMemb');
        
        $passMemb = $validator->verifiedField('pass2Memb');
        // check que pass1 == pass2

        $eMailMemb = $validator->verifiedField('eMail2Memb');

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
            <label class="control-label" for="pass1Memb"><b>Mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" name="pass1Memb" id="myInput1" size="80" maxlength="80" value="<?= $passMemb; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput1')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="pass2Memb"><b>Confirmez le mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" name="pass2Memb" id="myInput2" size="80" maxlength="80" value="<?= $passMemb; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput2')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>
        <small class="error">*Champ obligatoire si nouveau passe</small><br>
        
<<<<<<< HEAD
        <!--<div class="field">
            <label for="eMailMemb">EMail</label>
            <input name="eMailMemb" id="eMailMemb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" />
        </div> -->

        <div class="field">
            <label class="control-label" for="eMail1Memb"><b>eMail<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="email" name="eMail1Memb" id="eMail1Memb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" autocomplete="on" />
=======
        <div class="field">
            <label for="eMail1Memb">Email</label>
            <input name="eMail1Memb" id="eMail1Memb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" />
        </div>

        <div class="field">
            <label for="eMail2Memb">Confirmer l'email</label>
            <input name="eMail2Memb" id="eMail2Memb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" />
>>>>>>> a31718473a2e37a260eb329000e2e09ba0ac1d2c
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="eMail2Memb"><b>Confirmez l'eMail<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="email" name="eMail2Memb" id="eMail2Memb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" autocomplete="on" />
        </div>
        <small class="error">*Champ obligatoire si nouveau eMail</small><br>


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
                $allStatuts = $monStatut->get_AllStatuts();                    
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
