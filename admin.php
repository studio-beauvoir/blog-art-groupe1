<?php
require_once __DIR__ . '/util/index.php';



$pageTitle = "Panel admin";
$pageNav = ['Home'];
require_once __DIR__ . '/layouts/back/head.php';
?>
	<div class="box-etat">
	<span class="btn btn-lg doing">En cours de dev</span>
	<span class="btn btn-lg to-test">À tester</span>
	<span class="btn btn-lg done">Terminé et testé</span>
	</div>

	<div class="list-crud">
	<a class="btn btn-lg done" href="./BACK/angle/angle.php">Angle (*)</a>

	<a class="btn btn-lg done" href="./BACK/article/article.php">Article (*)</a>

	<a class="btn btn-lg doing" href="./BACK/comment/comment.php">Commentaire (*)</a>

	<a class="btn btn-lg" href="./BACK/commentplus/commentplus.php">Réponse sur Commentaire</a>

	<a class="btn btn-lg done" href="./BACK/langue/langue.php">Langue (*)</a>

	<a class="btn btn-lg" href="./BACK/likeart/likeart.php">Like Article (*)</a>

	<a class="btn btn-lg" href="./BACK/likecom/likecom.php">Like Commentaire (*)</a>

<!-- Membre (*) - reCaptcha à ajouter -->
	<a class="btn btn-lg to-test" href="./BACK/membre/membre.php">Membre (*)</a>

	<a class="btn btn-lg done" href="./BACK/motcle/motcle.php">Mot-clé (*)</a>

	<a class="btn btn-lg to-test" href="#">Mot-clé Article => dans Article</a>

	<a class="btn btn-lg done" href="./BACK/statut/statut.php">Statut (*)</a>

	<a class="btn btn-lg done" href="./BACK/thematique/thematique.php">Thématique (*)</a>
	</div>
	
	
	<div class="list-crud">
<!-- User (*) - reCaptcha à ajouter -->
	<a class="btn btn-lg" href="./BACK/user/user.php">CRUD : User (*)</a>

	<a class="btn btn-lg" href="./SearchBar/barreF2.php"> Barre de recherche : CONCAT : Un SEUL Mot clé dans articles (*) (F1 en GET)</a>

	<a class="btn btn-lg" href="./SearchBar/barreCONCAT.php"> Barre de recherche : CONCAT : Mots clés dans articles & thématiques (*)</a>

	<a class="btn btn-lg" href="./SearchBar/barreJOIN.php"> Barre de recherche : JOIN : Liste des Mots clés par article (*)</a>
	
	<a class="btn btn-lg" href="./SearchBar/barreLes2.php"> Barre de recherche : Les 2 (CONCAT, JOIN) : Mots clés dans articles, thématiques & liste des Mots clés par article (*)</a>

	</div>
<?php require_once __DIR__ . '/layouts/back/foot.php';?>
