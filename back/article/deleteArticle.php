<?php
$submitBtn = "Supprimer";
$pageCrud = "article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "Supprimer un $pageCrud";
$pageNav = ['Home:/index1.php', 'Gestion des '.$pageCrud.'s:'.$pagePrecedent, $pageTitle];

//Insertion fichiers utiles
require_once __DIR__ . '/../../util/index.php';

//Insertion classe Article.class
require_once __DIR__ . '/../../CLASS_CRUD/article.class.php';

//Instanciation de la classe Article
$monArticle = new ARTICLE(); 

//Insertion classe Angle
require_once __DIR__ . '/../../CLASS_CRUD/angle.class.php';

//Instanciation de la classe Angle
$monAngle = new ANGLE(); 

//Insertion classe Thématique
require_once __DIR__ . '/../../CLASS_CRUD/thematique.class.php';

//Instanciation de la classe Thématique
$maThematique = new THEMATIQUE();

// Ctrl CIR


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
        $idArt = $validator->verifiedField('id');
        $monArticle->delete($idArt);

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
$libTitrArt = $article['dtCreArt'];
$libChapoArt = $article['dtCreArt'];
$libAccrochArt = $article['dtCreArt'];
$parag1Art = $article['dtCreArt'];
$libSsTitr1Art = $article['dtCreArt'];
$parag2Art = $article['dtCreArt'];
$libSsTitr2Art = $article['dtCreArt'];
$parag3Art = $article['dtCreArt'];
$libConclArt = $article['dtCreArt'];
$urlPhotArt = $article['dtCreArt'];
$idAngl = $article['numAngl'];
$idThem = $article['numThem'];
?>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <form
        class="admin-form"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=$_GET['id']?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >
        <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ?>" />
        
        <div class="field">
        <label for="photArt">Nom de l'article</label>
        <input type="file" disabled name="photArt" id="photArt" required="required" accept=".jpg,.gif,.png,.jpeg" size="70" maxlength="70" title="Recherchez l'image à uploader !" />
        <input type="hidden" disabled name="MAX_FILE_SIZE" value="<?= MAX_SIZE; ?>" />
        <p>
        <?php              // Gestion extension images acceptées
            $msgImagesOK = "&nbsp;&nbsp;>> Extension des images acceptées : .jpg, .gif, .png, .jpeg" . "<br>" .
            "(lageur, hauteur, taille max : 80000px, 80000px, 200 000 Go)";
            echo "<i>" . $msgImagesOK . "</i>";
        ?>                
        </p>
        </div>

        <div class="field">
            <label for="libTitrArt">Nom de l'article</label>
            <input disabled name="libTitrArt" value="<?=$libTitrArt?>" id="libTitrArt" placeholder="Sur 100 car." size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="dtCreArt">Date de création</label>
            <input type="datetime-local" disabled name="dtCreArt" value="<?=$dtCreArt?>" id="dtCreArt"/>
        </div>

        <div class="field">
            <label for="libChapoArt">Chapeau</label>
            <textarea disabled name="libChapoArt" value="<?=$libChapoArt?>" id="libChapoArt" rows="10" placeholder="Sur 500 car."></textarea>
        </div>

        <div class="field">
            <label for="libAccrochArt">Accroche paragraphe 1</label>
            <input disabled name="libAccrochArt" value="<?=$libAccrochArt?>" id="libAccrochArt" placeholder="Sur 100 car." size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="parag1Art">Paragraphe 1</label>
            <textarea disabled name="parag1Art" value="<?=$parag1Art?>" id="parag1Art" rows="10" placeholder="Sur 1200 car."></textarea>
        </div>

        <div class="field">
            <label for="libSsTitr1Art">Sous-titre 1</label>
            <input disabled name="libSsTitr1Art" value="<?=$libSsTitr1Art?>" id="libSsTitr1Art" placeholder="Sur 100 car." size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="parag2Art">Paragraphe 2</label>
            <textarea disabled name="parag2Art" value="<?=$parag2Art?>" id="parag2Art" rows="10" placeholder="Sur 1200 car."></textarea>
        </div>

        <div class="field">
            <label for="libSsTitr2Art">Sous-titre 2</label>
            <input disabled name="libSsTitr2Art" value="<?=$libSsTitr2Art?>" id="libSsTitr2Art" placeholder="Sur 100 car." size="100" maxlength="100" />
        </div>

        <div class="field">
            <label for="parag3Art">Paragraphe 3</label>
            <textarea disabled name="parag3Art" value="<?=$parag3Art?>" id="parag3Art" rows="10" placeholder="Sur 1200 car."></textarea>
        </div>

        <div class="field">
            <label for="libConclArt">Conclusion</label>
            <textarea disabled name="libConclArt" value="<?=$libConclArt?>" id="libConclArt" rows="10" placeholder="Sur 800 car."></textarea>
        </div>

        <div class="field">
            <label for="idLang">Quelle langue</label>
            <select disabled name="idLang" id="idLang">
                <?php 
                    $allLangues = $maLangue->get_AllLangues();                    
                    foreach($allLangues as $langue) { 
                ?>
                    <option value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="idAngl">Quelle angle</label>
            <select disabled name="idAngl" id="idAngl">
                <?php 
                    $allAngles = $monAngle->get_AllAngles();                    
                    foreach($allAngles as $angle) { 
                ?>
                    <option value="<?= $angle['numAngl'] ?>" ><?=$angle['libAngl'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="field">
            <label for="idLang">Quelle thématique</label>
            <select disabled name="idLang" id="idLang">
                <?php 
                    $allThematiques = $maThematique->get_AllThematiques();                    
                    foreach($allThematiques as $them) { 
                ?>
                    <option value="<?= $them['numThem'] ?>" ><?=$them['libThem'] ?></option>
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