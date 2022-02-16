<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php'; 


// Instanciation de la classe langue
$maLangue = new LANGUE(); 


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

        header("Location: ./langue.php");
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
$pageTitle = "Créer une langue";
$pageNav = ['Home:/index1.php', 'Gestion de la Langue:./langue.php', $pageTitle];
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
            <a class="btn btn-lg btn-text" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
            <a class="btn btn-lg btn-secondary" href="./langue.php">Annuler</a>
            <input class="btn btn-lg" type="submit" value="Valider" />
        </div>
    </form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>