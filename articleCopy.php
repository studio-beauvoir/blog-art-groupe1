<?php

//Insertion fichiers utiles
require_once __DIR__ . '/util/index.php';

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
if(!isset($_GET['idArt'])) header("Location: ".webSitePath('/home.php'));
$numArt = $_GET['idArt'];

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




$comments = $monComment->get_AllCommentsByNumArt($numArt);
var_dump($comments);
// $numMemb = $membre['numMemb'];
// $pseudoMemb = $membre['pseudoMemb'];

// $dtCreCom = $comment['dtCreCom'];
// $dtModCom = $comment['dtModCom'];
// $libCom = $comment['libCom'];


include __DIR__ . '/layouts/front/head.php';
?>

<div class="head-bg">
    <img src="<?= webUploadPath($urlPhotArt) ?>" alt="Photo de l'article">
</div>
<div class="head-h1"><h1><?=$libTitrArt?></h1></div>
<div class="head-h2"><h2><span class="bleu"> <?=$libTitrArt?> </span></h2></div>
<div class="head-h4"><h4><?=$libChapoArt?></h4></div>
</div>
<div class="discover">
    <div class="discover-title">
        <h2><?=$libAccrochArt?></h2>
    </div>
</div>
<div class="container articles">
    <div class="artist-box">
        <div class="artist-text">
            <p><?=$parag1Art ?></p>
        </div>
        <div class="artist-title">
            <h2><span class="purple">Regardez j'ai réussi genre</span></h2>
        </div>
    </div>
    <div class="oeuvre">
        <div class="oeuvre-title">
            <h2><span class="green"><?=$libSsTitr1Art ?></span></h2>
        </div>
        <div class="oeuvre-text">
            <p><?=$parag2Art?></p>
        </div>
    </div>
    <div class="expo">
        <div class="expo-title">
            <h2><span class="orange"><?=$libSsTitr2Art ?></span></h2>
        </div>
        <div class="expo-text">
            <p><?=$parag3Art ?></p>           
        </div>
    </div>
    <div class="conclusion">
        <p><?=$libConclArt?></p>
    </div>
    <?php 
        $from = 'Y-m-d H:i:s';
        $to = 'd/m/Y H:i:s';
    ?>
    <div class="articles-end">
        <div class="auteur">
            <p>Publié le <?= dateChangeFormat($dtCreArt, $from, $to); ?> </p>
        </div>

        <div class="likes">
            <p>NbtrucGetLikes personnes aiment cette article<br>On vous invite à faire de même si vous l’avez apprécié !</p>
            <img src="<?=webAssetPath('svg/like.svg') ?>" alt=" ">
        </div>
    </div>
    
    <div class="comments-container">
        <h3>Commentaires</h3>
        <div class="comments" id="comments"></div>


        <!-- template pour le chargement des commentaires via js -->
        <template id="template-comment">
            <div class="comment topbar-blue">
                <data class="comment-id" value="">
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
                        <img src="<?=webAssetPath('svg/like.svg') ?>" alt=" ">
                        <p>18 personnes aiment</p>
                    </div>
                </div>
            </div>
        </template>
            <!-- <div class="comment answer topbar-darkblue">
                <div class="comment-infos">
                    <h4 class="comment-author">Babal_01</h4>
                    <div class="comment-dates">
                        <p class="comment-created-at">Créé le 15/02/2022</p>
                        <p class="comment-modified-at">Modifié le 15/02/2022</p>
                    </div>
                </div>
                <h4 class="comment-content">qsdqsdqsdd</h4>
                <div class="comment-actions">
                    <div class="comment-action">
                        <img src="<?=webAssetPath('svg/comment.svg') ?>" alt=" ">
                        <p>Répondre</p>
                    </div>
                    <div class="comment-action">
                        <img src="<?=webAssetPath('svg/like.svg') ?>" alt=" ">
                        <p>18 personnes aiment</p>
                    </div>
                </div>
            </div> -->
            
    </div>

    <form
        class="add-comments"
        method="POST" 
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>?idArt=<?=$_GET['idArt']?>" 
        enctype="multipart/form-data" 
        accept-charset="UTF-8"
    >   
        <div class="text-comments">
            <h4>Ajouter un commentaire</h4>
        </div>
        <textarea id="comments" name="comments" rows="3" class="add-bloc-comments"></textarea>
        <div class="box-btn">
            <div class="btn-comments">
                <h3>Commenter</h3>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>

<!-- Ajax like & comment  -->
<script src="<?= webAssetPath('js/ajaxCommentLike.js') ?>"></script>
<script>
    const numArt = <?=htmlspecialchars($numArt) ?>;
    const commentsEl = document.getElementById('comments');

    const urlFetchComment = "<?= webSitePath('/api/comment/fetch.php') ?>";
    const urlPostComment = "<?= webSitePath('/api/comment/post.php') ?>";

    fetchComments();
</script>


<?php require_once __DIR__ . '/layouts/front/foot.php';