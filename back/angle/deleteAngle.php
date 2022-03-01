<?php
$submitBtn = "Supprimer";
$pageCrud = "angle";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Supprimer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];


require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../CLASS_CRUD/angle.class.php';
$monAngle = new ANGLE(); 

require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php';
$maLangue = new LANGUE(); 

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
        $idAngl = $validator->verifiedField('id');
        $monAngle->delete($idAngl);

        header("Location: $pagePrecedent");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, la thématique à supprimer n'existe pas !";
    }

}

// Init variables form
include __DIR__ . '/initAngle.php';
include __DIR__ . '/../../layouts/back/head.php';

// controles
if(!isset($_GET['id'])) header("Location: $pagePrecedent");
$angle = $monAngle->get_1Angle($_GET['id']);
if(!$angle) header("Location: $pagePrecedent");

$libAngl = $angle['libAngl'];
$idLang = $angle['numLang'];
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
            <label for="libAngl">Libellé de l'angle</label>
            <input disabled name="libAngl" value="<?=$libAngl?>" id="libAngl" size="80" maxlength="80" />
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