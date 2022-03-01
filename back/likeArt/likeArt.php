<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe LikeArt
require_once __DIR__ . '/../../CLASS_CRUD/likeart.class.php'; 

// Instanciation de la classe LikeArt
$monLikeArt = new LIKEART(); 

$pageTitle = "Gestion du Like";
$pageNav = ['Home:/admin.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createLikeArt.php" title="Créer un Like Article">Créer un like article</a>
	<h3>Toutes les likes articles</h3>

	<table >
        <thead>
            <tr>
                <th>Numéro du membre</th>
                <th>Numéro de l'article</th>
                <th>Like Article</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
        $all = $monLikeArt->get_AllLikesArt();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><h4> <?= $row['numMemb']; ?> </h4></td>
                <td><?= $row['numArt']; ?></td>
                <td><?= $row['likeA']; ?></td>
                <!--<td><a href=" <?= webCrudPath('langue/updateLangue.php?id='.$row['numLang']) ?>"><?= $row['lib1Lang']; ?> </a></td>-->

                <!-- actions -->
                <td>
                    <a class="btn btn-md" href="./updateLikeArt.php?numMemb=<?=$row['numMemb'];?>&numArt=<?=$row['numArt'];?>" title="Modifier le like">Modifier</a>
                </td>
                <td>  
                    <!-- lien : test ternaire super admin -->
                    <a class="btn btn-md btn-danger" href="<?= $row['likeA']!=1?'./deleteLikeArt.php?id='.$row['likeA']:'#'; ?>" title="Supprimer le like">Supprimer</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>

