<?php

$submitBtn = "Créer";
$pageCrud = "comment";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn un $pageCrud";
$pageNav = ['Home:/admin.php', 'Gestion des '.$pageCrud.':'.$pagePrecedent, $pageTitle];
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

require_once __DIR__ . '/../../class_crud/comment.class.php'; 
require_once __DIR__ . '/../../class_crud/membre.class.php'; 
require_once __DIR__ . '/../../class_crud/article.class.php'; 

// Instanciation de la classe Comment
$monComment = new COMMENT();
$monMembre = new MEMBRE();
$monArticle = new ARTICLE();

$validator = Validator::make();

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $validator->addRules([
        ValidationRule::required('libCom'),
        ValidationRule::required('numMemb'),
        ValidationRule::required('numArt'),
    ])->bindValues($_POST);

    if($validator->success()) {
        $libCom = $validator->verifiedField('libCom');
        $numMemb = $validator->verifiedField('numMemb'); 
        $numArt = $validator->verifiedField('numArt');
        $numSeqArt = $monComment->getNextNumCom($numArt);
        
        $monComment->create($numSeqArt, $numArt, $libCom, $numMemb);

        header("Location: $pagePrecedent");
        die();
    } 
}   // Fin if ($_SERVER["REQUEST_METHOD"] == "POST")
// Init variables form
include __DIR__ . '/initComment.php';

include __DIR__ . '/../../layouts/back/head.php';

// affichage des erreurs
$validator->echoErrors();

?>
<form 
    class="admin-form"
    method="POST" 
    action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" 
    enctype="multipart/form-data" 
    accept-charset="UTF-8"
>

    <p class="important">(Tous les champs sont requis)</p>

    <div class="field">
        <label for="numMemb">Quel membre</label>
        <select name="numMemb" id="numMemb">
            <?php 
                $allMembres = $monMembre->get_AllMembres();                    
                foreach($allMembres as $membre) { 
            ?>
                <option <?=$membre['numMemb']==$validator->oldField('numMemb')?'selected':'' ?> value="<?= $membre['numMemb'] ?>" ><?=$membre['pseudoMemb'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="field">
        <label for="numArt">Quel article</label>
        <select name="numArt" id="numArt">
            <?php 
                $allArticles = $monArticle->get_AllArticles();                    
                foreach($allArticles as $article) { 
            ?>
                <option <?=$article['numArt']==$validator->oldField('numArt')?'selected':'' ?> value="<?= $article['numArt'] ?>" ><?=$article['libTitrArt'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="field">
        <label for="libCom">Ajoutez votre commentaire :</label>
        <textarea name="libCom" id="libCom" rows="20" cols="100" placeholder="Votre commentaire"><?=$validator->oldField('libCom') ?></textarea>
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