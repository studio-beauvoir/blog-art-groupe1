<?php

$submitBtn = "Connexion";
$pageTitle = "$submitBtn";
require_once __DIR__ . '/util/index.php';
require_once __DIR__ . '/class_crud/membre.class.php'; 


require_once __DIR__ . '/middleware/getMember.php';
if($loggedMember) {
    header('location: '.webSitePath('/profil.php'));
}

$monMembre = new membre();

$validator = Validator::make();
$loginState = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $validator->addRules([
        ValidationRule::required('pseudoMemb')->customError('isRequired', 'Le pseudo est requis'),
        ValidationRule::required('passMemb')->customError('isRequired', 'Le mot de passe est requis')->password()
    ])->bindValues($_POST);

    if($validator->success()) {
        $pseudoMemb = $validator->verifiedField('pseudoMemb');

        // on conserve les caractères spéciaux (d'ou le false)
        $passMemb = $validator->verifiedField('passMemb', false);

        $loginAttempt = $monMembre->login($pseudoMemb, $passMemb);
        if($loginAttempt["error"]) {
            $loginState = '<div class="errors"><div class="error">'.$loginAttempt['message'].'</div></div>';
        }
    }
}

require_once __DIR__ . '/layouts/front/head.php';
?>

<script src="<?= webAssetPath('js/password.js') ?>"></script>

<div class="container container-spaced">
    <h1>Se connecter</h1>

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
            <input value="<?=$validator->oldField('pseudoMemb')?>" type="text" name="pseudoMemb">
        </div>
        
        <div class="field">
            <label> Mot de passe </label>
            <input value="<?=$validator->oldField('passMemb')?>" type="password" name="passMemb" id="passMemb">
            <label><input type="checkbox" onclick="togglePassword('passMemb')"><i>Afficher le mot de passe</i></label>
        </div>

        <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        <p>Pas de compte? <a href="<?= webSitePath('/inscription.php') ?>">Inscrivez-vous</a></p>
    </form>
</div>
<script src="<?= webAssetPath('js/autofill-form.js') ?>"></script>
<?php require_once __DIR__ . '/layouts/front/foot.php';?>