<?php

$submitBtn = "Éditer";
$pageCrud = "article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.':'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../CLASS_CRUD/article.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/angle.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/thematique.class.php'; 
require_once __DIR__ . '/../../CLASS_CRUD/motclearticle.class.php'; 

$monMotcleArticle = new MOTCLEARTICLE();
$monArticle = new ARTICLE(); 
$maLangue = new LANGUE();
$monAngle = new ANGLE();
$maThematique = new THEMATIQUE();

$validator = Validator::make();
$fileValidator = Validator::make();


// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fileValidator->addRules([
        ValidationRule::optionnal('photArt')->image()
    ])->bindValues($_FILES);


    $validator->addRules([
        ValidationRule::required('id'),
        ValidationRule::required('urlPhotArt')->maxLength(70),
        ValidationRule::required('libTitrArt')->maxLength(100),
        ValidationRule::required('libChapoArt'),
        ValidationRule::required('libAccrochArt')->maxLength(100),
        ValidationRule::required('parag1Art'),
        ValidationRule::required('libSsTitr1Art')->maxLength(100),
        ValidationRule::required('parag2Art'),
        ValidationRule::required('libSsTitr2Art')->maxLength(100),
        ValidationRule::required('parag3Art'),
        ValidationRule::required('libConclArt'),
        ValidationRule::required('numAngl'),
        ValidationRule::required('numThem'),
        ValidationRule::required('oldKeywords'),
        ValidationRule::required('keywords')
    ])->bindValues($_POST);


    $fileValidator->test();
    $validator->test();

    if($fileValidator->hasSucceeded AND $validator->hasSucceeded) {


        $numArt = $validator->verifiedField('id'); 
        $urlPhotArt = $validator->verifiedField('urlPhotArt');

        // modification de l'image uniquement si on en a envoyé une
        if($fileValidator->isFilled('photArt')) {
            // suppression de l'ancienne photo
            deleteImage($urlPhotArt);

            $img = uploadImage(
                $fileValidator->verifiedFile('photArt'),
                'imgArt' . md5(uniqid())
            );
            $urlPhotArt = $img['filename'];
        }


        $oldKeywords = json_decode($validator->verifiedField('oldKeywords'), true); 
        $keywords = json_decode($validator->verifiedField('keywords'), true); 
        
        foreach($oldKeywords as $numMotCle) {
            // si un mot clé a été enlevé
            if(!in_array($numMotCle, $keywords)) {
                $monMotcleArticle->delete($numArt, $numMotCle);
            }
        }

        foreach($keywords as $numMotCle) {
            // si un mot clé a été ajouté
            if(!in_array($numMotCle, $oldKeywords)) {
                $monMotcleArticle->create($numArt, $numMotCle);
            }    
        }

        $libTitrArt = $validator->verifiedField('libTitrArt');
        $libChapoArt = $validator->verifiedField('libChapoArt');
        $libAccrochArt = $validator->verifiedField('libAccrochArt');
        $parag1Art = $validator->verifiedField('parag1Art');
        $libSsTitr1Art = $validator->verifiedField('libSsTitr1Art');
        $parag2Art = $validator->verifiedField('parag2Art');
        $libSsTitr2Art = $validator->verifiedField('libSsTitr2Art');
        $parag3Art = $validator->verifiedField('parag3Art');
        $libConclArt = $validator->verifiedField('libConclArt');
        $numAngl = $validator->verifiedField('numAngl');
        $numThem = $validator->verifiedField('numThem');
        
        $monArticle->update($numArt, $libTitrArt, $libChapoArt, $libAccrochArt, $parag1Art, $libSsTitr1Art, $parag2Art, $libSsTitr2Art, $parag3Art, $libConclArt, $urlPhotArt, $numAngl, $numThem);

        header("Location: $pagePrecedent");
        die();
    }
}   // Fin if ($_SERVER["REQUEST_METHOD"] === "POST")


// Init variables form
include __DIR__ . '/initArticle.php';

include __DIR__ . '/../../layouts/back/head.php';

// affichage des erreurs
$fileValidator->echoErrors();
$validator->echoErrors();

    // Modif : récup id à modifier
    // id passé en GET

    if(!isset($_GET['id'])) {
        header("Location: $pagePrecedent");
        die();
    }
    $numArt = $_GET['id'];
    $article = $monArticle->get_1Article($_GET['id']);
    // $idStat = $article['idStat'];
    $urlPhotArt = $article['urlPhotArt'];

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
    $numAngl = $article['numAngl'];
    $numThem = $article['numThem'];

    $kw = $monMotcleArticle->get_AllMotClesByNumArt($numArt);
    $selectedKeywords = [];
    foreach($kw as $keyword) {
        array_push($selectedKeywords, intval($keyword['numMotCle']));
    }

    $numLang = $monAngle->get_1Angle($numAngl)['numLang'];
?>
<form 
    class="admin-form"
    method="POST" 
    action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?=ctrlSaisies($numArt)?>" 
    enctype="multipart/form-data" 
    accept-charset="UTF-8"
>

    <input type="hidden" id="id" name="id" value="<?=ctrlSaisies($numArt) ?>" />

    <div class="field">
        <label for="photArt">Image</label>
        <label for="photArt" class="field-imgContent">
            <img id="previewPhotoArt" class="img-thumbnail input"  src="<?= webUploadPath($urlPhotArt) ?>" />
            <div class="field-actions">
                <input type="hidden" id="urlPhotArt" name="urlPhotArt" value="<?=$urlPhotArt ?>" />
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
        <input value="<?=$libTitrArt ?>" name="libTitrArt" id="libTitrArt" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="dtCreArt">Date de création</label>
        <input disabled value="<?=preg_replace('/\s/', 'T', $dtCreArt) ?>" type="datetime-local" name="dtCreArt" id="dtCreArt"/>
    </div>

    <div class="field">
        <label for="libChapoArt">Chapeau</label>
        <textarea name="libChapoArt" id="libChapoArt" rows="10" placeholder="Décrivez le chapeau. Sur 500 car."><?=$libChapoArt ?></textarea>
    </div>

    <div class="field">
        <label for="libAccrochArt">Accroche paragraphe 1</label>
        <input value="<?=$libAccrochArt ?>" name="libAccrochArt" id="libAccrochArt" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag1Art">Paragraphe 1</label>
        <!-- <textarea name="parag1Art" id="parag1Art" rows="10" placeholder="Décrivez le premier paragraphe. Sur 1200 car."><?=$parag1Art ?></textarea> -->
        <input bbeditor type="hidden" name="parag1Art" id="parag1Art" placeholder="Décrivez le premier paragraphe. Sur 1200 car." value="<?=$parag1Art?>" />
    </div>

    <div class="field">
        <label for="libSsTitr1Art">Sous-titre 1</label>
        <input value="<?=$libSsTitr1Art ?>" name="libSsTitr1Art" id="libSsTitr1Art" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag2Art">Paragraphe 2</label>
        <!-- <textarea name="parag2Art" id="parag2Art" rows="10" placeholder="Décrivez le deuxième paragraphe. Sur 1200 car."><?=$parag2Art ?></textarea> -->
        <input bbeditor type="hidden" name="parag2Art" id="parag2Art" placeholder="Décrivez le premier paragraphe. Sur 1200 car." value="<?=$parag2Art?>" />
    </div>

    <div class="field">
        <label for="libSsTitr2Art">Sous-titre 2</label>
        <input value="<?=$libSsTitr2Art ?>" name="libSsTitr2Art" id="libSsTitr2Art" placeholder="Sur 100 car." size="100" maxlength="100" />
    </div>

    <div class="field">
        <label for="parag3Art">Paragraphe 3</label>
        <!-- <textarea name="parag3Art" id="parag3Art" rows="10" placeholder="Décrivez le troisième paragraphe. Sur 1200 car."><?=$parag3Art ?></textarea> -->
        <input bbeditor type="hidden" name="parag3Art" id="parag3Art" placeholder="Décrivez le premier paragraphe. Sur 1200 car." value="<?=$parag3Art?>" />
    </div>

    <div class="field">
        <label for="libConclArt">Conclusion</label>
        <!-- <textarea name="libConclArt" id="libConclArt" rows="10" placeholder="Décrivez la conclusion. Sur 800 car."><?=$libConclArt ?></textarea> -->
        <input bbeditor type="hidden" name="libConclArt" id="libConclArt" placeholder="Décrivez le premier paragraphe. Sur 1200 car." value="<?=$libConclArt?>" />
    </div>


    <div class="field">
        <label for="numLang">Quelle langue</label>
        <select disabled name="numLang" id="numLang">
            <?php 
                $langue = $maLangue->get_1Langue($numLang);                    
            ?>
            <option selected value="<?= $langue['numLang'] ?>" ><?=$langue['lib1Lang'] ?></option>
        </select>
    </div>

    <div class="field">
        <label for="numAngl">Quel angle</label>
        <select name="numAngl" id="numAngl">
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
        <select name="numThem" id="numThem">
            <?php 
                $allThematiques = $maThematique->get_AllThematiques();                    
                foreach($allThematiques as $them) { 
            ?>
                <option <?=$them['numThem']==$numThem?'selected':'' ?> value="<?= $them['numThem'] ?>" ><?=$them['libThem'] ?></option>
            <?php } ?>
        </select>
    </div>


    <input type="hidden" name="oldKeywords" id="oldKeywords" value="<?=json_encode($selectedKeywords) ?>">
    <input type="hidden" name="keywords" id="keywords">
    <div id="keywords-control">
        <p>Mots clés sélectionnés</p>
        <div id="keywords-selected"></div>
        <p>Mots clés disponibles</p>
        <div id="keywords-availables"></div>
    </div>

    <div class="controls">
        <a class="btn btn-lg btn-text" title="Réinitialiser" href="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">Réinitialiser</a>
        <a class="btn btn-lg btn-secondary" title="Annuler" href="<?=$pagePrecedent ?>">Annuler</a>
        <input class="btn btn-lg" title="<?=$submitBtn?>" type="submit" value="<?=$submitBtn?>" />
    </div>
</form>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>

<script src="<?= webAssetPath('js/bbEditor.js') ?>"></script>

<!-- Ajax them et angles par langue, et Mot cle  -->
<script src="<?= webAssetPath('js/ajaxArticle.js') ?>"></script>

<script>
    const langueSelect = document.getElementById('numLang');
    const angleSelect = document.getElementById('numAngl');
    const thematiqueSelect = document.getElementById('numThem');

    const urlFetchAnglAndThem = "<?= webSitePath('/api/article/angle-and-them-by-lang.php') ?>";
    const urlFetchMotsCles = "<?= webSitePath('/api/motcle/motcle-by-lang.php') ?>";

    fetchLangAnglesAndKeywords();
    fetchMotsCles();
    langueSelect.addEventListener('change', function() {
        fetchLangAnglesAndKeywords();
        fetchMotsCles();
    });

    const editorEls = document.querySelectorAll('input[type="hidden"][bbeditor]');
    const editors = [];
    for(let editorEl of editorEls) {
        let editor = new bbEditor(editorEl);
        editors.push(
            editor.createDOM()
        );
    }
</script>

<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>