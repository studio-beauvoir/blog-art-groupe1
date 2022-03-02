<?php

$submitBtn = "Éditer";
$pageCrud = "user";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.':'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe User
require_once __DIR__ . '/../../class_crud/user.class.php'; 

// Instanciation de la classe User
$monUser = new USER(); 

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
        ValidationRule::required('pseudoUser'),
        ValidationRule::required('nomUser'),
        ValidationRule::required('prenomUser'),
        ValidationRule::required('eMail1User')->email(),
        ValidationRule::required('eMail2User')->email()->equalTo('eMail1User'),
        ValidationRule::required('pass1User'),
        ValidationRule::required('pass2User')->equalTo('pass1User'),
        ValidationRule::required('idStat')
    ])->bindValues($_POST);

    if($validator->success()) {
        // Saisies valides
        $erreur = false;

        $pseudoUser = $validator->verifiedField('pseudoUser');
        $nomUser = $validator->verifiedField('nomUser');
        $prenomUser = $validator->verifiedField('prenomUser');
        
        $passUser = $validator->verifiedField('pass2User');
        // hashage du mot de passe
        $passUser = password_hash($passUser, PASSWORD_BCRYPT);


        $eMailUser = $validator->verifiedField('eMail2User');

        $idStat = $validator->verifiedField('idStat');
        $monUser->update($pseudoUser, $nomUser, $prenomUser, $eMailUser, $passUser, $idStat);


        header("Location: $pagePrecedent");
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies
}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")


// Init variables form
include __DIR__ . '/initUser.php';


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

    if(!isset($_GET['pseudoUser'])) {
        header("Location: ./user.php");
        die();
    }
    $user = $monUser->get_1User(ctrlSaisies($_GET['pseudoUser']));
    $pseudoUser = $user['pseudoUser'];
    $nomUser = $user['nomUser'];
    $prenomUser = $user['prenomUser'];
    $eMailUser = $user['eMailUser'];
    $passUser = $user['passUser'];
    $idStat = $user['idStat'];

?>
<?=$validator->echoErrors()?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?pseudoUser=<?=$_GET['pseudoUser'] ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="pseudoUser" name="pseudoUser" value="<?=$_GET['pseudoUser'] ?>" />

        <div class="field">
            <label for="pseudoUser">Pseudo</label>
            <input name="pseudoUser" id="pseudoUser" size="80" maxlength="80" value="<?= $pseudoUser; ?>" disabled/>
        </div>


        <div class="field">
            <label for="nomUser">Nom</label>
            <input name="nomUser" id="nomUser" size="80" maxlength="80" value="<?= $nomUser; ?>" />
        </div>



        <div class="field">
            <label for="prenomUser">Prénom</label>
            <input name="prenomUser" id="prenomUser" size="80" maxlength="80" value="<?= $prenomUser; ?>" />
        </div>

        <div class="field">
            <label class="control-label" for="pass1User"><b>Mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" name="pass1User" id="myInput1" size="80" maxlength="80" value="<?= $passUser; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput1')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="pass2User"><b>Confirmez le mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" name="pass2User" id="myInput2" size="80" maxlength="80" value="<?= $passUser; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput2')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>
        <small class="error">*Champ obligatoire si nouveau passe</small><br>
        
        <div class="field">
            <label for="eMail1User">Email</label>
            <input name="eMail1User" id="eMail1User" size="80" maxlength="80" value="<?= $eMailUser; ?>" />
        </div>

        <div class="field">
            <label for="eMail2User">Confirmer l'email</label>
            <input name="eMail2User" id="eMail2User" size="80" maxlength="80" value="<?= $eMailUser; ?>" />
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="eMail2User"><b>Confirmez l'eMail<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="email" name="eMail2User" id="eMail2User" size="80" maxlength="80" value="<?= $eMailUser; ?>" autocomplete="on" />
        </div>
        <small class="error">*Champ obligatoire si nouveau eMail</small><br>
             
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
            <a class="btn btn-lg btn-text" title="Réinitialiser"  href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?pseudoUser=<?=$_GET['pseudoUser'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
