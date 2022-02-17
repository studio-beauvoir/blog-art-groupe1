<?php

$submitBtn = "Créer";
$pageCrud = "membre";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des membres:'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../CLASS_CRUD/membre.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/statut.class.php'; 

// Instanciation de la classe Membre
$monMembre = new MEMBRE(); 
$monStatut = new STATUT();

// Gestion des erreurs de saisie
$erreur = false;
$validator = Validator::make();

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('prenomMemb'),
        ValidationRule::required('nomMemb'),
        ValidationRule::required('pseudoMemb')->pseudo(),
        ValidationRule::required('passMemb')->password(),
        ValidationRule::required('eMailMemb')->email(),
        // ValidationRule::required('dtCreaMemb'),
        ValidationRule::required('accordMemb'),
        ValidationRule::required('idStat')
    ])->bindValues($_POST);

    if($validator->success()) {

        // Saisies valides
        $erreur = false;

        $prenomMemb = $validator->verifiedField('prenomMemb');
        $nomMemb = $validator->verifiedField('nomMemb');
        $pseudoMemb = $validator->verifiedField('pseudoMemb');
        $passMemb = $validator->verifiedField('passMemb');
        $eMailMemb = $validator->verifiedField('eMailMemb');

        date_default_timezone_set("Europe/Paris");
        $dtCreaMemb = date("Y-m-d H:i:s"); 

        $accordMemb = $validator->verifiedField('accordMemb')=="on";
        $idStat = $validator->verifiedField('idStat');
        
        var_dump($dtCreaMemb);
        $monMembre->create($prenomMemb, $nomMemb, $pseudoMemb, $passMemb, $eMailMemb, $dtCreaMemb, $accordMemb, $idStat);

        header("Location: ./membre.php");
        die();
    }   // Fin if ((isset($_POST['libStat'])) ...
    else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
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

<?=$validator->echoErrors()?>
    <form
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="prenomMemb">Prénom<span class="error">(*)</span> :</label>
            <input name="prenomMemb" id="prenomMemb" size="80" maxlength="80" value="<?= $prenomMemb;?>" />
        </div>

        <div class="field">
            <label for="nomMemb">Nom<span class="error">(*)</span> :</label>
            <input name="nomMemb" id="nomMemb" size="80" maxlength="80" value="<?= $nomMemb?>" />
        </div>

        <div class="field">
            <label for="pseudoMemb">Pseudonyme<span class="error">(*)</span> :</label>
            <input name="pseudoMemb" id="pseudoMemb" size="80" maxlength="70" value="<?= $pseudoMemb; ?>" />
        </div>

        <div class="field">
            <label for="passMemb">Mot passe<span class="error">(*)</span></label>
            <input type="password" name="passMemb" id="passMemb" size="80" maxlength="80" />
            <br>
            <input type="checkbox" onclick="myFunction('passMemb')">
            &nbsp;&nbsp;
            <label><i>Afficher Mot de passe</i></label>
        </div>

        <br>
        <div class="field">
            <label for="pass2Memb">Confirmez le mot de passe<span class="error">(*)</span></label>
            <input type="password" name="pass2Memb" id="pass2Memb" size="80" maxlength="80"/>
            <br>
            <input type="checkbox" onclick="myFunction('pass2Memb')">
            &nbsp;&nbsp;
            <label><i>Afficher Mot de passe</i></label>
        </div>

        </div><div class="field">
            <label for="eMailMemb">eMail<span class="error">(*)</span></label>
            <input name="eMailMemb" id="eMailMemb" size="80" maxlength="80"/>
        </div>

        <div class="field">
            <label for="eMail1Memb">Confirmez l'eMail<span class="error">(*)</span></label>
            <input name="eMail1Memb" id="eMail1Memb" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="accordMemb"><b>J'accepte que mes données soient conservées :</b></label>
            <div class="controls">
               <fieldset>
                  <input type="radio" name="accordMemb"
                  <?= ($accordMemb == "on") ? 'checked="checked"' : ''
                  ?> value="on" />&nbsp;&nbsp;Oui&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="accordMemb"
                  <?= ($accordMemb == "off") ? 'checked="checked"' : ''
                  ?> value="off" checked="checked" />&nbsp;&nbsp;Non
               </fieldset>
            </div>
        </div>

        <i><div class="error"><br>*&nbsp;Champs obligatoires</div></i>

        <div class="field">
            <label for="idStat">Statut :</label>
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
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
