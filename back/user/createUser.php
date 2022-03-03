<?php

$submitBtn = "Créer";
$pageCrud = "user";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Créer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des users:'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../class_crud/user.class.php'; 
require_once __DIR__ . '/../../class_crud/statut.class.php'; 

// Instanciation de la classe User
$monUser = new USER(); 
$monStatut = new STATUT();

// Gestion des erreurs de saisie
$validator = Validator::make();

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('nomUser'),
        ValidationRule::required('prenomUser'),
        ValidationRule::required('pseudoUser')->pseudo()->unique('user')->customError('shouldBeUnique', 'Ce pseudo est déjà pris'),
        ValidationRule::required('passUser')->password(),
        ValidationRule::required('passUser_confirm')->password()->equalTo('passUser'),
        ValidationRule::required('eMailUser')->email()->unique('user')->customError('shouldBeUnique', 'Cet email est déjà pris'),
        ValidationRule::required('eMailUser_confirm')->email()->equalTo('eMailUser'),
        ValidationRule::required('idStat')
    ])->bindValues($_POST);

    if($validator->success()) {

        $pseudoUser = $validator->verifiedField('pseudoUser');
        $nomUser = $validator->verifiedField('nomUser');
        $prenomUser = $validator->verifiedField('prenomUser');
        $eMailUser = $validator->verifiedField('eMailUser');
        $passUser = $validator->verifiedField('passUser', false);
        // hashage du mot de passe
        $passUser = password_hash($passUser, PASSWORD_BCRYPT);
        $idStat = $validator->verifiedField('idStat');
        
        $monUser->create($pseudoUser, $nomUser, $prenomUser, $eMailUser, $passUser, $idStat);

        header("Location: ./user.php");
        die();
    }   // Fin if ((isset($_POST['libStat'])) ...

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
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

<?=$validator->echoErrors()?>
    <form
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="pseudoUser">Pseudo</label>
            <input name="pseudoUser" id="pseudoUser" size="80" maxlength="80" value="<?= $pseudoUser;?>" />
        </div>

        <div class="field">
            <label for="nomUser">Nom</label>
            <input name="nomUser" id="nomUser" size="80" maxlength="80" value="<?= $nomUser?>" />
        </div>

        <div class="field">
            <label for="prenomUser">Prénom</label>
            <input name="prenomUser" id="prenomUser" size="80" maxlength="80" value="<?= $prenomUser; ?>" />
        </div>

        </div><div class="field">
            <label for="eMailUser">Email</label>
            <input name="eMailUser" id="eMailUser" size="80" maxlength="80"/>
        </div>

        <div class="field">
            <label for="eMailUser_confirm">Confirmez l'email</label>
            <input name="eMailUser_confirm" id="eMailUser_confirm" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="passUser">Mot de passe</label>
            <input type="password" name="passUser" id="passUser" size="80" maxlength="80" />
            <label><input type="checkbox" onclick="myFunction('passUser')"><i>Afficher Mot de passe</i></label>
            <p>
                Le mot de passe doit comporter entre 6 et 15 caractères, et au moins une lettre, un chiffre et un caractère spécial parmi &@#$%_-.?!
            </p>
        </div>

        <div class="field">
            <label for="passUser_confirm">Confirmez le mot de passe</label>
            <input type="password" name="passUser_confirm" id="passUser_confirm" size="80" maxlength="80"/>
            <label><input type="checkbox" onclick="myFunction('passUser_confirm')"><i>Afficher Mot de passe</i></label>
        </div>

        <div class="field">
            <label for="idStat">Statut</label>
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
