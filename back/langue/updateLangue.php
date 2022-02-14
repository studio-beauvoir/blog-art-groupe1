<?php
////////////////////////////////////////////////////////////
//
//  CRUD LANGUE (PDO) - Modifié : 4 Juillet 2021
//
//  Script  : updateLangue.php  -  (ETUD)  BLOGART22
//
////////////////////////////////////////////////////////////

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
        ValidationRule::required('id'),
        ValidationRule::required('lib1Lang'),
        ValidationRule::required('lib2Lang'),
        ValidationRule::required('idPays'),
    ])->bindValues($_POST);
    

    if($validator->success()) {
        $erreur = false;

        $numLang = $validator->verifiedField('id');
        $lib1Lang = $validator->verifiedField('lib1Lang');
        $lib2Lang = $validator->verifiedField('lib2Lang');
        $numPays = $validator->verifiedField('idPays');
        
        $maLangue->update($numLang, $lib1Lang, $lib2Lang, $numPays);

        header("Location: ./langue.php");
        die();
    } else {
        // Saisies invalides
        $erreur = true;
        $errSaisies =  "Erreur, la saisie est obligatoire !";
    }   // End of else erreur saisies








}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")
// Init variables form
include __DIR__ . '/initLangue.php';
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="utf-8" />
    <title>Admin - CRUD Langue</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <h1>BLOGART22 Admin - CRUD Langue</h1>
    <h2>Modification d'une langue</h2>
<?php
    // Modif : récup id à modifier
    // id passé en GET

    if(!isset($_GET['id'])) {
        header("Location: ./langue.php");
        die();
    }
    $langue = $maLangue->get_1Langue($_GET['id']);

    $lib1Lang = $langue['lib1Lang'];
    $lib2Lang = $langue['lib2Lang'];
    $idPays = $langue['numPays'];

?>
    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" accept-charset="UTF-8">

      <fieldset>
        <legend class="legend1">Formulaire Langue...</legend>

        <input type="hidden" id="id" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : '' ?>" />

        <div class="control-group">
            <label class="control-label" for="lib1Lang"><b>Libellé court :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="text" name="lib1Lang" id="lib1Lang" size="80" maxlength="80" value="<?= $lib1Lang; ?>" tabindex="10" autofocus="autofocus" /><br><br>
        </div>
        <div class="control-group">
            <label class="control-label" for="lib2Lang"><b>Libellé long :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <input type="text" name="lib2Lang" id="lib2Lang" size="80" maxlength="80" value="<?= $lib2Lang; ?>" tabindex="20" />
        </div>
        <br>
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Listbox Pays -->
        <br>
        <div class="control-group">
            <div class="controls">
            <label class="control-label" for="LibTypPays">
                <b>Quel pays :&nbsp;&nbsp;&nbsp;</b>
            </label>


                <!-- <input type="text" name="idPays" id="idPays" size="5" maxlength="5" value="<?= $idPays ?>" autocomplete="on" /> -->

                <!-- Listbox pays => 2ème temps -->

                <select name="idPays" id="idPays">
                    <?php 
                        $allPays = $maLangue->get_AllPays();                    
                        foreach($allPays as $pays) { 
                    ?>
                        <option <?=$pays['numPays']==$idPays?'selected':'' ?> value="<?= $pays['numPays'] ?>" ><?=$pays['frPays'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    <!-- FIN Listbox Pays -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
        <div class="control-group">
            <div class="error">
<?php
            if ($erreur) {
                echo ($errSaisies);
            } else {
                $errSaisies = "";
                echo ($errSaisies);
            }
?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Initialiser" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;" name="Submit" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Valider" style="cursor:pointer; padding:5px 20px; background-color:lightsteelblue; border:dotted 2px grey; border-radius:5px;" name="Submit" />
                <br>
            </div>
        </div>
      </fieldset>
    </form>
<?php
require_once __DIR__ . '/footerLangue.php';

require_once __DIR__ . '/footer.php';
?>
</body>
</html>
