<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe LikeArt
require_once __DIR__ . '/../../class_crud/likeart.class.php'; 

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
                <th>Membre</th>
                <th>Article</th>
                <th>Liké?</th>
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
                <td><?= $row['pseudoMemb'] ?></td>
                <td><?= $row['libTitrArt'] ?></td>
                <td>
                    <?php if($row['likeA']) { ?>
                        <img width=40 src="<?=webAssetPath('svg/liked.svg') ?>" alt=" ">
                    <?php } else { ?>
                        Non
                    <?php } ?>
                </td>
                <!-- actions -->
                <td>
                    <a class="btn btn-md" href="./updateLikeArt.php?numMemb=<?=$row['numMemb']?>&numArt=<?=$row['numArt']?>" title="Modifier le like">Modifier</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>

