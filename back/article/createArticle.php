<?php

$submitBtn = "Créer";
$pageCrud = "article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des '.$pageCrud.':'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../CLASS_CRUD/article.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/angle.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/thematique.class.php'; 

// Instanciation de la classe Membre
$monArticle = new ARTICLE(); 
$maLangue = new LANGUE();
$monAngle = new ANGLE();
$maThematique = new THEMATIQUE();

$validator = Validator::make();
$fileValidator = Validator::make();

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fileValidator->addRules([
        ValidationRule::required('photArt')->image()->customError('isRequired', "L'image est requise")
    ])->bindValues($_FILES);


    $validator->addRules([
        ValidationRule::required('libTitrArt'),
        ValidationRule::required('dtCreArt'),
        ValidationRule::required('libChapoArt'),
        ValidationRule::required('libAccrochArt'),
        ValidationRule::required('parag1Art'),
        ValidationRule::required('libSsTitr1Art'),
        ValidationRule::required('parag2Art'),
        ValidationRule::required('libSsTitr2Art'),
        ValidationRule::required('parag3Art'),
        ValidationRule::required('libConclArt'),
        ValidationRule::required('numLang'),
        ValidationRule::required('numAngl'),
        ValidationRule::required('numThem')
    ])->bindValues($_POST);

    if( $fileValidator->success() AND $validator->success()) {

        $img = uploadImage(
            $fileValidator->verifiedFile('photArt'),
            'imgArt' . md5(uniqid())
        );
        $urlPhotArt = $img['filename'];

        $libTitrArt = $validator->verifiedField('libTitrArt');
        $dtCreArt = $validator->verifiedField('dtCreArt'); 
        $libChapoArt = $validator->verifiedField('libChapoArt');
        $libAccrochArt = $validator->verifiedField('libAccrochArt');
        $parag1Art = $validator->verifiedField('parag1Art');
        $libSsTitr1Art = $validator->verifiedField('libSsTitr1Art');
        $parag2Art = $validator->verifiedField('parag2Art');
        $libSsTitr2Art = $validator->verifiedField('libSsTitr2Art');
        $parag3Art = $validator->verifiedField('parag3Art');
        $libConclArt = $validator->verifiedField('libConclArt');
        $numLang = $validator->verifiedField('numLang');
        $numAngl = $validator->verifiedField('numAngl');
        $numThem = $validator->verifiedField('numThem');
        
        $monArticle->create($dtCreArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem);

        header("Location: $pagePrecedent");
        die();
    } 
}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initArticle.php';

include __DIR__ . '/../../layouts/back/head.php';

// affichage des erreurs
$fileValidator->echoErrors();
$validator->echoErrors();

?>
<form 
    class="admin-form"
    method="POST" 
    action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
    enctype="multipart/form-data" 
    accept-charset="UTF-8"
>


    <div class="field">
        <label for="photArt">Image</label>
        <label for="photArt" class="field-imgContent">
            <img id="previewPhotoArt" class="img-thumbnail input" src="" />
            <div class="field-actions">
                <input data-preview="previewPhotoArt" type="file" name="photArt" id="photArt" accept=".jpg,.gif,.png,.jpeg" title="Recherchez l'image à uploader !" />
                <p>
                    Extension des images acceptées : .jpg, .gif, .png, .jpeg. 
                    <br/>10 Mo maximum
                </p>
            </div>
        </label>
    </div>

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
        <label for="numLang">Quelle langue</label>
        <select name="numLang" id="numLang">
            <?php 
                $allLangues = $maLangue->get_AllLangues();                    
                foreach($allLangues as $langue) { 
            ?>
                <option value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="field">
        <label for="numAngl">Quel angle</label>
        <select name="numAngl" id="numAngl">
            <?php 
                $allAngles = $monAngle->get_AllAngles();                    
                foreach($allAngles as $angle) { 
            ?>
                <option value="<?= $angle['numAngl'] ?>" ><?=$angle['libAngl'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="field">
        <label for="numThem">Quelle thématique</label>
        <select name="numThem" id="numThem">
            <?php 
                $allThematiques = $maThematique->get_AllThematiques();                    
                foreach($allThematiques as $them) { 
            ?>
                <option value="<?= $them['numThem'] ?>" ><?=$them['libThem'] ?></option>
            <?php } ?>
        </select>
    </div>

    <!-- mot cle a rajouter -->

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