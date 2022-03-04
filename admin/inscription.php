<?php
require_once __DIR__ . '/../util/index.php';

require_once __DIR__ . '/../class_crud/user.class.php';
$monUser = new user();

$validator = Validator::make();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('prenomUser'),
        ValidationRule::required('nomUser'),
        ValidationRule::required('pseudoUser')->pseudo()->unique('user')->customError('shouldBeUnique', 'Ce pseudo est déjà pris'),
        ValidationRule::required('passUser')->password(),
        ValidationRule::required('passUser_confirm')->password()->equalTo('passUser'),
        ValidationRule::required('eMailUser')->email()->unique('user')->customError('shouldBeUnique', 'Cet email est déjà pris'),
        ValidationRule::required('eMailUser_confirm')->email()->equalTo('eMailUser'),
    ])->bindValues($_POST);

    if($validator->success()) {
        $prenomUser = $validator->verifiedField('prenomUser');
        $nomUser = $validator->verifiedField('nomUser');
        $pseudoUser = $validator->verifiedField('pseudoUser');

        $passUser = $validator->verifiedField('passUser', false);
        // hashage du mot de passe
        $passUserHash = password_hash($passUser, PASSWORD_BCRYPT);

        $eMailUser = $validator->verifiedField('eMailUser');

        date_default_timezone_set("Europe/Paris");
        $dtCreaUser = date("Y-m-d H:i:s");
        
		
        $idStat = 3; // User niveau 1

        
        $monUser->create($pseudoUser, $nomUser, $prenomUser,  $eMailUser, $passUserHash, $idStat);
        
        $monUser->login($pseudoUser, $passUser);
        die();
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

} 

$pageTitle = "Accès admin - inscription";
require_once __DIR__ . '/../layouts/front/head.php';
?>

<script src="<?= webAssetPath('js/password.js') ?>"></script>

<div class="container container-auth">
    <h2>Créer un compte</h2>
    <h3>Accès admin</h3>
    <?=$validator->echoErrors()?>
    <form
        class="user-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="nomUser">Nom</label>
            <input value="<?=$validator->oldField('nomUser')?>" name="nomUser" id="nomUser" placeholder="" size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="prenomUser">Prénom</label>
            <input value="<?=$validator->oldField('prenomUser')?>" name="prenomUser" id="prenomUser" placeholder="" size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="prenomUser">Pseudo</label>
            <input value="<?=$validator->oldField('pseudoUser')?>" name="pseudoUser" id="pseudoUser" placeholder="" size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="eMailUser">Email</label>
            <input value="<?=$validator->oldField('eMailUser')?>" name="eMailUser" id="eMailUser" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="eMailUser_confirm">Confirmez l'eMail</label>
            <input value="<?=$validator->oldField('eMailUser_confirm')?>" name="eMailUser_confirm" id="eMailUser_confirm" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label>Mot de passe</label>
            <input value="<?=$validator->oldField('passUser')?>" type="password" name="passUser" id="passUser">
            <label><input type="checkbox" onclick="togglePassword('passUser')"><i>Afficher le mot de passe</i></label>
            <p>
                Le mot de passe doit comporter entre 6 et 15 caractères, 
                <br/>et au moins une lettre, un chiffre et un caractère spécial parmi &@#$%_-.?!
            </p>
        </div>

        <div class="field">
            <label>Confirmer le mot de passe</label>
            <input value="<?=$validator->oldField('passUser_confirm')?>" type="password" name="passUser_confirm" id="passUser_confirm">
            <label><input type="checkbox" onclick="togglePassword('passUser_confirm')"><i>Afficher le mot de passe</i></label>
        </div>

        

        <input class="btn btn-lg" title="Inscription" type="submit" value="Inscription" />
        <p>Déjà inscrit? <a href="<?= webSitePath('/admin/connexion.php') ?>">Connectez-vous</a></p>

    </form>
</div>

<?php if(!IN_PROD):?>
    <script src="<?= webAssetPath('js/autofill-form-admin.js') ?>"></script>
<?php endif?>

<?php require_once __DIR__ . '/../layouts/front/foot.php';?>

