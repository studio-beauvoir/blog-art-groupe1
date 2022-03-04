<?php

//Insertion fichiers utiles
require_once __DIR__ . '/util/index.php';

//Insertion classe Article.class
require_once __DIR__ . '/class_crud/article.class.php';

//Instanciation de la classe Article
$monArticle = new article(); 

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
    <div class="home-articles">
        <?php foreach($allArticles as $article) :?>
            <div class="home-article">
                <div class="home-article-img">
                    <img src="<?= webUploadPath($article['urlPhotArt']) ?>" alt="Image de l'article nommé : <?= $article['libTitrArt']; ?>">
                </div>
                <div class="home-article-text">
                    <h2 class="home-article-title yellow">
                        <a href="<?=webSitePath('/article.php?numArt='.$article['numArt']); ?>">
                            <?= $article['libTitrArt']; ?>
                        </a> 
                    </h2>
                    <p class="home-article-desc"><?= $article['libChapoArt']; ?></p>
                    <a class="home-article-link btn btn-lg" href="<?=webSitePath('/article.php?numArt='.$article['numArt']); ?>"><b>Lire plus</b></a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
<?php require_once __DIR__ . '/layouts/front/foot.php';?>
