<?php

$submitBtn = "Modifier";
$pageCrud = "motCle";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

require_once __DIR__ . '/../../util/index.php';

// Insertion classe Thematique
require_once __DIR__ . '/../../class_crud/motcle.class.php';
require_once __DIR__ . '/../../class_crud/langue.class.php';

// Instanciation de la classe Thematique
$monMotCle = new motcle();
$maLangue = new langue();


// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = Validator::make([
        ValidationRule::required('id'),
        ValidationRule::required('libMotCle'),
        ValidationRule::required('idLang'),
    ])->bindValues($_POST);


    if($validator->success()) {
        $erreur = false;

        $numMotCle = $validator->verifiedField('id');
        $libMotCle = $validator->verifiedField('libMotCle');
        $numLang = $validator->verifiedField('idLang');
        
        $monMotCle->update($numMotCle, $libMotCle, $numLang);

        header("Location: ./motCle.php");
        die();
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies


}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initMotCle.php';
include __DIR__ . '/../../layouts/back/head.php';

if(!isset($_GET['id'])) {
    header("Location: ./motcle.php");
    die();
}
$motcle = $monMotCle->get_1MotCle($_GET['id']);
$libMotCle = $motcle['libMotCle'];
$idLang = $motcle['numLang'];

?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id']?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?>" />
        
        <div class="field">
            <label for="libMotCle">Libellé :</label>
            <input name="libMotCle" value="<?=$libMotCle?>" id="libMotCle" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="idLang"></label>
            <select name="idLang" id="idLang">
                <?php 
                    $allLangues = $maLangue->get_AllLangues();                    
                    foreach($allLangues as $langue) { 
                ?>
                    <option <?=$langue['numLang']==$idLang?'selected':'' ?> value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
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