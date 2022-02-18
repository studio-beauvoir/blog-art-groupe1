<?php
require_once __DIR__ . '/util/index.php';

require_once __DIR__ . './CLASS_CRUD/membre.class.php';
$monMembre = new MEMBRE();

$validator = Validator::make();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('nomMemb'),
        ValidationRule::required('prenomMemb'),
        ValidationRule::required('pseudoMemb')->pseudo(),
        ValidationRule::required('passMemb')->password(),
        ValidationRule::required('eMailMemb')->email(),
        ValidationRule::required('accordMemb'),
    ])->bindValues($_POST);

    if($validator->success()) {
        $nomMemb = $validator->verifiedField('nomMemb');
        $prenomMemb = $validator->verifiedField('prenomMemb');
        $pseudoMemb = $validator->verifiedField('pseudoMemb');
        $passMemb = $validator->verifiedField('passMemb');
        $eMailMemb = $validator->verifiedField('eMailMemb');

        date_default_timezone_set("Europe/Paris");
        $dtCreaMemb = date("Y-m-d H:i:s");
        $idStat = 1;

        $accordMemb = $validator->verifiedField('accordMemb')=="on";
        
        $monMembre->register($nomMemb, $prenomMemb, $pseudoMemb, $passMemb, $eMailMemb, $accordMemb);

        header("Location: ./thematique.php");
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
        <input name="nomMemb" id="nomMemb" placeholder="" size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="prenomMemb">Prénom</label>
        <input name="prenomMemb" id="prenomMemb" placeholder="" size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="pseudoMemb">Pseudo</label>
        <input name="pseudoMemb" id="pseudoMemb" placeholder="Entre 6 et 70 caractères" size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="eMailMemb">Email</label>
        <input name="eMailMemb" id="eMailMemb" placeholder="" size="100" maxlength="100" />
    </div>


    <div class="field">
        <label for="passMemb">Mot passe<span class="error">(*)</span></label>
        <input type="password" name="passMemb" id="passMemb" size="80" maxlength="80" />
        <br>
        <input type="checkbox" onclick="myFunction('passMemb')">
        
        <label><i>Afficher Mot de passe</i></label>
    </div>

    <div class="field">
        <label for="accordMemb"><b>J'accepte que mes données soient conservées :</b></label>
        <div class="controls">
        <fieldset>
            <input type="radio" name="accordMemb" value="on" />Oui
            <input type="radio" name="accordMemb"value="off" checked="checked" />Non
        </fieldset>
        </div>
    </div>

    <i><div class="error"><br>*Champs obligatoires</div></i>

</form>
    
<div class="controls">
    <input class="btn btn-lg" title="Inscription" type="submit" value="Inscription" />
</div>





<?php require_once __DIR__ . '/layouts/front/foot.php';?>

