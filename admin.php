<?php
require_once __DIR__ . '/util/index.php';



$pageTitle = "Panel admin";
$pageNav = ['Home'];
require_once __DIR__ . '/layouts/back/head.php';
?>
	<div class="list-crud">
		<a class="btn btn-lg" href="./back/angle/angle.php">Angle (*)</a>
		<a class="btn btn-lg" href="./back/article/article.php">Article (*)</a>
		<a class="btn btn-lg" href="./back/comment/comment.php">Commentaire (*)</a>
		<!-- <a class="btn btn-lg">Réponse sur Commentaire</a> -->
		<a class="btn btn-lg" href="./back/langue/langue.php">Langue (*)</a>
		<a class="btn btn-lg" href="./back/likeart/likeArt.php">Like Article (*)</a>
		<a class="btn btn-lg" href="./back/likecom/likeCom.php">Like Commentaire (*)</a>
		<a class="btn btn-lg" href="./back/membre/membre.php">Membre (*)</a>
		<a class="btn btn-lg" href="./back/motcle/motcle.php">Mot-clé (*)</a>
		<!-- <a class="btn btn-lg">Mot-clé Article => dans Article</a> -->
		<a class="btn btn-lg" href="./back/statut/statut.php">Statut (*)</a>
		<a class="btn btn-lg" href="./back/thematique/thematique.php">Thématique (*)</a>
		<a class="btn btn-lg" href="./back/user/user.php">CRUD : User (*)</a>
	</div>
	
	
	<!-- <div class="list-crud">
		<a class="btn btn-lg" href="./SearchBar/barreF2.php"> Barre de recherche : CONCAT : Un SEUL Mot clé dans articles (*) (F1 en GET)</a>
		<a class="btn btn-lg" href="./SearchBar/barreCONCAT.php"> Barre de recherche : CONCAT : Mots clés dans articles & thématiques (*)</a>
		<a class="btn btn-lg" href="./SearchBar/barreJOIN.php"> Barre de recherche : JOIN : Liste des Mots clés par article (*)</a>
		<a class="btn btn-lg" href="./SearchBar/barreLes2.php"> Barre de recherche : Les 2 (CONCAT, JOIN) : Mots clés dans articles, thématiques & liste des Mots clés par article (*)</a>
	</div> -->
<?php require_once __DIR__ . '/layouts/back/foot.php';?>
