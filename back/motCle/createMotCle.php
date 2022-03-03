<?php
// Mode DEV
require_once __DIR__ . '/../../util/index.php';


// Insertion classe MotCle
require_once __DIR__ . '/../../class_crud/motcle.class.php';
// Instanciation de la classe MotCle
$monMotCle = new motcle(); 

require_once __DIR__ . '/../../class_crud/langue.class.php';

// Instanciation de la classe Langue
$maLangue = new langue();

// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST

if ($_SERVER["REQUEST_METHOD"] === "POST") {

$validator = Validator::make([
    ValidationRule::required('libMotCle'),
    ValidationRule::required('idLang'),
])->bindValues($_POST);

if($validator->success()) {
    $erreur = false;

    $libMotCle = $validator->verifiedField('libMotCle');
    $numLang = $validator->verifiedField('idLang');
    
    $monMotCle->create($libMotCle, $numLang);

    header("Location: ./motCle.php");
    die();
} else {
    // Saisies invalides
    $erreur = true;
    $errSaisies =  "Erreur, la saisie est obligatoire !";
}   // End of else erreur saisies

}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initMotCle.php';

$submitBtn = "Créer";
$pagePrecedent = "./motCle.php";
$pageTitle = "Créer un Mot Clé";
$pageNav = ['Home:/admin.php', 'Gestion des mots clés:'.$pagePrecedent, $pageTitle];
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
        <label for="libMotCle">Nom du mot clé</label>
        <input name="libMotCle" id="libMotCle" size="80" maxlength="80" />
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