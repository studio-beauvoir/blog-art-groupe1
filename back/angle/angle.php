<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../class_crud/angle.class.php'; 

// Instanciation de la classe Statut
$monAngle = new ANGLE(); 

$pageTitle = "Gestion de l'Angle";
$pageNav = ['Home:/admin.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createAngle.php" title="Créer un Angle">Créer un angle</a>
	<h3>Toutes les angles</h3>

	<table >
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Libellé</th>
                <th>Langue</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
        $all = $monAngle->get_AllAngles();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><h4> <?= $row['numAngl']; ?> </h4></td>
                <td><?= $row['libAngl']; ?></td>
                <td><a href="<?=webCrudPath('langue/updateLangue.php?id='.$row['numLang'])?>"><?= $row['lib1Lang']; ?></a></td>

                <!-- actions -->
                <td>
                    <a class="btn btn-md" href="./updateAngle.php?id=<?=$row['numAngl']; ?>" title="Modifier l'angle">Modifier</a>
                </td>
                <td>  
                    <!-- lien : test ternaire super admin -->
                    <a class="btn btn-md btn-danger" href="<?= $row['numAngl']!=1?'./deleteAngle.php?id='.$row['numAngl']:'#'; ?>" title="Supprimer l'angle">Supprimer</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>

