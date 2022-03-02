<?php

//Insertion fichiers utiles
require_once __DIR__ . '/util/index.php';

//Insertion classe Article.class
require_once __DIR__ . '/class_crud/article.class.php';

//Instanciation de la classe Article
$monArticle = new ARTICLE(); 

$allArticles = $monArticle->get_AllArticles();

$pageTitle = "Accueil";

require_once __DIR__ . '/layouts/front/head.php';
?>
<div class="container">
    <div class="home-title primary">
        <h1>Bordeaux Street Art</h1>
    </div>
    <div class="home-title secondary">
        <h2>L<span class="purple">E</span> <span class="bleu">S</span>TR<span class="green">E</span>ET <span class="orange">A</span><span class="bleu">R</span>T À <span class="green">B</span><span class="purple">O</span>RDE<span class="bleu">A</span>U<span class="orange">X</span></h2> 
    </div>
    <?php foreach($allArticles as $article) :?>
        <div class="home-box">
            <div class="home-box-img left">
                <img src="<?= webUploadPath($article['urlPhotArt']) ?>" alt="Image de l'oeuvre nommée : <?= $article['libTitrArt']; ?>">
            </div>
            <div class="home-box-text right">
                <div class="home-box-text-title yellow"><h2><?= $article['libTitrArt']; ?></h2></div>
                <div class="home-box-text-p"><p><?= $article['libChapoArt']; ?></p></div>
                <div class="home-box-text-btn right">
                    <a class="home-box-text-btn-h4" href="<?=webSitePath('/article.php?numArt='.$article['numArt']); ?>"><h4>Lire plus</h4></a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<!--
    <?php
    foreach($allArticles as $article) {
    ?>
    <div class="home-box">
            <div class="home-box-text left">
                <div class="home-box-text-title yellow"><h2><?= $article['libTitrArt']; ?></h2></div>
                <div class="home-box-text-p"><p><?= $article['libChapoArt']; ?></p></div>
                <div class="home-box-text-btn left">
                    <div class="home-box-text-btn-h4">
                    <a class="home-box-text-btn-h4" href="<?=webSitePath('/articleCopy.php?numArt='.$article['numArt']); ?>"><h4>Lire plus</h4></a>
                    </div>
                </div>
            </div>
            <div class="home-box-img right">
            <img src="<?= webUploadPath($article['urlPhotArt']) ?>" alt="Image de l'oeuvre nommée : <?= $article['libTitrArt']; ?>">        </div>
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
