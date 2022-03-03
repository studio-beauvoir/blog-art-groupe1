<?php
// Insertion des fonctions utilitaires
require_once __DIR__ . '/../../util/index.php';

// Insertion classe Langue
require_once __DIR__ . '/../../class_crud/membre.class.php'; 

// Instanciation de la classe langue
$monMembre = new membre(); 

$pageTitle = "Gestion des Membres";
$pageNav = ['Home:/admin.php', $pageTitle];
require_once __DIR__ . '/../../layouts/back/head.php';

?>
	<a class="btn btn-lg" href="./createMembre.php" title="Créer un membre">Créer un membre</a>
	<h3>Tous les membres</h3>

	<table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th colspan="2">Identité</th>
                <th>Pseudo</th>
                <th>eMail</th>
                <th>Date création</th>
                <th>Accord<br>RGPD</th>
                <th>Statut</th>
                <th class="sticky-right">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $all = $monMembre->get_AllMembres();
                $from = 'Y-m-d H:i:s';
                $to = 'd/m/Y H:i:s';
                
                foreach($all as $row) {
            ?>
            <tr>
                <td><h4> <?= $row['numMemb']; ?> </h4></td>
                <td> <?= $row['prenomMemb']; ?> </td>
                <td> <?= $row['nomMemb']; ?> </td>
                <td> <?= $row['pseudoMemb']; ?> </td>
                <td> <?= $row['eMailMemb']; ?> </td>
                <td> <?= dateChangeFormat($row['dtCreaMemb'], $from, $to); ?> </td>
                <td> <?= $row['accordMemb']==true?"Oui":"Non"; ?> </td>
                <td><a href="<?=webCrudPath('statut/updateStatut.php?id='.$row['idStat'])?>"><?= $row['libStat']; ?></a></td>
                <td class="actions sticky-right">
                    <a class="btn btn-md" href="./updateMembre.php?id=<?=$row['numMemb']; ?>" title="Modifier le membre">Modifier</a>
                    <a class="btn btn-md btn-danger" href="./deleteMembre.php?id=<?=$row['numMemb']?>" title="Supprimer le membre">Supprimer</a>
                </td>
            </tr>
            <?php }	?>
        </tbody>
    </table>
<?php require_once __DIR__ . '/../../layouts/back/foot.php'; ?>