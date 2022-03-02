<?php

//Insertion fichiers utiles
require_once __DIR__ . '/util/index.php';

//Insertion classe Article.class
require_once __DIR__ . '/CLASS_CRUD/article.class.php';

//Instanciation de la classe Article
$monArticle = new ARTICLE(); 

// Gestion des erreurs de saisie
$erreur = false;



// controles
// if(!isset($_GET['idArt'])) header("Location: ".webSitePath('/home.php'));
// $numArt = $_GET['idArt'];

// $article = $monArticle->get_1Article($numArt);

// $comment = $monComment->get_1Comment($_GET['idArt'], $_GET['idCom']);

// $membre = $monMembre->get_1Membre($_GET['id'], ['id']);
// if(!$article) header("Location: $pagePrecedent");

$submitBtn = "CRUD";
$pageCrud = "article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn - $pageCrud";
$pageNav = ['Home:/admin.php', $pageTitle];


// $libTitrArt = $article['libTitrArt'];
// $libChapoArt = $article['libChapoArt'];
// $urlPhotArt = $article['urlPhotArt'];

$pageTitle = "Panel admin";
$pageNav = ['Home'];

require_once __DIR__ . '/layouts/front/head.php';
?>
<div class="container">
    <div class="home-title primary">
        <h1>Bordeaux Street Art</h1>
    </div>
    <div class="home-title secondary">
        <h2>L<span class="purple">E</span> <span class="bleu">S</span>TR<span class="green">E</span>ET <span class="orange">A</span><span class="bleu">R</span>T À <span class="green">B</span><span class="purple">O</span>RDE<span class="bleu">A</span>U<span class="orange">X</span></h2> 
    </div>
    <?php
        $all = $monArticle->get_AllArticles();

   
    foreach($all as $row) {
    ?>
    <div>
        <div class="home-box">
            <div class="home-box-img left">
                <img src="<?= webUploadPath($row['urlPhotArt']) ?>" alt="Image de l'oeuvre nommée : <?= $row['libTitrArt']; ?>">
            </div>
            <div class="home-box-text right">
                <div class="home-box-text-title yellow"><h2><?= $row['libTitrArt']; ?></h2></div>
                <div class="home-box-text-p"><p><?= $row['libChapoArt']; ?></p></div>
                <div class="home-box-text-btn right">
                    <a class="home-box-text-btn-h4" href="<?=webSitePath('/articleCopy.php?numArt='.$row['numArt']); ?>"><h4>Lire plus</h4></a>
                </div>
            </div>
        </div>
    <?php }	?>
<!--
    <?php
    foreach($all as $row) {
    ?>
    <div class="home-box">
            <div class="home-box-text left">
                <div class="home-box-text-title yellow"><h2><?= $row['libTitrArt']; ?></h2></div>
                <div class="home-box-text-p"><p><?= $row['libChapoArt']; ?></p></div>
                <div class="home-box-text-btn left">
                    <div class="home-box-text-btn-h4">
                    <a class="home-box-text-btn-h4" href="<?=webSitePath('/articleCopy.php?numArt='.$row['numArt']); ?>"><h4>Lire plus</h4></a>
                    </div>
                </div>
            </div>
            <div class="home-box-img right">
            <img src="<?= webUploadPath($row['urlPhotArt']) ?>" alt="Image de l'oeuvre nommée : <?= $row['libTitrArt']; ?>">        </div>
    </div>
    <?php }	?>
    -->
        <!--
        <div class="home-box">
            <div class="home-box-text left">
                <div class="home-box-text-title yellow"><h2><?=$libTitrArt?></h2></div>
                <div class="home-box-text-p"><p><?=$libChapoArt?></p></div>
                <div class="home-box-text-btn left">
                    <div class="home-box-text-btn-h4">
                        <h4>Lire plus</h4>
                    </div>
                </div>
            </div>
            <div class="home-box-img right">
            <img src=<?=$urlPhotArt?> alt="Image de l'oeuvre nommée : <?=$libTitrArt?>">            </div>
        </div>
    </div>
    <div>
        <div class="home-box">
            <div class="home-box-img left">
            <img src=<?=$urlPhotArt?> alt="Image de l'oeuvre nommée : <?=$libTitrArt?>">            </div>
            <div class="home-box-text right">
                <div class="home-box-text-title yellow"><h2><?=$libTitrArt?></h2></div>
                <div class="home-box-text-p"><p><?=$libChapoArt?></p></div>
                <div class="home-box-text-btn right">
                    <div class="home-box-text-btn-h4">
                        <h4>Lire plus</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-box">
            <div class="home-box-text left">
                <div class="home-box-text-title yellow"><h2><?=$libTitrArt?></h2></div>
                <div class="home-box-text-p"><p><?=$libChapoArt?></p></div>
                <div class="home-box-text-btn left">
                    <div class="home-box-text-btn-h4">
                        <h4>Lire plus</h4>
                    </div>
                </div>
            </div>
            <div class="home-box-img right">
            <img src=<?=$urlPhotArt?> alt="Image de l'oeuvre nommée : <?=$libTitrArt?>">            </div>
        </div>
    </div>
    -->
    <div class="page-change">
        <h3>1/1 ></h3>
    </div>
</div>

<?php require_once __DIR__ . '/layouts/front/foot.php';?>
