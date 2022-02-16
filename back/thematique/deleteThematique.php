<?php
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Thematique
require_once __DIR__ . '/../../CLASS_CRUD/thematique.class.php';
// Instanciation de la classe thématique
$maThematique = new THEMATIQUE(); 

require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php';
// Instanciation de la classe thématique
$maLangue = new LANGUE(); 

// Ctrl CIR
// Insertion classe Article
require_once __DIR__ . '/../../CLASS_CRUD/article.class.php';
// Instanciation de la classe Article
$monArticle = new ARTICLE();

// BBCode

$erreur = false;


// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = Validator::make([
        ValidationRule::required('id')
    ])->bindValues($_POST);

    if($validator->success()) {
        $numThem = $validator->verifiedField('id');
        $maThematique->delete($numThem);

        header("Location: ./thematique.php");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, la thématique à supprimer n'existe pas !";
    }

}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initThematique.php';

$submitBtn = "Supprimer";
$pagePrecedent = "./thematique.php";
$pageTitle = "Supprimer une Thématique";
$pageNav = ['Home:/index1.php', 'Gestion des thématiques:'.$pagePrecedent, $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';

// Supp : récup id à supprimer
// id passé en GET
$thematique = $maThematique->get_1Thematique($_GET['id']);
$libThem = $thematique['libThem'];
$numLang = $thematique['numLang'];

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
            <label for="libThem">Titre de la thématique</label>
            <input disabled name="libThem" value="<?=$libThem?>" id="libThem" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="idLang">Quelle langue</label>
            <select disabled name="idLang" id="idLang">
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
            <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>