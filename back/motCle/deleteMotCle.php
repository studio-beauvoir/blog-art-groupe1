<?php

$submitBtn = "Supprimer";
$pageCrud = "motCle";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

//Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../CLASS_CRUD/motcle.class.php'; 
$monMotCle = new MOTCLE(); 

require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php';
$maLangue = new LANGUE();


// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = Validator::make([
        ValidationRule::required('id')
    ])->bindValues($_POST);

    if($validator->success()) {
        $numMotCle = $validator->verifiedField('id');
        $monMotCle->delete($numMotCle);

        header("Location: $pagePrecedent");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, le mot clé à supprimer n'existe pas !";
    }

}   // End of if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initMotCle.php';

//Architecture Arthaud

include __DIR__ . '/../../layouts/back/head.php';


// Supp : récup id à supprimer
// id passé en GET
if(!isset($_GET['id'])) {
    header("Location: $pagePrecedent");
    die();
}
$motcle = $monMotCle->get_1MotCle($_GET['id']);
if(!$motcle) {
    header("Location: $pagePrecedent");
    die();
}

$libMotCle = $motcle['libMotCle'];
$idLang = $motcle['numLang'];

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
            <label for="libMotCle">Nom</label>
            <input disabled name="libMotCle" id="libMotCle" size="80" maxlength="80" value="<?= $libMotCle; ?>" />
        </div>

        <div class="field">
            <label for="idLang">Quelle langue</label>
            <select disabled name="idLang" id="idLang">
                <?php 
                    $allLang = $maLangue->get_AllLangues();                    
                    foreach($allLang as $lang) { 
                ?>
                    <option <?=$lang['numLang']==$numLang?'selected':'' ?> value="<?= $lang['numLang'] ?>" ><?=$lang['lib1Lang'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id'] ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent?>">Annuler</a>
            <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>