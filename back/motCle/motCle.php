<?php
<<<<<<< HEAD
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Statut
require_once __DIR__ . '/../../CLASS_CRUD/angle.class.php'; 

// Instanciation de la classe Statut
$monAngle = new ANGLE(); 

$pageTitle = "Gestion de l'Angle";
$pageNav = ['Home:/index1.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createAngle.php" title="Créer un Angle">Créer un angle</a>
	<h3>Toutes les angles</h3>
=======
require_once __DIR__ . '/../../util/index.php';

// Insertion classe MotCle
require_once __DIR__ . '/../../CLASS_CRUD/motcle.class.php';

//Instanciation de la classe MOTCLE
$monMotCle = new MOTCLE();

// Insertion classe Langue
require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php';

// Instanciation de la classe Langue
$maLangue = new LANGUE();

// BBCode

$pageTitle = "Gestion des Mots Clés";
$pageNav = ['Home:/index1.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>

<a class="btn btn-lg" href="./createMotCle.php" title="Créer une Langue">Créer une Langue</a>
	<h3>Tous les mots clés</h3>
>>>>>>> 15431bb8125879c4cfd84c60cd5197f9693c1d43

	<table >
        <thead>
            <tr>
                <th>Numéro</th>
<<<<<<< HEAD
                <th>Libellé</th>
=======
                <th>Nom</th>
>>>>>>> 15431bb8125879c4cfd84c60cd5197f9693c1d43
                <th>Langue</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
<<<<<<< HEAD
        $all = $monAngle->get_AllAngles();
=======
        $all = $monMotCle->get_AllMotCles();
>>>>>>> 15431bb8125879c4cfd84c60cd5197f9693c1d43
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
<<<<<<< HEAD
                <td><h4> <?= $row['numAngl']; ?> </h4></td>
                <td><?= $row['libAngl']; ?></td>
                <td><?= $row['numLang']; ?></td>

                <!-- actions -->
                <td>
                    <a class="btn btn-md" href="./updateAngle.php?id=<?=$row['numAngl']; ?>" title="Modifier l'angle">Modifier</a>
                </td>
                <td>  
                    <!-- lien : test ternaire super admin -->
                    <a class="btn btn-md btn-danger" href="<?= $row['numAngl']!=1?'./deleteAngle.php?id='.$row['numAngl']:'#'; ?>" title="Supprimer l'angle">Supprimer</a>
=======
                <td><h4> <?= $row['numMotCle']; ?> </h4></td>
                <td><?= $row['libMotCle']; ?></td>
                <td><?= $row['numLang']; ?></td>
                
                <!-- actions -->
                <td>
                    <a class="btn btn-md" href="./updateMotCle.php?id=<?=$row['numMotCle']; ?>" title="Modifier le mot clé">Modifier</a>
                </td>
                <td>  
                    <!-- lien : test ternaire super admin -->
                    <a class="btn btn-md btn-danger" href="./deleteMotCle.php?id=<?=$row['numMotCle'] ?>" title="Supprimer le mot clé">Supprimer</a>
>>>>>>> 15431bb8125879c4cfd84c60cd5197f9693c1d43
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<<<<<<< HEAD
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>

=======
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
>>>>>>> 15431bb8125879c4cfd84c60cd5197f9693c1d43
