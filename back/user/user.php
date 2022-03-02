<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../class_crud/user.class.php'; 

// Instanciation de la classe langue
$monUser = new USER(); 

$pageTitle = "Gestion des Users";
$pageNav = ['Home:/admin.php', $pageTitle];
require_once __DIR__ . '/../../layouts/back/head.php';

?>
	<a class="btn btn-lg" href="./createUser.php" title="Créer un User">Créer un User</a>
	<h3>Tous les Users</h3>

	<table>
        <thead>
            <tr>
                <th>Pseudo User</th>
                <th colspan="2">Identité</th>
                <th>EMail</th>
                <th>Statut</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $all = $monUser->get_AllUsers();
                $from = 'Y-m-d H:i:s';
                $to = 'd/m/Y H:i:s';
                
                foreach($all as $row) {
            ?>
            <tr>
                <td><h4> <?= $row['pseudoUser']; ?> </h4></td>
                <td> <?= $row['nomUser']; ?> </td>
                <td> <?= $row['prenomUser']; ?> </td>
                <td> <?= $row['eMailUser']; ?> </td>
                <td><a href="<?=webCrudPath('statut/updateStatut.php?id='.$row['idStat'])?>"><?= $row['libStat']; ?></a></td>
                <td>
                    <a class="btn btn-md" href="./updateUser.php?pseudoUser=<?=$row['pseudoUser']; ?>" title="Modifier le user">Modifier</a>
                </td>
                <td>
                    <a class="btn btn-md btn-danger" href="./deleteUser.php?pseudoUser=<?=$row['pseudoUser']?>" title="Supprimer le user">Supprimer</a>
                </td>
            </tr>
            <?php }	?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>