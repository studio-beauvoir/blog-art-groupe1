<?php

//Insertion fichiers utiles
require_once __DIR__ . '/util/index.php';

require_once __DIR__ . '/middleware/getMember.php';

//Insertion classe Article.class
require_once __DIR__ . '/CLASS_CRUD/article.class.php';

//Instanciation de la classe Article
$monArticle = new ARTICLE(); 

//Insertion classe Angle
require_once __DIR__ . '/CLASS_CRUD/angle.class.php';

//Instanciation de la classe Angle
$monAngle = new ANGLE(); 

//Insertion classe Thématique
require_once __DIR__ . '/CLASS_CRUD/thematique.class.php';

//Instanciation de la classe Thématique
$maThematique = new THEMATIQUE();

//Insertion classe Langue
require_once __DIR__ . '/CLASS_CRUD/langue.class.php';

//Instanciation de la classe Langue
$maLangue = new LANGUE(); 

//Insertion classe Commentaire
require_once __DIR__ . '/CLASS_CRUD/comment.class.php'; 

//Instanciation de la classe Commment
$monComment = new COMMENT(); 

// //Insertion classe Membre
// require_once __DIR__ . '/CLASS_CRUD/membre.class.php'; 

// //Instanciation de la classe Membre
// $monMembre = new MEMBRE();

// Ctrl CIR


// Gestion des erreurs de saisie
$erreur = false;

// Gestion du $_SERVER["REQUEST_METHOD"] => En POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {



    // controle CIR

    // delete effective de l'angle

    $validator = Validator::make([
        ValidationRule::required('idArt'),
        ValidationRule::required('idCom'),
    ])->bindValues($_POST);

    if($validator->success()) {
        $numArt = $validator->verifiedField('idArt');
        $monArticle->delete($numArt);

        $numSeqCom = $validator->verifiedField('idCom');
        $monComment->delete($numSeqCom, $numArt);
    }

    // if($validator->success()) {
    //     $numMemb = $validator->verifiedField('id');
    //     $monMembre->delete($numMemb, $numSeqCom, $numArt);
    // }

}


// controles
if(!isset($_GET['numArt'])) header("Location: ".webSitePath('/home.php'));
$numArt = $_GET['numArt'];

$article = $monArticle->get_1Article($numArt);

// $comment = $monComment->get_1Comment($_GET['idArt'], $_GET['idCom']);

// $membre = $monMembre->get_1Membre($_GET['id'], ['id']);
// if(!$article) header("Location: $pagePrecedent");


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


include __DIR__ . '/layouts/front/head.php';
?>

<div class="head-bg">
    <img src="<?= webUploadPath($urlPhotArt) ?>" alt="Photo de l'article">
</div>
<h1 class="head-h1"><?=$libTitrArt?></h1>
<div class="head-h2"><h2><span class="bleu"> <?=$libTitrArt?> </span></h2></div>
<div class="head-h4"><h4><?=$libChapoArt?></h4></div>
</div>
<div class="discover">
    <h2 class="discover-title"><?=$libAccrochArt?></h2>
</div>
<div class="container articles">
    <div class="artist-box">
        <div class="artist-text">
            <p bbtext><?=$parag1Art ?></p>
        </div>
        <h2 class="artist-title"><span class="purple" id="heading-text">Regardez j'ai réussi genre</span></h2>
    </div>
    <div class="oeuvre">
        <h2 class="oeuvre-title"><span class="green"><?=$libSsTitr1Art ?></span></h2>
        <p class="oeuvre-text">
            <?=$parag2Art?>
        </p>
    </div>
    <div class="expo">
        <h2 class="expo-title"><span class="orange"><?=$libSsTitr2Art ?></span></h2>
        <p class="expo-text"><?=$parag3Art ?></p>           
    </div>
    <div class="conclusion">
        <p><?=$libConclArt?></p>
    </div>
    <div class="articles-end">
        <p class="auteur">Publié le <?= simpleDate($dtCreArt) ?> </p>

        <div class="likes">
            <p>NbtrucGetLikes personnes aiment cette article<br>On vous invite à faire de même si vous l’avez apprécié !</p>
            <img src="<?=webAssetPath('svg/like.svg') ?>" alt=" ">
        </div>
    </div>
    



    <div class="comments-container">
        <h3>Commentaires</h3>

        <h3 id="login-cta" <?=$loggedMember?'style="display:none;"':''?>><a href="<?= webSitePath('/connexion.php') ?>">Connectez-vous</a> pour réagir à l'article</h3>
        <div id="form-comment" <?=$loggedMember?'':'style="display:none;"'?>>   
            <h4>Ajouter un commentaire</h4>
            <textarea rows="3" class="form-comment-textarea"></textarea>
            <button class="form-comment-submit btn btn-lg">Commenter</button>
        </div>

        <div class="comments" id="comments"></div>


        <!-- template pour le chargement des commentaires via js -->
        <template id="template-comment">
            <div class="comment-container">
                <data class="comment-id" value=""></data>
                <div class="comment topbar-blue">
                    <div class="comment-infos">
                        <h4 class="comment-author"></h4>
                        <div class="comment-dates">
                            <p class="comment-created-at"></p>
                            <p class="comment-modified-at"></p>
                        </div>
                    </div>
                    <h4 class="comment-content"></h4>
                    <div class="comment-actions">
                        <div class="comment-action">
                            <img src="<?=webAssetPath('svg/comment.svg') ?>" alt=" ">
                            <p>Répondre</p>
                        </div>
                        <div class="comment-action">
                            <img class="comment-action-like" src="<?=webAssetPath('svg/like.svg') ?>" alt=" ">
                            <p class="comment-action-likesCount"></p>
                        </div>
                    </div>
                </div>
                <div class="comment-answers"></div>
            </div>
        </template>
    </div>


    

    <template id="form-comment-answer-template">
        <div id="form-comment-answer">
            <h4>Ajouter un commentaire</h4>
            <textarea rows="3" class="form-comment-textarea"></textarea>
            <button class="form-comment-submit btn btn-lg">Commenter</button>
        </div>
    </template>

</div>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>

<!-- Editeur bbcode -->
<script src="<?= webAssetPath('js/utils.js') ?>"></script>
<script src="<?= webAssetPath('js/bbEditor.js') ?>"></script>

<!-- Ajax like & comment  -->
<script src="<?= webAssetPath('js/ajaxCommentLike.js') ?>"></script>
<script>
    const numArt = <?=htmlspecialchars($numArt) ?>;

    const formCommentTextArea = document.querySelector('#form-comment .form-comment-textarea');
    const formCommentSubmit = document.querySelector('#form-comment .form-comment-submit');

    formCommentSubmit.addEventListener('click', postComment);

    const commentsEl = document.getElementById('comments');

    const urlFetchComment = "<?= webSitePath('/api/comment/fetch.php') ?>";
    const urlPostComment = "<?= webSitePath('/api/comment/create.php') ?>";
    
    const urlFetchCommentPlus = "<?= webSitePath('/api/commentplus/fetch.php') ?>";
    const urlPostCommentPlus = "<?= webSitePath('/api/commentplus/create.php') ?>";

    fetchComments();

    const editorEls = document.querySelectorAll('p[bbtext]');
    const editors = [];
    for(let editorEl of editorEls) {
        let editor = new bbEditor(editorEl);
        editors.push(
            editor.createDOMText()
        );
    }

    const headingText = document.querySelector('.bb-element-heading');
    document.getElementById('heading-text').innerText = headingText.innerText;
</script>


<?php require_once __DIR__ . '/layouts/front/foot.php';