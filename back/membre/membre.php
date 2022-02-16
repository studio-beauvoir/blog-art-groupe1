<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../CLASS_CRUD/membre.class.php'; 

// Instanciation de la classe langue
$monMembre = new MEMBRE(); 

$pageTitle = "Gestion des Membres";
$pageNav = ['Home:/index1.php', $pageTitle];
require_once __DIR__ . '/../../layouts/back/head.php';
?>
	<a class="btn btn-lg" href="./createMembre.php" title="Créer un membre">Créer un membre</a>
	<h3>Tous les membres</h3>

	<table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Identité</th>
                <th>Pseudo</th>
                <th>eMail</th>
                <th>Date création</th>
                <th>Connexion<br>auto</th>
                <th>Accord<br>RGPD</th>
                <th>Statut</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $all = $monMembre->get_AllMembres();

                foreach($all as $row) {
            ?>
            <tr>
                <td><h4> <?= $row['numMemb']; ?> </h4></td>
                <td> <?= $row['prenomMemb']; ?> </td>
                <td> <?= $row['nomMemb']; ?> </td>
                <td> <?= $row['pseudoMemb']; ?> </td>
                <td> <?= $row['passMemb']; ?> </td>
                <td> <?= $row['eMailMemb']; ?> </td>
                <td> <?= $row['dtCreaMemb']; ?> </td>
                <td> <?= $row['accordMemb']; ?> </td>
                <td> <?= $row['idStat']; ?> </td>
                <td>
                    <a class="btn btn-md" href="./updateMembre.php?id=<?=$row['numMemb']; ?>" title="Modifier le membre">Modifier</a>
                </td>
                <td>
                    <a class="btn btn-md btn-danger" href="./deleteMembre.php?id=<?=$row['numMemb']?>" title="Supprimer le membre">Supprimer</a>
                </td>
            </tr>
            <?php }	?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>