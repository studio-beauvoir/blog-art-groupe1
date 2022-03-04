<?php

$submitBtn = "Connexion";
$pageTitle = "$submitBtn";
require_once __DIR__ . '/../util/index.php';
require_once __DIR__ . '/../class_crud/user.class.php'; 


require_once __DIR__ . '/../middleware/getUser.php';
if($loggedUser) {
    header('location: '.webSitePath('/admin.php'));
}

$monUser = new user();

$validator = Validator::make();
$loginState = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $validator->addRules([
        ValidationRule::required('pseudoUser')->customError('isRequired', 'Le pseudo est requis'),
        ValidationRule::required('passUser')->customError('isRequired', 'Le mot de passe est requis')->password()
    ])->bindValues($_POST);

    if($validator->success()) {
        $pseudoUser = $validator->verifiedField('pseudoUser');

        // on conserve les caractères spéciaux (d'ou le false)
        $passUser = $validator->verifiedField('passUser', false);

        $loginAttempt = $monUser->login($pseudoUser, $passUser);
        if($loginAttempt["error"]) {
            $loginState = '<div class="errors"><div class="error">'.$loginAttempt['message'].'</div></div>';
        }
    }
}

require_once __DIR__ . '/../layouts/front/head.php';
?>

<script src="<?= webAssetPath('js/password.js') ?>"></script>

<div class="container container-auth">
    <h2>Se connecter</h2>
    <h3>Accès admin</h3>

    <?=$validator->echoErrors() ?>
    <?=$loginState?>
    <form 
        class="user-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <div class="field">
            <label>Pseudo</label>
            <input value="<?=$validator->oldField('pseudoUser')?>" type="text" name="pseudoUser">
        </div>
        
        <div class="field">
            <label> Mot de passe </label>
            <input value="<?=$validator->oldField('passUser')?>" type="password" name="passUser" id="passUser">
            <label><input type="checkbox" onclick="togglePassword('passUser')"><i>Afficher le mot de passe</i></label>
        </div>

        <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        <p>Pas de compte? <a href="<?= webSitePath('/admin/inscription.php') ?>">Inscrivez-vous</a></p>
    </form>
</div>
<?php if(!IN_PROD):?>
    <script src="<?= webAssetPath('js/autofill-form-admin.js') ?>"></script>
<?php endif?>
<?php require_once __DIR__ . '/../layouts/front/foot.php';?>