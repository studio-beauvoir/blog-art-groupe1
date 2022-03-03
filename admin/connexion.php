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
<div class="container">
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
            <label><input type="checkbox" onclick="myFunction('passUser')"><i>Afficher le mot de passe</i></label>
            <p>
                Le mot de passe doit comporter entre 6 et 15 caractères, 
                <br/>et au moins une lettre, un chiffre et un caractère spécial parmi &@#$%_-.?!
            </p>
        </div>

        <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        <p>Pas de compte? <a href="<?= webSitePath('/inscription.php') ?>">Inscrivez-vous</a></p>
    </form>
</div>
<script>
    document.querySelectorAll(`input:not([type="file"], [type="submit"], [type="hidden"], [type="password"], [type="radio"])`).forEach(el=>el.value="lorem_ipsum_input");
    document.querySelectorAll(`input[type="password"]`).forEach(el=>el.value='qdqsd43&ds');
</script>
<?php require_once __DIR__ . '/../layouts/front/foot.php';?>