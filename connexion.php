<?php

$submitBtn = "Connexion";
$pageTitle = "$submitBtn";
require_once __DIR__ . '/util/index.php';
require_once __DIR__ . '/CLASS_CRUD/membre.class.php'; 

$monMembre = new MEMBRE();

$validator = Validator::make();
$loginState = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $validator->addRules([
        ValidationRule::required('pseudoMemb')->customError('isRequired', 'Le pseudo est requis'),
        ValidationRule::required('passMemb')->customError('isRequired', 'Le mot de passe est requis')->password()
    ])->bindValues($_POST);

    if($validator->success()) {
        $pseudoMemb = $validator->verifiedField('pseudoMemb');
        $passMemb = $validator->verifiedField('passMemb');

        $success = $monMembre->login($pseudoMemb, $passMemb);
        if(!$success) {
            $loginState = '<div class="errors"><div class="error">Le login ou le mot de passe est incorrect</div></div>';
        }
    }
}

require_once __DIR__ . '/layouts/front/head.php';
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
            <label><input type="checkbox" onclick="myFunction('passMemb')"><i>Afficher le mot de passe</i></label>
            <p>
                Le mot de passe doit comporter entre 6 et 15 caractères, 
                <br/>et au moins une lettre, un chiffre et un caractère spécial parmi &@#$%_-.?!
            </p>
        </div>

        <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
    </form>
</div>
<?php require_once __DIR__ . '/layouts/front/foot.php';?>