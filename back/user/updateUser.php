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
$monUser = new user(); 

//Insertion de la classe Statut
require_once __DIR__ . '/../../class_crud/statut.class.php';

//Instanciation de le classe Statut
$monStatut = new statut();

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
        ValidationRule::required('nomUser'),
        ValidationRule::required('prenomUser'),
        ValidationRule::required('pseudoUser')->pseudo()->unique('user', 'pseudoUser', true)->customError('shouldBeUnique', 'Ce pseudo est déjà pris'),
        ValidationRule::optionnal('passUser')->password(),
        ValidationRule::optionnal('passUser_confirm')->password()->equalTo('passUser'),
        ValidationRule::required('eMailUser')->email()->unique('user', 'eMailUser', true)->customError('shouldBeUnique', 'Cet email est déjà pris'),
        ValidationRule::required('eMailUser_confirm')->email()->equalTo('eMailUser'),
        ValidationRule::required('oldHashPassUser'),
        ValidationRule::required('idStat')
    ])->bindValues($_POST);

    if($validator->success()) {
        // Saisies valides
        $erreur = false;

        $pseudoUser = $validator->verifiedField('pseudoUser');
        $nomUser = $validator->verifiedField('nomUser');
        $prenomUser = $validator->verifiedField('prenomUser');
        
        $passUser = '';
        if($validator->isFilled('passUser')){
            // hashage du mot de passe
            $passUser = password_hash($passUser, PASSWORD_BCRYPT);
        } else {
            $passUser = $validator->verifiedField('oldHashPassUser');
        }
        
        
        $eMailUser = $validator->verifiedField('eMailUser');
        
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

<script src="<?= webAssetPath('js/password.js') ?>"></script>

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
        <input type="hidden" id="oldHashPassUser" name="oldHashPassUser" value="<?=$passUser ?>" />

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
            <label class="control-label" for="passUser">Mot passe</label>
            <input type="password" name="passUser" id="passUser" size="80" maxlength="80" value="" autocomplete="on" />
            <label><input type="checkbox" onclick="togglePassword('passUser')"><i>Afficher mot de passe</i></label>
        </div>

        <div class="field">
            <label class="control-label" for="passUser_confirm">Confirmez le mot passe</label>
            <input type="password" name="passUser_confirm" id="passUser_confirm" size="80" maxlength="80" value="" autocomplete="on" />
            <label><input type="checkbox" onclick="togglePassword('passUser_confirm')"><i>Afficher mot de passe</i></label>
        </div>
        
        <div class="field">
            <label for="eMailUser">Email</label>
            <input name="eMailUser" id="eMailUser" size="80" maxlength="80" value="<?= $eMailUser; ?>" />
        </div>

        <div class="field">
            <label class="control-label" for="eMailUser_confirm">Confirmez l'eMail</label>
            <input type="email" name="eMailUser_confirm" id="eMailUser_confirm" size="80" maxlength="80" value="<?= $eMailUser; ?>" autocomplete="on" />
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
            <a class="btn btn-lg btn-text" title="Réinitialiser"  href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?pseudoUser=<?=$_GET['pseudoUser'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
