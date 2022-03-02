<?php
// Mode DEV
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Thematique
require_once __DIR__ . '/../../class_crud/thematique.class.php'; 

// Instanciation de la classe Thematique
$maThematique = new THEMATIQUE();


// Insertion classe Langue
require_once __DIR__ . '/../../class_crud/langue.class.php'; 

// Instanciation de la classe Langue
$maLangue = new LANGUE();

// BBCode

$pageTitle = "Gestion des thématiques";
$pageNav = ['Home:/admin.php', $pageTitle];
include __DIR__ . '/../../layouts/back/head.php';
?>
    <a class="btn btn-lg" href="./createThematique.php" title="Créer un statut">Créer une thematique</a>
	<h3>Toutes les statuts</h3>

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
        $all = $maThematique->get_AllThematiques();
        // Boucle pour afficher
        foreach($all as $row) {
            // la boucle va écrire le code html juste en dessous
            // on ferme la boucle quelques lignes plus tard
        ?>
            <tr>
                <td><h4> <?= $row['numThem']; ?> </h4></td>
                <td><?= $row['libThem']; ?></td>
                <td><a href="<?=webCrudPath('langue/updateLangue.php?id='.$row['numLang'])?>"><?= $row['lib1Lang']; ?></a></td>

                <!-- actions -->
                <td>
                    <a class="btn btn-md" href="./updateThematique.php?id=<?=$row['numThem']; ?>" title="Modifier">Modifier</a>
                </td>
                <td>  
                    <a class="btn btn-md btn-danger" href="./deleteThematique.php?id=<?=$row['numThem'] ?>" title="Supprimer">Supprimer</a>
                </td>
            </tr>
        <?php }	// End of foreach ?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>