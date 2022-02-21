<?php
require_once __DIR__ . '/util/index.php';

require_once __DIR__ . './CLASS_CRUD/membre.class.php';
$monMembre = new MEMBRE();

$validator = Validator::make();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('prenomMemb'),
        ValidationRule::required('nomMemb'),
        ValidationRule::required('pseudoMemb')->pseudo()->unique('membre')->customError('shouldBeUnique', 'Ce pseudo est déjà pris'),
        ValidationRule::required('passMemb')->password(),
        ValidationRule::required('passMemb_confirm')->password()->equalTo('passMemb'),
        ValidationRule::required('eMailMemb')->email()->unique('membre')->customError('shouldBeUnique', 'Cet email est déjà pris'),
        ValidationRule::required('eMailMemb_confirm')->email()->equalTo('eMailMemb'),
        ValidationRule::required('accordMemb')->equalToValue('on')->customError('shouldBeEqualToValue', 'Vous devez accepter les conditions d\'utilisation'),
    ])->bindValues($_POST);

    if($validator->success()) {
        $prenomMemb = $validator->verifiedField('prenomMemb');
        $nomMemb = $validator->verifiedField('nomMemb');
        $pseudoMemb = $validator->verifiedField('pseudoMemb');
        $passMemb = $validator->verifiedField('passMemb');
        $eMailMemb = $validator->verifiedField('eMailMemb');

        date_default_timezone_set("Europe/Paris");
        $dtCreaMemb = date("Y-m-d H:i:s");
        
        $accordMemb = $validator->verifiedField('accordMemb')=="on";
		
        $idStat = 3; // Membre niveau 1

        
        $monMembre->create($prenomMemb, $nomMemb, $pseudoMemb, $passMemb, $eMailMemb, $dtCreaMemb, $accordMemb, $idStat);
        
        $monMembre->login($pseudoMemb, $passMemb);
        die();
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

} 

$pageTitle = "Panel user";
$pageNav = ['Inscription'];
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
    <h1>S'inscrire</h1>
    <?=$validator->echoErrors()?>
    <form
        class="user-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="nomMemb">Nom</label>
            <input value="<?=$validator->oldField('nomMemb')?>" name="nomMemb" id="nomMemb" placeholder="" size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="prenomMemb">Prénom</label>
            <input value="<?=$validator->oldField('prenomMemb')?>" name="prenomMemb" id="prenomMemb" placeholder="" size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="prenomMemb">Pseudo</label>
            <input value="<?=$validator->oldField('pseudoMemb')?>" name="pseudoMemb" id="pseudoMemb" placeholder="" size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="eMailMemb">Email</label>
            <input value="<?=$validator->oldField('eMailMemb')?>" name="eMailMemb" id="eMailMemb" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="eMailMemb_confirm">Confirmez l'eMail</label>
            <input value="<?=$validator->oldField('eMailMemb_confirm')?>" name="eMailMemb_confirm" id="eMailMemb_confirm" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label>Mot de passe</label>
            <input value="<?=$validator->oldField('passMemb')?>" type="password" name="passMemb" id="passMemb">
            <label><input type="checkbox" onclick="myFunction('passMemb')"><i>Afficher le mot de passe</i></label>
            <p>
                Le mot de passe doit comporter entre 6 et 15 caractères, 
                <br/>et au moins une lettre, un chiffre et un caractère spécial parmi &@#$%_-.?!
            </p>
        </div>

        <div class="field">
            <label>Confirmer le mot de passe</label>
            <input value="<?=$validator->oldField('passMemb_confirm')?>" type="password" name="passMemb_confirm" id="passMemb_confirm">
            <label><input type="checkbox" onclick="myFunction('passMemb_confirm')"><i>Afficher le mot de passe</i></label>
        </div>

        <div class="field">
            <label for="accordMemb">J'accepte les <a href="<?= webSitePath('/cgu.php')?>">conditions générales d'utilisation</a></label>
            <div class="controls">
                <label class="font-h4"><input type="radio" name="accordMemb" value="on" /> Oui</label>
                <label class="font-h4"><input type="radio" name="accordMemb" value="off" checked="checked" /> Non</label>
            </div>
        </div>

        <input class="btn btn-lg" title="Inscription" type="submit" value="Inscription" />
    </form>
</div>

<script>
    document.querySelectorAll(`textarea`).forEach(el=>el.value="lorem_ipsum_textarea");
    document.querySelectorAll(`input:not([type="file"], [type="submit"], [type="hidden"], [type="password"], [type="radio"])`).forEach(el=>el.value="lorem_ipsum_input");
    document.querySelectorAll(`input[type="datetime-local"]`).forEach(el=>el.value='2022-02-19T22:21');
    document.querySelectorAll(`input[type="password"]`).forEach(el=>el.value='qdqsd43&ds');
    document.querySelectorAll(`input[name^="eMailMemb"]`).forEach(el=>el.value='qsdqd@gmail.com');
</script>
<?php require_once __DIR__ . '/layouts/front/foot.php';?>

