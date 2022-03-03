<?php
$submitBtn = "Supprimer";
$pageCrud = "article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Supprimer un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

//Insertion fichiers utiles
require_once __DIR__ . '/../../util/index.php';

//Insertion classe Article.class
require_once __DIR__ . '/../../class_crud/article.class.php';

//Instanciation de la classe Article
$monArticle = new article(); 

//Insertion classe Angle
require_once __DIR__ . '/../../class_crud/angle.class.php';

//Instanciation de la classe Angle
$monAngle = new angle(); 

//Insertion classe Thématique
require_once __DIR__ . '/../../class_crud/thematique.class.php';

//Instanciation de la classe Thématique
$maThematique = new thematique();

//Insertion classe Langue
require_once __DIR__ . '/../../class_crud/langue.class.php';

//Instanciation de la classe Langue
$maLangue = new langue(); 
// Ctrl CIR


// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {



    // controle CIR

    // delete effective de l'angle

    $validator = Validator::make([
        ValidationRule::required('id'),
        ValidationRule::required('urlPhotArt')
    ])->bindValues($_POST);

    if($validator->success()) {
        $numArt = $validator->verifiedField('id');
        $urlPhotArt = $validator->verifiedField('urlPhotArt');
        
        // suppression de la photo
        deleteImage($urlPhotArt);

        $monArticle->delete($numArt);

        header("Location: $pagePrecedent");
        die();
    } else {
        $erreur = true;
        $errSaisies =  "Erreur, l'article à supprimer n'existe pas !";
    }

}

// Init variables form
include __DIR__ . '/initArticle.php';
include __DIR__ . '/../../layouts/back/head.php';

// controles
if(!isset($_GET['id'])) header("Location: $pagePrecedent");
$article = $monArticle->get_1Article($_GET['id']);
if(!$article) header("Location: $pagePrecedent");


$dtCreArt = $article['dtCreArt'];
$libTitrArt = $article['libTitrArt'];
$libChapoArt = $article['libChapoArt'];
$libAccrochArt = $article['libAccrochArt'];
$parag1Art = $article['parag1Art'];
$libSsTitr1Art = $article['libSsTitr1Art'];
$parag2Art = $article['parag2Art'];
$libSsTitr2Art = $article['libSsTitr2Art'];
$parag3Art = $article['parag3Art'];
$libConclArt = $article['libConclArt'];
$urlPhotArt = $article['urlPhotArt'];
$idAngl = $article['numAngl'];
$idThem = $article['numThem'];

?>
<form 
    class="admin-form"
    method="POST" 
    action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id']?>" 
    enctype="multipart/form-data" 
    accept-charset="UTF-8"
>

    <input type="hidden" id="id" name="id" value="<?=$_GET['id'] ?>" />

    <div class="field">
        <input type="hidden" id="urlPhotArt" name="urlPhotArt" value="<?=$urlPhotArt ?>" />
        <label for="photArt">Image</label>
        <label for="photArt" class="field-imgContent">
            <img id="previewPhotoArt" class="img-thumbnail"  src="<?= webUploadPath($urlPhotArt) ?>" />
        </label>
    </div>

    <div class="field">
        <label for="libTitrArt">Nom de l'article</label>
        <input disabled value="<?=$libTitrArt ?>" name="libTitrArt" id="libTitrArt" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="dtCreArt">Date de création</label>
        <input disabled value="<?=preg_replace('/\s/', 'T', $dtCreArt) ?>" type="datetime-local" name="dtCreArt" id="dtCreArt"/>
    </div>

    <div class="field">
        <label for="libChapoArt">Chapeau</label>
        <textarea disabled name="libChapoArt" id="libChapoArt" rows="10" placeholder="Décrivez le chapeau. Sur 500 car."><?=$libChapoArt ?></textarea>
    </div>

    <div class="field">
        <label for="libAccrochArt">Accroche paragraphe 1</label>
        <input disabled value="<?=$libAccrochArt ?>" name="libAccrochArt" id="libAccrochArt" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag1Art">Paragraphe 1</label>
        <textarea disabled name="parag1Art" id="parag1Art" rows="10" placeholder="Décrivez le premier paragraphe. Sur 1200 car."><?=$parag1Art ?></textarea>
    </div>

    <div class="field">
        <label for="libSsTitr1Art">Sous-titre 1</label>
        <input disabled value="<?=$libSsTitr1Art ?>" name="libSsTitr1Art" id="libSsTitr1Art" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag2Art">Paragraphe 2</label>
        <textarea disabled name="parag2Art" id="parag2Art" rows="10" placeholder="Décrivez le deuxième paragraphe. Sur 1200 car."><?=$parag2Art ?></textarea>
    </div>

    <div class="field">
        <label for="libSsTitr2Art">Sous-titre 2</label>
        <input disabled value="<?=$libSsTitr2Art ?>" name="libSsTitr2Art" id="libSsTitr2Art" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag3Art">Paragraphe 3</label>
        <textarea disabled name="parag3Art" id="parag3Art" rows="10" placeholder="Décrivez le troisième paragraphe. Sur 1200 car."><?=$parag3Art ?></textarea>
    </div>

    <div class="field">
        <label for="libConclArt">Conclusion</label>
        <textarea disabled name="libConclArt" id="libConclArt" rows="10" placeholder="Décrivez la conclusion. Sur 800 car."><?=$libConclArt ?></textarea>
    </div>

    <div class="field">
        <label for="numAngl">Quel angle</label>
        <select disabled name="numAngl" id="numAngl">
            <?php 
                $allAngles = $monAngle->get_AllAngles();                    
                foreach($allAngles as $angle) { 
            ?>
            <option <?=$angle['numAngl']==$numAngl?'selected':'' ?> value="<?= $angle['numAngl'] ?>" ><?=$angle['libAngl'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="field">
        <label for="numThem">Quelle thématique</label>
        <select disabled name="numThem" id="numThem">
            <?php 
                $allThematiques = $maThematique->get_AllThematiques();                    
                foreach($allThematiques as $them) { 
            ?>
                <option <?=$them['numThem']==$numThem?'selected':'' ?> value="<?= $them['numThem'] ?>" ><?=$them['libThem'] ?></option>
            <?php } ?>
        </select>
    </div>

    <!-- mot cle a rajouter -->

    <div class="controls">
        <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
        <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
        <input class="btn btn-lg btn-danger" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
    </div>
</form>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>