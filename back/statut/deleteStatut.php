<?php
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

    $validator = Validator::make([
        ValidationRule::required('id')
    ])->bindValues($_POST);

    if($validator->success()) {
        
        // A faire dans un 2ème temps
        // Ctrl CIR : inexistence Foreign Key => del possible
        $nbMembresStatut = $monMembre->get_NbAllMembersByidStat($_POST['id']);
        $nbUsersStatut = $monUser->get_NbAllUsersByidStat($_POST['id']);

        
        // s'il existe au moins un membre ou un user avec ce statut
        if($nbMembresStatut>0 OR $nbUsersStatut>0) {
            // on redirige avec l'affichage de l'erreur
            header("Location: ./statut.php?err_cir=true");
            // et on s'arrête là
            die();
        } 

        // sinon c'est qu'on peut supp sans soucis

        // modification effective du statut
        // $idStat = ctrlSaisies($_POST['id']);
        $idStat = $validator->verifiedField('id');
        $monStatut->delete($idStat);

        header("Location: ./statut.php");
        die();

    } else {
        // Gestion des erreurs => msg si saisies ko
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }

}   // End of if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initStatut.php';

$pageTitle = "Supprimer un Statut";
$pageNav = ['Home:/admin.php', 'Gestion du Statut:./statut.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';


// Supp : récup id à supprimer
// id passé en GET
$statut = $monStatut->get_1Statut($_GET['id']);

$libStat = $statut['libStat'];

?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="id" name="id" value="<?=$_GET['id'] ?>" />

        <div class="field">
            <label for="libStat">Nom</label>
            <input disabled name="libStat" id="libStat" size="80" maxlength="80" value="<?= $libStat; ?>" />
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" href="./statut.php">Annuler</a>
            <input class="btn btn-lg btn-danger" type="submit" value="Supprimer" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>