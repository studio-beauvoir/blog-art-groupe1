<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe LikeArt
require_once __DIR__ . '/../../CLASS_CRUD/likecom.class.php'; 

// Instanciation de la classe LikeArt
$monLikeCom = new LIKECOM(); 

$pageTitle = "Gestion du Like Commentaire";
$pageNav = ['Home:/admin.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createLikeCom.php" title="Créer un Like Commentaire">Créer un like de commentaire</a>
	<h3>Tous les likes de commentaires</h3>

	<table >
        <thead>
            <tr>
                <th>Membre</th>
                <th>Commentaire</th>
                <th>Article</th>
                <th>Like?</th>
                <th class="sticky-right">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
        $all = $monLikeCom->get_AllLikesCom();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><?= $row['pseudoMemb']; ?></td>
                <td><a href="<?=webCrudPath('comment/updateComment.php?idCom='.$row['numSeqCom'].'&idArt='.$row['numArt']) ?>">Voir</a></td>
                <td><?= $row['libTitrArt']; ?></td>
                <td>
                    <?php if($row['likeC']) { ?>
                        <img width=40 src="<?=webAssetPath('svg/liked.svg') ?>" alt=" ">
                    <?php } else { ?>
                        Non
                    <?php } ?>
                </td>
                <!--<td><a href=" <?= webCrudPath('langue/updateLangue.php?id='.$row['numLang']) ?>"><?= $row['lib1Lang']; ?> </a></td>-->

                <!-- actions -->
                <td class="actions sticky-right">
                    <a class="btn btn-md" href="./updateLikeCom.php?numMemb=<?=$row['numMemb'];?>&numArt=<?=$row['numArt'];?>&numSeqCom=<?=$row['numSeqCom']?>" title="Modifier le like">Modifier</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>

