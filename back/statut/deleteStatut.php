<?php
////////////////////////////////////////////////////////////
//
//  CRUD STATUT (PDO) - Modifié : 4 Juillet 2021
//
//  Script  : deleteStatut.php  -  (ETUD)  BLOGART22
//
////////////////////////////////////////////////////////////

// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../CLASS_CRUD/statut.class.php'; 

// Instanciation de la classe Statut
$monStatut = new STATUT(); 

// Ctrl CIR
// Insertion classe User
require_once __DIR__ . '/../../CLASS_CRUD/user.class.php';
// Instanciation de la classe User
$monUser = new USER();

// Insertion classe Membre
require_once __DIR__ . '/../../CLASS_CRUD/membre.class.php';
// Instanciation de la classe Membre
$monMembre = new MEMBRE();

// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // controle des saisies du formulaire
    if(isset($_POST['Submit'])){
        $Submit = $_POST['Submit'];
    } else {
        $Submit = "";
    }

    $validator = Validator::make([
        ValidationRule::required('id')
    ])->bindValues($_POST);

    if($validator->success()) {
        
        // A faire dans un 2ème temps
        // Ctrl CIR : inexistence Foreign Key => del possible
        // $nbMembresStatut = $monMEMBRE->get_NbAllMembersByidStat();
        // il existe des membres avec ce statut
        // if($nbMembresStatut>0) {
        //     header("Location: ./statut.php");
        // } 



        // modification effective du statut
        $idStat = ctrlSaisies($_POST['id']);
        $monStatut->delete($idStat);
        // header("Location: ./deleteStatut.php");
        header("Location: ./statut.php");

    } else {
        // Gestion des erreurs => msg si saisies ko
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }

}   // End of if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initStatut.php';

$pageTitle = "Admin - CRUD Statut";
include __DIR__ . '/../../layouts/back/head.php';
?>
    <h1>BLOGART22 Admin - CRUD Statut</h1>
    <h2>Suppression d'un statut</h2>
<?php
    // Supp : récup id à supprimer
    // id passé en GET
    $statut = $monStatut->get_1Statut($_GET['id']);

    $libStat = $statut['libStat'];

?>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" accept-charset="UTF-8">

      <fieldset>
        <legend class="legend1">Formulaire Statut...</legend>

        <input type="hidden" id="id" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>" />

        <div class="control-group">
            <label class="control-label" for="libStat"><b>Nom :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="text" name="libStat" id="libStat" size="80" maxlength="80" value="<?= $libStat ?>" disabled="disabled" />
        </div>

        <div class="control-group">
            <div class="controls">
                <br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="./statut.php" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;">Annuler</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Valider" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;"/>
                <br>
            </div>
        </div>
      </fieldset>
    </form>
    <br>
    <i><div class="error"><br>=>&nbsp;Attention, une suppression doit respecter les CIR !</div></i>
<?php
require_once __DIR__ . '/footerStatut.php';

require_once __DIR__ . '/footer.php';
?>
</body>
</html>
