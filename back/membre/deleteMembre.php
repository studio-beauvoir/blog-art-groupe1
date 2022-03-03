<?php
$submitBtn = "Supprimer";
$pageCrud = "membre";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Supprimer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];


require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../class_crud/membre.class.php';
$monMembre = new membre(); 

require_once __DIR__ . '/../../class_crud/statut.class.php';
$monStatut = new statut(); 

// Ctrl CIR
// Insertion classe Article

// Instanciation de la classe Article



// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {



    // controle CIR

    // delete effective de l'angle

    $validator = Validator::make([
        ValidationRule::required('id')
    ])->bindValues($_POST);

    if($validator->success()) {
        $idMemb = $validator->verifiedField('id');
        $monMembre->delete($idMemb);
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
        $errSaisies =  "Erreur, le membre à supprimer n'existe pas !";
    }

}

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

<?php
// controles
if(!isset($_GET['id'])) header("Location: $pagePrecedent");
$membre = $monMembre->get_1Membre($_GET['id']);
if(!$membre) header("Location: $pagePrecedent");

$prenomMemb = $membre['prenomMemb'];
$nomMemb = $membre['nomMemb'];
$pseudoMemb = $membre['pseudoMemb'];
$passMemb = $membre['passMemb'];
$eMailMemb = $membre['eMailMemb'];
$dtCreaMemb = $membre['dtCreaMemb'];
$accordMemb = $membre['accordMemb'];
$idStat = $membre['idStat'];
?>
    <form
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?>" />

        <div class="field">
            <label for="prenomMemb">Prénom</label>
            <input disabled name="prenomMemb" id="prenomMemb" size="80" maxlength="80" value="<?= $prenomMemb; ?>" />
        </div>

        <div class="field">
            <label for="nomMemb">Nom</label>
            <input disabled name="nomMemb" id="nomMemb" size="80" maxlength="80" value="<?= $nomMemb; ?>" />
        </div>

        <div class="field">
            <label for="pseudoMemb">Pseudo</label>
            <input disabled name="pseudoMembe" id="pseudoMemb" size="80" maxlength="80" value="<?= $pseudoMemb; ?>" disabled />
        </div>

        <div class="field">
            <label class="control-label" for="pass1Memb"><b>Mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" disabled name="pass1Memb" id="myInput1" size="80" maxlength="80" value="<?= $passMemb; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput1')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="pass2Memb"><b>Confirmez le mot passe<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="password" disabled name="pass2Memb" id="myInput2" size="80" maxlength="80" value="<?= $passMemb; ?>" autocomplete="on" />
            <br>
            <input type="checkbox" onclick="myFunction('myInput2')">
            &nbsp;&nbsp;
            <label><i>Afficher mot de passe</i></label>
        </div>
        <small class="error">*Champ obligatoire si nouveau passe</small><br>

        <div class="field">
            <label class="control-label" for="eMail1Memb"><b>eMail<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="email" disabled name="eMail1Memb" id="eMail1Memb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" autocomplete="on" />
        </div>

        <br>
        <div class="field">
            <label class="control-label" for="eMail2Memb"><b>Confirmez l'eMail<span class="error">(*)</span> :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="email" disabled name="eMail2Memb" id="eMail2Memb" size="80" maxlength="80" value="<?= $eMailMemb; ?>" autocomplete="on" />
        </div>
        <small class="error">*Champ obligatoire si nouveau eMail</small><br>


        <div class="field">
            <label for="dtCreaMemb">Date de création</label>
            <input disabled name="dtCreaMemb" id="dtCreaMemb" size="80" maxlength="80" value="<?= $dtCreaMemb; ?>" />
        </div>

        <div class="field">
            <label for="accordMemb">Accord du membre au RGPD</label>
            <input disabled name="accordMemb" id="accordMemb" size="80" maxlength="80" value="<?= $accordMemb; ?>" />
        </div>

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