<?php

$submitBtn = "Créer";
$pageCrud = "article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];
// Mode DEV
require_once __DIR__ . '/../../util/index.php';

// Init constantes
include __DIR__ . '/initConst.php';
// Init variables
include __DIR__ . '/initVar.php';

// Insertion classe MotCle
require_once __DIR__ . '/../../CLASS_CRUD/article.class.php';
// Instanciation de la classe MotCle
$monArticle = new ARTICLE(); 

// Instanciation de la classe Langue
$maLangue = new LANGUE();

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
include __DIR__ . '/initArticle.php';

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
        <label for="libTitrArt">Nom de l'article</label>
        <input name="libTitrArt" id="libTitrArt" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="dtCreArt">Date de création</label>
        <input type="datetime-local" name="dtCreArt" id="dtCreArt"/>
    </div>

    <div class="field">
        <label for="libChapoArt">Chapeau</label>
        <textarea name="libChapoArt" id="libChapoArt" rows="10" placeholder="Décrivez le chapeau. Sur 500 car."></textarea>
    </div>

    <div class="field">
        <label for="libAccrochArt">Accroche paragraphe 1</label>
        <input name="libAccrochArt" id="libAccrochArt" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag1Art">Paragraphe 1</label>
        <textarea name="parag1Art" id="parag1Art" rows="10" placeholder="Décrivez le premier paragraphe. Sur 1200 car."></textarea>
    </div>

    <div class="field">
        <label for="libSsTitr1Art">Sous-titre 1</label>
        <input name="libSsTitr1Art" id="libSsTitr1Art" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag2Art">Paragraphe 2</label>
        <textarea name="parag2Art" id="parag2Art" rows="10" placeholder="Décrivez le deuxième paragraphe. Sur 1200 car."></textarea>
    </div>

    <div class="field">
        <label for="libSsTitr2Art">Sous-titre 2</label>
        <input name="libSsTitr2Art" id="libSsTitr2Art" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag3Art">Paragraphe 3</label>
        <textarea name="parag3Art" id="parag3Art" rows="10" placeholder="Décrivez le troisième paragraphe. Sur 1200 car."></textarea>
    </div>

    <div class="field">
        <label for="libConclArt">Conclusion</label>
        <textarea name="libConclArt" id="libConclArt" rows="10" placeholder="Décrivez la conclusion. Sur 800 car."></textarea>
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
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- --------------------------------------------------------------- -->
    <!-- Début Ajax : Langue => Angle, Thématique + TJ Mots Clés -->
<!-- --------------------------------------------------------------- -->

    <!-- A faire dans un 3ème temps  -->

<!-- --------------------------------------------------------------- -->
    <!-- Fin Ajax : Langue => Angle, Thématique + TJ Mots Clés -->
<!-- --------------------------------------------------------------- -->

<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
    


        <div class="control-group">
            <label class="control-label" for="urlPhotArt"><b>Importez l'illustration :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
            <div class="controls">
                <input type="hidden" name="MAX_FILE_SIZE" value="<?= MAX_SIZE; ?>" />
                <input type="file" name="monfichier" id="monfichier" required="required" accept=".jpg,.gif,.png,.jpeg" size="70" maxlength="70" value="<? if(isset($_GET['id'])) echo $_POST['urlPhotArt']; else echo $urlPhotArt; ?>" tabindex="110" placeholder="Sur 70 car." title="Recherchez l'image à uploader !" />
                <p>
<?php              // Gestion extension images acceptées
                  $msgImagesOK = "&nbsp;&nbsp;>> Extension des images acceptées : .jpg, .gif, .png, .jpeg" . "<br>" .
                    "(lageur, hauteur, taille max : 80000px, 80000px, 200 000 Go)";
                  echo "<i>" . $msgImagesOK . "</i>";
?>
                </p>
            </div>
        </div>

<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Listbox Langue -->
        <br>
        <div class="control-group">
            <div class="controls">
                <label class="control-label" for="LibTypLang">
                    <b>Quelle langue :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                </label>



                <input type="text" name="idLang" id="idLang" size="5" maxlength="5" value="<?= $numAngl; ?>" autocomplete="on" />

                <!-- Listbox langue => 2ème temps -->

            </div>
        </div>
    <!-- FIN Listbox Langue -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->

<!-- --------------------------------------------------------------- -->
    <!-- FK : Angle, Thématique + TJ Mots Clés -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Listbox Angle live share -->
        <br>
        <div class="control-group">
            <div class="controls">
                <label class="control-label" for="LibTypAngl">
                    <b>Quel angle :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                </label>


                <input type="text" name="idAngl" id="idAngl" size="5" maxlength="5" value="<?= $numAngl; ?>" autocomplete="on" />

                <!-- Listbox angle => 2ème temps -->

            </div>
        </div>
    <!-- FIN Listbox Angle -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Listbox Thématique -->
    <!-- Grp 7 -->
        <br>
        <div class="control-group">
            <div class="controls">
                <label class="control-label" for="LibTypThem">
                    <b>Quelle thématique :&nbsp;&nbsp;&nbsp;</b>
                </label>


                <input type="text" name="idThem" id="idThem" size="5" maxlength="5" value="<?= $numThem; ?>" autocomplete="on" />

                <!-- Listbox thematique => 2ème temps -->

            </div>
        </div>
    <!-- FIN Listbox Thématique -->
<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->

<!-- --------------------------------------------------------------- -->
<!-- Drag and drop sur Mots clés -->
<!-- --------------------------------------------------------------- -->
    <br><br>
    <div class="controls">
        <label class="control-label" for="LibTypMotsCles1">
            <b>Choisissez les mots clés liés à l'article :&nbsp;&nbsp;&nbsp;</b>
        </label>
    </div>
    <!-- A faire dans un 2/3ème temps  -->

<!-- --------------------------------------------------------------- -->
<!-- End of Drag and drop sur Mots clés -->
<!-- --------------------------------------------------------------- -->

<!-- --------------------------------------------------------------- -->
<!-- --------------------------------------------------------------- -->
    <!-- Fin FK : Angle, Thématique + TJ Mots Clés -->
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
require_once __DIR__ . '/footerArticle.php';

require_once __DIR__ . '/footer.php';
?>
</body>
</html>
