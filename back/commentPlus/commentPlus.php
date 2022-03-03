<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe commentPlus
require_once __DIR__ . '/../../class_crud/commentplus.class.php'; 

// Instanciation de la classe commentPlus
$monCommentPlus = new commentplus(); 

// Insertion classe Article
require_once __DIR__ . '/../../class_crud/article.class.php'; 

// Instanciation de la classe Article
$monArticle = new article(); 

// Insertion classe comment
require_once __DIR__ . '/../../class_crud/comment.class.php'; 

// Instanciation de la classe comment
$monComment = new comment(); 

$pageTitle = "Gestion du Commentaire Plus";
$pageNav = ['Home:/admin.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createCommentPlus.php" title="Créer un Commentaire Plus">Créer un Commentaire Plus</a>
	<h3>Tous les commentaires plus</h3>

	<table >
        <thead>
            <tr>
                <th>Numéro de Seq Commentaire</th>
                <th>Numéro de l'article</th>
                <th>Numéro de Seq Commentaire Réponse</th>
                <th>Like de l'article Réponse</th>
                <th class="sticky-right">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
        $all = $monCommentPlus->get_AllCommentPlus();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><h4> <?= $row['numSeqCom']; ?> </h4></td>
                <td><?= $row['numArt']; ?></td>
                <td><?= $row['numSeqComR']; ?></td>
                <td><?= $row['numArtR']; ?></td>

                <!-- actions -->
                <td class="actions sticky-right">
                    <a class="btn btn-md" href="./updateCommentPlus.php?numSeqCom=<?=$row['numSeqCom'];?>&numArt=<?=$row['numArt'];?>" title="Modifier le Comment Plus">Modifier</a>
                     <!--lien : test ternaire super admin-->
                    <a class="btn btn-md btn-danger" href="./deleteCommentPlus.php?numSeqCom=<?=$row['numSeqCom'];?>&numArt=<?=$row['numArt'];?>" title="Supprimer le Comment Plus">Supprimer</a>
                </td>
        
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>

