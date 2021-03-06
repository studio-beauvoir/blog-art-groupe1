<?php
// Mode DEV
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Thematique
require_once __DIR__ . '/../../class_crud/thematique.class.php';
// Instanciation de la classe thématique
$maThematique = new thematique(); 

require_once __DIR__ . '/../../class_crud/langue.class.php';
// Instanciation de la classe langue
$maLangue = new langue();
// BBCode


// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator = Validator::make([
        ValidationRule::required('libThem'),
        ValidationRule::required('idLang'),
    ])->bindValues($_POST);

    if($validator->success()) {
        $erreur = false;

        $libThem = $validator->verifiedField('libThem');
        $numLang = $validator->verifiedField('idLang');
        
        $numThem = $maThematique->getNextNumThem($numLang);
        $maThematique->create($numThem, $libThem, $numLang);

        header("Location: ./thematique.php");
        die();
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initThematique.php';

$submitBtn = "Créer";
$pagePrecedent = "./thematique.php";
$pageTitle = "Créer une Thématique";
$pageNav = ['Home:/admin.php', 'Gestion des thématiques:'.$pagePrecedent, $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
    <form 
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >

        <div class="field">
            <label for="libThem">Titre de la thématique</label>
            <input name="libThem" id="libThem" size="80" maxlength="80" />
        </div>

        <div class="field">
            <label for="idLang">Quelle langue</label>
            <select name="idLang" id="idLang">
                <?php 
                    $allLangues = $maLangue->get_AllLangues();                    
                    foreach($allLangues as $langue) { 
                ?>
                    <option value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
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