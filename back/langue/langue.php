<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../class_crud/langue.class.php'; 

// Instanciation de la classe langue
$maLangue = new langue(); 

$pageTitle = "Gestion des Langues";
$pageNav = ['Home:/admin.php', $pageTitle];
require_once __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createLangue.php" title="Créer une langue">Créer une langue</a>
	<h3>Toutes les langues</h3>

	<table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom court</th>
                <th>Nom long</th>
                <th>Pays</th>
                <th class="sticky-right">Action</th>
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
                <td><?= $row['frPays']; ?></td>
                <td class="actions sticky-right">
                    <a class="btn btn-md" href="./updateLangue.php?id=<?=$row['numLang']; ?>" title="Modifier la langue">Modifier</a>
                    <a class="btn btn-md btn-danger" href="./deleteLangue.php?id=<?=$row['numLang']?>" title="Supprimer la langue">Supprimer</a>
                </td>
            </tr>
            <?php }	?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>