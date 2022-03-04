<?php

//Insertion fichiers utiles
require_once __DIR__ . '/util/index.php';

//Insertion classe Article.class
require_once __DIR__ . '/class_crud/article.class.php';

//Instanciation de la classe Article
$monArticle = new article(); 

$allArticles = $monArticle->get_AllByMotCle($_GET['motCle']);

$pageTitle = "Accueil";

require_once __DIR__ . '/layouts/front/head.php';
?>
<div class="container">
    <div class="home-title primary">
        <h1>Résultat(s) de votre recherches</h1>
    </div>
    <div class="home-title secondary">
        <h2>R<span class="purple">E</span><span class="bleu">S</span>UL<span class="green">T</span>AT(S) <span class="orange">D</span><span class="bleu">E</span> <span class="green">V</span>O<span class="purple"></span><span class=purple>T</span>RE <span class="bleu">R</span>EC<span class="orange">H</span><span class=purple>E</span>R<span class=bleu>C</span><span class=green>H</span>E</h2> 
    </div>
    <div class="home-articles">
        <?php foreach($allArticles as $article) :?>
            <div class="home-article">
                <div class="home-article-img">
                    <img src="<?= webUploadPath($article['urlPhotArt']) ?>" alt="Image de l'oeuvre nommée : <?= $article['libTitrArt']; ?>">
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

    
    <div class="page-change">
        <h3>1/1 ></h3>
    </div>
</div>

<?php require_once __DIR__ . '/layouts/front/foot.php';?>
