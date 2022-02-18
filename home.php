<?php
require_once __DIR__ . '/util/index.php';



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
    <div>
        <div class="home-box">
            <div class="home-box-img left">
                <img src="https://www.francetvinfo.fr/pictures/y7EaVw9xAB21V6QiVl3zmxXz6HQ/752x423/2019/04/12/selor7.png" alt="Image d'une oeuvre de Street Art de l'exposition Fragile située à Bordeaux">
            </div>
            <div class="home-box-text right">
                <div class="home-box-text-title yellow">
                    <h2>Comment n’avez-vous pas pu le voir ?</h2>
                </div>
                <div class="home-box-text-p">
                    <p>Description du blog. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                </div>
                <div class="home-box-text-btn right">
                    <div class="home-box-text-btn-h4">
                        <h4>Lire plus</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-box">
            <div class="home-box-img right">
            <img src="https://www.francetvinfo.fr/pictures/y7EaVw9xAB21V6QiVl3zmxXz6HQ/752x423/2019/04/12/selor7.png" alt="Image d'une oeuvre de Street Art de l'association Mur Du Souffle à Bordeaux">
            </div>
            <div class="home-box-text left">
                <div class="home-box-text-title yellow">
                    <h2>Comment n’avez-vous pas pu le voir ?</h2>
                </div>
                <div class="home-box-text-p">
                    <p>Description du blog. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                </div>
                <div class="home-box-text-btn left">
                    <div class="home-box-text-btn-h4">
                        <h4>Lire plus</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-change">
            <h3>1/1 ></h3>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layouts/front/foot.php';?>
