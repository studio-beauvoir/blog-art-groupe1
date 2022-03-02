<?php
$submitBtn = "Supprimer";
$pageCrud = "user";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Supprimer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];


require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../class_crud/user.class.php';
$monUser = new USER(); 

require_once __DIR__ . '/../../class_crud/statut.class.php';
$monStatut = new STATUT(); 

// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {



    // controle CIR

    // delete effective de l'angle

    $validator = Validator::make([
        ValidationRule::required('pseudoUser')
    ])->bindValues($_POST);

    if($validator->success()) {
        $idUser = $validator->verifiedField('pseudoUser');
        $monUser->delete($idUser);

        // A faire dans un 2ème temps
        // Ctrl CIR : inexistence Foreign Key => del possible
        //Pour le CIR, il faut vérifier que numMemb n'est pas présent dans les tables :
        //Comment
        //Like Art
        //Like Com
        //$nbMembresStatut = $monMembre->get_NbAllMembersByidStat($_POST['id']);
        //$nbUsersStatut = $monUser->get_NbAllUsersByidStat($_POST['id']);

        
        // s'il existe au moins un membre ou un user avec ce statut
        //if($nbMembresStatut>0 OR $nbUsersStatut>0) {
            // on redirige avec l'affichage de l'erreur
            //header("Location: ./statut.php?err_cir=true");
            // et on s'arrête là
            //die();
        //} 

        // sinon c'est qu'on peut supp sans soucis

        // modification effective du statut
        // $idStat = ctrlSaisies($_POST['id']);
        //$idStat = $validator->verifiedField('id');
        //$monStatut->delete($idStat);

        header("Location: $pagePrecedent");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, le user à supprimer n'existe pas !";
    }

}

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

<?php
// controles
if(!isset($_GET['pseudoUser'])) header("Location: $pagePrecedent");
$user = $monUser->get_1User(ctrlSaisies($_GET['pseudoUser']));
// if(!$user) header("Location: $pagePrecedent");

$pseudoUser = $user['pseudoUser'];
$nomUser = $user['nomUser'];
$prenomUser = $user['prenomUser'];
$eMailUser = $user['eMailUser'];
$passUser = $user['passUser'];
$idStat = $user['idStat'];
?>
    <form
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?pseudoUser=<?=$_GET['pseudoUser'] ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="pseudoUser" name="pseudoUser" value="<?= $_GET['pseudoUser'] ?>" />

        <div class="field">
            <label for="pseudoUser">Pseudo</label>
            <input disabled name="pseudoUser" id="pseudoUser" size="80" maxlength="80" value="<?= $pseudoUser; ?>" />
        </div>

        <div class="field">
            <label for="nomUser">Nom</label>
            <input disabled name="nomUser" id="nomUser" size="80" maxlength="80" value="<?= $nomUser; ?>" />
        </div>

        <div class="field">
            <label for="prenomUser">Prenom</label>
            <input disabled name="prenomUser" id="prenomUser" size="80" maxlength="80" value="<?= $prenomUser; ?>" disabled />
        </div>

        <div class="field">
            <label class="control-label" for="eMail1User"><b>eMail<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="email" disabled name="eMail1User" id="eMail1User" size="80" maxlength="80" value="<?= $eMailUser; ?>" autocomplete="on" />
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="eMail2User"><b>Confirmez l'eMail<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="email" disabled name="eMail2User" id="eMail2User" size="80" maxlength="80" value="<?= $eMailUser; ?>" autocomplete="on" />
        </div>
        <small class="error">*Champ obligatoire si nouveau eMail</small><br>

        <div class="field">
            <label class="control-label" for="pass1User"><b>Mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" disabled name="pass1User" id="myInput1" size="80" maxlength="80" value="<?= $passUser; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput1')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="pass2User"><b>Confirmez le mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" disabled name="pass2User" id="myInput2" size="80" maxlength="80" value="<?= $passUser; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput2')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>
        <small class="error">*Champ obligatoire si nouveau mot de passe</small><br>

        <div class="field">
            <label for="idStat">Quel statut :</label>
            <select disabled name="idStat" id="idStat">
            <?php 
                $allStatuts = $monStatut->get_AllStatuts();                    
                foreach($allStatuts as $statut) { 
            ?>
                <option <?=$statut['idStat']==$idStat?'selected':'' ?> value="<?= $statut['idStat'] ?>" ><?=$statut['libStat'] ?></option>
            <?php } ?>
            </select>
        </div>

        <div class="controls">
            <!--<a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a> -->
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
            <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>