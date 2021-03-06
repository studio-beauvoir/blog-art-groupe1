<?php
require_once __DIR__ . '/../../util/index.php';

// Insertion classe MotCle
require_once __DIR__ . '/../../class_crud/motcle.class.php';

//Instanciation de la classe motcle
$monMotCle = new motcle();

// Insertion classe Langue
require_once __DIR__ . '/../../class_crud/langue.class.php';

// Instanciation de la classe Langue
$maLangue = new langue();

// BBCode

$pageTitle = "Gestion des Mots Clés";
$pageNav = ['Home:/admin.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>

<a class="btn btn-lg" href="./createMotCle.php" title="Créer un mot clé">Créer un mot clé</a>
	<h3>Tous les mots clés</h3>

	<table >
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Langue</th>
                <th class="sticky-right">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Appel méthode : Get tous les statuts en BDD
        $all = $monMotCle->get_AllMotCles();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><h4> <?= $row['numMotCle']; ?> </h4></td>
                <td><?= $row['libMotCle']; ?></td>
                <td><a href="<?=webCrudPath('langue/updateLangue.php?id='.$row['numLang'])?>"><?= $row['lib1Lang']; ?></a></td>
                
                <!-- actions -->
                <td class="actions sticky-right">
                    <a class="btn btn-md" href="./updateMotCle.php?id=<?=$row['numMotCle']; ?>" title="Modifier le mot clé">Modifier</a>
                    <!-- lien : test ternaire super admin -->
                    <a class="btn btn-md btn-danger" href="./deleteMotCle.php?id=<?=$row['numMotCle'] ?>" title="Supprimer le mot clé">Supprimer</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>
