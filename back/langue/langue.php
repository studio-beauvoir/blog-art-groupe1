<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../CLASS_CRUD/langue.class.php'; 

// Instanciation de la classe langue
$maLangue = new LANGUE(); 

$pageTitle = "Admin - CRUD Langue";
$pageNav = ['Home:/index1.php', 'CRUD Langue'];
require_once __DIR__ . '/../../layouts/back/head.php';
?>
	<h2>Nouvelle langue :<a href="./createLangue.php"><i>Créer une langue</i></a></h2>
	<h2>Toutes les langues</h2>

	<table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom court</th>
                <th>Nom long</th>
                <th>Pays</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $all = $maLangue->get_AllLangues();

                foreach($all as $row) {
            ?>
            <tr>
                <td><h4> <?= $row['numLang']; ?> </h4></td>
                <td> <?= $row['lib1Lang']; ?> </td>
                <td> <?= $row['lib2Lang']; ?> </td>
                <td> <?= $row['numPays']; ?> </td>
                <td>
                    <a href="./updateLangue.php?id=<?=$row['numLang']; ?>"><i><img src="./../../img/valider-png.png" width="20" height="20" alt="Modifier langue" title="Modifier langue" /></i></a>
                </td>
                <td>
                    <a href="./deleteLangue.php?id=<?=$row['numLang']; ?>"><i><img src="./../../img/supprimer-png.png" width="20" height="20" alt="Supprimer langue" title="Supprimer langue" /></i></a>
                </td>
            </tr>
            <?php }	?>
        </tbody>
    </table>
<?php
require_once __DIR__ . '/../../layouts/back/foot.php';
?>
