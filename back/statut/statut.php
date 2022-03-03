<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../class_crud/statut.class.php'; 

// Instanciation de la classe Statut
$monStatut = new statut(); 

$pageTitle = "Gestion du Statut";
$pageNav = ['Home:/admin.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createStatut.php" title="Créer un statut">Créer un statut</a>
	<h3>Toutes les statuts</h3>

	<table >
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th class="sticky-right">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
        $all = $monStatut->get_AllStatuts();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><h4> <?= $row['idStat']; ?> </h4></td>
                <td><?= $row['libStat']; ?></td>

                <!-- actions -->
                <td class="actions sticky-right">
                    <a class="btn btn-md" href="./updateStatut.php?id=<?=$row['idStat']; ?>" title="Modifier le statut">Modifier</a>
                    <!-- lien : test ternaire super admin -->
                    <a class="btn btn-md btn-danger" href="<?= $row['idStat']!=1?'./deleteStatut.php?id='.$row['idStat']:'#'; ?>" title="Supprimer le statut">Supprimer</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>

