<?php

$submitBtn = "CRUD";
$pageCrud = "article";
$pagePrecedent = "./$pageCrud.php";
$pageTitle = "$submitBtn - $pageCrud";
$pageNav = ['Home:/admin.php', $pageTitle];

require_once __DIR__ . '/../../util/index.php';
require_once __DIR__ . '/../../CLASS_CRUD/article.class.php'; 

$monArticle = new ARTICLE(); 

require_once __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createArticle.php" title="Créer un article">Créer un article</a>
	<h3>Tous les articles</h3>

	<table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Date</th>
                <th>Titre</th>
                <th>Chapeau</th>
                <th>Accroche</th>
                <th>Angle</th>
                <th>Thématique</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $all = $monArticle->get_AllArticles();

                foreach($all as $row) {
            ?>
            <tr>
                <td><h4> <?= $row['numArt']; ?> </h4></td>
                <td> <?= $row['dtCreArt']; ?> </td>
                <td> <?= $row['libTitrArt']; ?> </td>
                <td> <?= $row['libChapoArt']; ?> </td>
                <td> <?= $row['libAccrochArt']; ?> </td>
                <td><a href="<?=webCrudPath('angle/updateAngle.php?id='.$row['numAngl'])?>"><?= $row['libAngl']; ?></a></td>
                <td><a href="<?=webCrudPath('thematique/updateThematique.php?id='.$row['numThem'])?>"><?= $row['libThem']; ?></a></td>
                <td>
                    <a class="btn btn-md" href="./updateArticle.php?id=<?=$row['numArt']; ?>" title="Modifier l'article">Modifier</a>
                </td>
                <td>
                    <a class="btn btn-md btn-danger" href="./deleteArticle.php?id=<?=$row['numArt']?>" title="Supprimer l'article">Supprimer</a>
                </td>
            </tr>
            <?php }	?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>