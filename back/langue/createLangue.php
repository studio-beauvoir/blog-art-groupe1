<?php

$submitBtn = "Créer";
$pageCrud = "langue";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn: $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../class_crud/langue.class.php'; 


// Instanciation de la classe langue
$maLangue = new langue(); 


// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {



    $validator = Validator::make([
        ValidationRule::required('lib1Lang'),
        ValidationRule::required('lib2Lang'),
        ValidationRule::required('idPays'),
    ])->bindValues($_POST);
    

    if($validator->success()) {

        //Saisies valides
        $erreur = false;

        $lib1Lang = $validator->verifiedField('lib1Lang');
        $lib2Lang = $validator->verifiedField('lib2Lang');
        $numPays = $validator->verifiedField('idPays');
        
        $numLang = $maLangue->getNextNumLang($numPays);
        $maLangue->create($numLang, $lib1Lang, $lib2Lang, $numPays);

        header("Location: $pagePrecedent");
        die();
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies
}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initLangue.php';


//Architecture d'Arthaud
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
            <label for="lib1Lang">Libellé court </label>
            <input name="lib1Lang" id="lib1Lang" size="80" maxlength="80"/>
        </div>

        <div class="field">
            <label for="lib2Lang">Libellé long</label>
            <input name="lib2Lang" id="lib2Lang" size="80" maxlength="80"/>
        </div>
        
        <div class="field">
            <label for="idPays">Pays</label>
            <select name="idPays" id="idPays">
                <?php 
                    $allPays = $maLangue->get_AllPays();                    
                    foreach($allPays as $pays) { 
                ?>
                    <option value="<?= $pays['numPays'] ?>" ><?=$pays['frPays'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="controls">
            <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent?>">Annuler</a>
            <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>